<?php
    /**
     * @package Hello_Dolly
     * @version 0.0.1
     */
    /*
    Plugin Name: Volleynator-Web
    Plugin URI: https://www.volleynator.de/site/volleynator-web/
    Description: Display Volleyball results  on your website
    Author: Edwin Rolle
    Version: 1.0.0
    Author URI: https://www.volleynator.de
    Text Domain: volleynator-web
    */

include 'config/configuration.php';

function volleynator_table($atts = [], $content = null)
{
    $response = fetchTable(strtolower($atts['association']), $atts['league_id'], $atts['competition_id']);

    $highlighted_team = $atts['team'];

    if (isset($response)) {
        $tBody = "";

        usort($response->tableEntries, function ($a, $b) {
            if (intval($a->position) < intval($b->position)) {
                return -1;
            } else {
                return 1;
            }
        });

        foreach ($response->tableEntries as $item) {
            $tBody = $tBody . "
						<tr>
							<td>" . get_position($item, $highlighted_team) . "</td>
							<td>" . get_team($item, $highlighted_team) . "</td>
							<td>" . get_games($item, $highlighted_team) . "</td>
							<td>" . get_sets($item, $highlighted_team) . "</td>
							<td>" . get_points($item, $highlighted_team) . "</td>
						</tr>";
        };

        $content = "
					<table class='volleynator_table'>
						<thead>
							<tr>
								<th>#</th>
								<th>Mannschaft</th>
								<th>Spiele</th>
								<th>Sätze</th>
								<th>Punkte</th>
							</tr>
						</thead>
						<tbod>"
                            . $tBody .
                        "</tbody>
					</table>
					";
        return $content;
    }
    return "<p>Konnte Tabelle nicht laden</p>";
}

function get_position($table_entry, $highlighted_team)
{
    $response = "";
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class=volleynator_team_highlight">' . $table_entry->position . "</b>";
    } else {
        $response = $table_entry->position;
    }
    return $response;
}

function get_games($table_entry, $highlighted_team)
{
    $response = "";
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class=volleynator_team_highlight">' . $table_entry->gamesTotal . "</b>";
    } else {
        $response = $table_entry->gamesTotal;
    }
    return $response;
}

function get_sets($table_entry, $highlighted_team)
{
    $response = "";
    $sets = $table_entry->positiveSets . ":" . $table_entry->negativeSets;
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class=volleynator_team_highlight">' . $sets . "</b>";
    } else {
        $response = $sets;
    }
    return $response;
}

function get_points($table_entry, $highlighted_team)
{
    $response = "";
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class=volleynator_team_highlight">' . $table_entry->points . "</b>";
    } else {
        $response = $table_entry->points;
    }
    return $response;
}

function get_team($table_entry, $highlighted_team)
{
    $response = "";
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class=volleynator_team_highlight">' . $table_entry->team . "</b>";
    } else {
        $response = $table_entry->team;
    }
    return $response;
}

function fetchTable($association, $league_id, $competition_id)
{
    $url = get_url($association, $league_id, $competition_id);
    $args = getRequestArgs();
    $http_response = wp_remote_get($url, $args);
    $response_json = json_decode(wp_remote_retrieve_body($http_response));

    $response_code = wp_remote_retrieve_response_code($http_response);

    if ($response_code == 200) {
        return $response_json;
    } else {
        print "$response_code";
        return;
    }
}

function get_url($association, $league_id, $competition_id)
{
    $country = get_option('volleynator_settings_country');
    if ($country == 'Deutschland') {
        $url = 'https://de.prod.volleynator.de/ivolley-server/service/associations/' . $association . '/table/byCompetitionName?competitionName=' . rawurlencode($competition_id) . '&leagueName=' . rawurlencode($league_id);
        return $url;
    }
    if ($country == 'Oesterreich') {
        return 'https://at.prod.volleynator.de/associations/' . $association . '/leagues/' . $league_id . '/competitions/' . $competition_id . '/table';
    }
}

function getRequestArgs()
{
    $username = get_option('volleynator_settings_username');
    $password = get_option('volleynator_settings_password');
    $api_key = get_option('volleynator_settings_api_key');
    return array(
        'sslverify' => false,
    'headers' => array(
            'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
            'X-api-key' => $api_key
    ));
}

add_shortcode('volleynator_table', 'volleynator_table');
