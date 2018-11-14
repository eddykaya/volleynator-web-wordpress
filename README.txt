=== Volleynator Web ===
Contributors: eddykaya99
Donate link: https://www.volleynator.de/page/support/
Tags: volleyball, results, tables
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 4.6
Requires PHP: 5.2.4
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

A plugin which enables you to display volleyball tables from germany and austria on your wordpress website

== Installation ==

Download and install the plugin from the wordpress plugin store.

== Changelog ==
= 2.0.0 =
* Moved plugin to new backend
= 0.0.2 =
* Added shortcode to display tables

== Configuration ==

The plugin needs some parameters in order to work properly. If you wish to use the plugin with tables from the DVV Bundesliga, you can use the standard credentials you can find in my github repository:
https://github.com/eddykaya/volleynator-web-wordpress

For all other associations, you need to buy another API key. See https://www.volleynator.de

= Username =
You need a username to use the plugin

= Password =
You need a password to use the plugin

= API Key =
You need an APY key to use the plugin

== Usage ==
Insert the shortcode [volleynator_table] into any page or post you like.

= Shortcode parameters =
Below you can find a list of paramters the shortcode needs. All parameters are mandatory.

1. team
The team you wish to highlight in the table. All elements in the highlighted row get the class volleynator_team_highlight so that you can add custom styles.

2. association
The association of the league you wish to display. Available associations are:
* DVV

3. league_id
The ID of the league. You can find a list of IDs under https://volleynator.de/page/competition-ids/

4. competition_id
The ID of the competition. You can find a list of IDs under https://volleynator.de/page/competition-ids/

== Example usage ==
[volleynator_table team='VfB Friedrichshafen' association='DVV' league_id='1. Bundesliga Männer' competition_id='1. Bundesliga Männer']
[volleynator_matchplan team='VfB Friedrichshafen' association='DVV' league_id='1. Bundesliga Männer' competition_id='1. Bundesliga Männer']
