<?php
function volleynator_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
		if (isset($_GET['settings-updated'])) {
	      // add settings saved message with the class of "updated"
	  add_settings_error('wporg_messages', 'wporg_message', __('Settings Saved', 'wporg'), 'updated');
	  }
		?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg_options"
            settings_fields('volleynator_settings');
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections('volleynator_settings');
            // output save settings button
            submit_button('Speichern'); ?>
        </form>
    </div>
    <?php

}

function volleynator_settings_init()
{
    register_setting($option_group = 'volleynator_settings', $option_name = 'volleynator_settings_username');
		register_setting($option_group = 'volleynator_settings', $option_name = 'volleynator_settings_password');
		register_setting($option_group = 'volleynator_settings', $option_name = 'volleynator_settings_api_key');
    register_setting($option_group = 'volleynator_settings', $option_name = 'volleynator_settings_country');

    add_settings_section(
        $id = 'volleynator_settings_section_auth',
        $title = __('Volleynator Einstellungen', 'volleynator_settings'),
        $callback = 'volleynator_settings_section_callback',
        $page = 'volleynator_settings',
				$args = []
    );

    add_settings_field(
        $id = 'volleynator_settings_username',
        $title = __('Benutzername', 'volleynator_settings_username'),
        $callback = 'volleynator_settings_username_callback',
        $page = 'volleynator_settings',
        $section = 'volleynator_settings_section_auth',
				$args =  []
    );
		add_settings_field(
        $id = 'volleynator_settings_password',
        $title = __('Passwort', 'volleynator_settings_password'),
        $callback = 'volleynator_settings_password_callback',
        $page = 'volleynator_settings',
        $section = 'volleynator_settings_section_auth',
				$args =  []
    );
		add_settings_field(
        $id = 'volleynator_settings_api_key',
        $title = __('API Key', 'volleynator_settings_api_key'),
        $callback = 'volleynator_settings_api_key_callback',
        $page = 'volleynator_settings',
        $section = 'volleynator_settings_section_auth',
				$args =  []
    );
    add_settings_field(
        $id = 'volleynator_settings_country',
        $title = __('Land', 'volleynator_settings_country'),
        $callback = 'volleynator_settings_country_callback',
        $page = 'volleynator_settings',
        $section = 'volleynator_settings_section_auth',
				$args =  []
    );

}

function volleynator_settings_section_callback($args)
{
    return;
}

function volleynator_settings_username_callback($args)
{
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('volleynator_settings_username');
  	// output the field
    ?>
		<input type="text" name="volleynator_settings_username" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
		<?php
}

function volleynator_settings_password_callback($args)
{
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('volleynator_settings_password');
  	// output the field
    ?>
		<input type="password" name="volleynator_settings_password" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
		<?php
}

function volleynator_settings_api_key_callback($args)
{
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('volleynator_settings_api_key');
  	// output the field
    ?>
		<input type="text" size="75" name="volleynator_settings_api_key" value="<?php echo isset($setting) ? esc_attr($setting) : ''; ?>">
		<?php
}

function volleynator_settings_country_callback($args)
{
  // get the value of the setting we've registered with register_setting()
  $setting = get_option('volleynator_settings_country');
  // output the field
  ?>
  <select name="volleynator_settings_country">
    <?php
      $selectedCountry = $setting;

      foreach(array('Deutschland', 'Oesterreich') as $country) {
          $optionHtml = '<option';
          if ($country==$selectedCountry) {
            $optionHtml = $optionHtml . ' selected=selected';
          }
          $optionHtml = $optionHtml . ' name="' . $country . '" value="' . $country . '">' . $country . '</option>';
         print($optionHtml);
      }
     ?>
  </select>
  <?php
}

function volleynator_options_page()
{
    add_menu_page(
        $page_title = 'Volleynator',
        $menu_title = 'Volleynator',
        $capability = 'manage_options',
        $menu_slug = 'volleynator_settings',
        $function = 'volleynator_options_page_html',
        $icon_url = plugin_dir_url(__FILE__) . 'volleynator-logo.png',
        $position = 200
    );
}

add_action('admin_menu', 'volleynator_options_page');
add_action('admin_init', 'volleynator_settings_init');
