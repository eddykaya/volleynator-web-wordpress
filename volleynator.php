<?php
    /**
     * @version 2.0.0
     */
    /*
    Plugin Name: Volleynator-Web
    Plugin URI: https://www.volleynator.de/site/volleynator-web/
    Description: Display Volleyball results  on your website
    Author: Edwin Rolle
    Version: 2.0.0
    Author URI: https://www.volleynator.de
    Text Domain: volleynator-web
    */

include 'config/configuration.php';

function volleynator_matchplan($atts = [], $content = null)
{
  $response = volleynator_fetch_matchplan(strtolower($atts['association']), $atts['league_id'], $atts['competition_id']);

  $highlighted_team = $atts['team'];

  if (isset($response)) {
      $matches = array_filter($response->matches, function($m) use ($highlighted_team) {return $m->home == $highlighted_team || $m->guest == $highlighted_team;});

      usort($matches, function ($a, $b) {
          return strtotime($a->matchDate) - strtotime($b->matchDate);
      });

      $tBody = "";

      foreach ($matches as $item) {
          $tBody = $tBody . "
          <tr>
            <td>" . volleynator_get_match_date($item, $highlighted_team) . " - " . volleynator_get_start_time($item, $highlighted_team) . "</td>
            <td>" . volleynator_get_home($item, $highlighted_team) . "</td>
            <td>" . volleynator_get_guest($item, $highlighted_team) . "</td>
            <td>" . volleynator_get_result_points($item, $highlighted_team) . "</td>
          </tr>";
      };

      $content = "
        <table class='volleynator_matchplan'>
          <thead>
            <tr>
              <th>Datum/ Uhrzeit</th>
              <th>Heim</th>
              <th>Gast</th>
              <th>Ergebnis</th>
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

function volleynator_table($atts = [], $content = null)
{
    $response = volleynator_fetch_table(strtolower($atts['association']), $atts['league_id'], $atts['competition_id']);

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
							<td>" . volleynator_get_position($item, $highlighted_team) . "</td>
							<td>" . volleynator_get_team($item, $highlighted_team) . "</td>
							<td>" . volleynator_get_games($item, $highlighted_team) . "</td>
							<td>" . volleynator_get_sets($item, $highlighted_team) . "</td>
							<td>" . volleynator_get_points($item, $highlighted_team) . "</td>
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

function volleynator_get_position($table_entry, $highlighted_team)
{
    $response = "";
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $table_entry->position . "</b>";
    } else {
        $response = $table_entry->position;
    }
    return $response;
}

function volleynator_get_match_date($match, $highlighted_team)
{
    $response = "";
    if ($match->home == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $match->matchDate . "</b>";
    } else {
        $response = $match->matchDate;
    }
    return $response;
}

function volleynator_get_home($match, $highlighted_team)
{
    $response = "";
    if ($match->home == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $match->home . "</b>";
    } else {
        $response = $match->home;
    }
    return $response;
}

function volleynator_get_guest($match, $highlighted_team)
{
    $response = "";
    if ($match->home == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $match->guest . "</b>";
    } else {
        $response = $match->guest;
    }
    return $response;
}

function volleynator_get_result_points($match, $highlighted_team)
{
    $response = "";
if ($match->home == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $match->resultPoints . "</b>";
    } else {
        $response = $match->resultPoints;
    }
    return $response;
}

function volleynator_get_start_time($match, $highlighted_team)
{
    $response = "";
    $start_time_minutes = $match->startTime[1];
    if ($start_time_minutes == 0) {
      $start_time_minutes = "00";
    }
    $start_time = $match->startTime[0] . ":" . $start_time_minutes;
    if ($match->home == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $start_time . "</b>";
    } else {
        $response = $start_time;
    }
    return $response;
}

function volleynator_get_games($table_entry, $highlighted_team)
{
    $response = "";
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $table_entry->gamesTotal . "</b>";
    } else {
        $response = $table_entry->gamesTotal;
    }
    return $response;
}

function volleynator_get_sets($table_entry, $highlighted_team)
{
    $response = "";
    $sets = $table_entry->positiveSets . ":" . $table_entry->negativeSets;
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $sets . "</b>";
    } else {
        $response = $sets;
    }
    return $response;
}

function volleynator_get_points($table_entry, $highlighted_team)
{
    $response = "";
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $table_entry->points . "</b>";
    } else {
        $response = $table_entry->points;
    }
    return $response;
}

function volleynator_get_team($table_entry, $highlighted_team)
{
    $response = "";
    if ($table_entry->team == $highlighted_team) {
        $response = '<b class="volleynator_team_highlight">' . $table_entry->team . "</b>";
    } else {
        $response = $table_entry->team;
    }
    return $response;
}

function volleynator_fetch_table($association, $league_id, $competition_id)
{
    $url = volleynator_get_url($association, $league_id, $competition_id, 'table');
    $args = volleynator_get_request_args();
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

function volleynator_fetch_matchplan($association, $league_id, $competition_id)
{
    $url = volleynator_get_url($association, $league_id, $competition_id, 'matchplan');
    $args = volleynator_get_request_args();
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

function volleynator_get_url($association, $league_id, $competition_id, $type)
{
    $country = get_option('volleynator_settings_country');
    $host_name;
    if ($country == 'Deutschland') {
      $host_name = 'https://de2.prod.volleynator.de/associations/';
    }
    if ($country == 'Oesterreich') {
        $host_name = 'https://at.prod.volleynator.de/associations/';
    }
    return $host_name . $association . '/leagues/' . $league_id . '/competitions/' . $competition_id . '/' . $type;
}

function volleynator_get_request_args()
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
add_shortcode('volleynator_matchplan', 'volleynator_matchplan');
