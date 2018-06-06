# Volleynator Web - A plugin to display volleyball results

## Configuration
The plugin needs some parameters in order to work properly. If you wish to use the plugin with tables from the DVV Bundesliga, you can use the following standard credentials:
* Username: volleynator-web-dvv
* Password: volleynator-web-dvv
* API Key:yQXQ4mqDvlGd2eVxeeaKiWPt49euUpAArzFsbLhhazJvlZTMGwejqHEYIMfxsmoh
For all other associations, you need to buy another API key. See https://www.volleynator.de

### Username
You need a username to use the plugin

### Password
You need a password to use the plugin

### API Key
You need an APY key to use the plugin

## Usage
Insert the shortcode [volleynator_table] into any page or post you like.

### Shortcode parameters
Below you can find a list of paramters the shortcode needs. All parameters are mandatory.

#### team
The team you wish to highlight in the table. All elements in the highlighted row get the class volleynator_team_highlight so that you can add custom styles.

#### association
The association of the league you wish to display. Available associations are:
* DVV

#### league_id
The ID of the league. You can find a list of IDs under https://www.volleynator.de

#### competition_id
The ID of the competition. You can find a list of IDs under https://www.volleynator.de


### Example usage:
[volleynator_table team='VfB Friedrichshafen' association='DVV' league_id='1. Bundesliga Männer' competition_id='1. Bundesliga Männer']
