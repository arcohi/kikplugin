<?php  

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;
$table_name = $wpdb->prefix . 'kik_table';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

// Delete plugin options
delete_option('my_plugin_option');