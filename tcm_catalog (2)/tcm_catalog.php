<?php
/*
Plugin Name: TCM Catalog
Description: This plugin makes a catalog using the WordPress database.
Author: Timothy Martin
*/
register_activation_hook( __FILE__, 'activate');
register_uninstall_hook( __FILE__, 'uninstall');
define( 'TCM_CATALOG__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TCM_CATALOG__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
add_action('admin_menu', 'myMenu');

require_once(TCM_CATALOG__PLUGIN_DIR.'tcm_catalog_functions.php');
require_once(TCM_CATALOG__PLUGIN_DIR.'tcm_catalog_database_functions.php');
function myMenu()
{
    add_menu_page('TCM Catalog Options', 'TCM Catalog', 'manage_options', 'tcm_catalog.php', 'tcm_catalogPage');
    add_menu_page('TCM Database', 'TCM Database', 'manage_options', 'tcm_catalog_database_functions.php', 'tcm_databasePage');
}
function activate()
{
    createTables();
}
function uninstall()
{
    dropTables();
}