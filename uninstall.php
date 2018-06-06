<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

delete_option('volleynator_settings_username');
delete_option('volleynator_settings_password');
delete_option('volleynator_settings_api_key');
delete_option('volleynator_settings_country');

?>
