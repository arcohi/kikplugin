<?php


/**
 * Plugin Name: Kikplug
 * Description: A custom WordPress plugin that creates a humanbenchmark-like addon.
 * Version: 1.0
 * Author: Patryk Kik
 */


if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Include necessary files
// include_once plugin_dir_path(__FILE__) . 'includes/functions.php';

// Register hooks
register_activation_hook(__FILE__, 'kik_plugin_activate');
register_deactivation_hook(__FILE__, 'kik_plugin_deactivate');

function kik_plugin_activate() {
    // Code to run on activation 
}

function kik_plugin_deactivate() {
    // Code to run on deactivation 
}

function kik_plugin_menu() {
    add_menu_page(
        'My Plugin Settings',
        'My Plugin',
        'manage_options',
        'my-plugin',
        'kik_plugin_settings_page',
        'dashicons-admin-generic',
        90
    );
}
add_action('admin_menu', 'kik_plugin_menu');

function kik_plugin_settings_page() {
    echo '<div class="wrap"><h1>Kik Plugin Page</h1></div>';
}


function kik_enqueue_front_scripts() {
    wp_enqueue_style('kik-style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('kik-script', plugin_dir_url(__FILE__) . 'js/kikjs.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'kik_enqueue_front_scripts');


function kik_enqueue_admin_scripts($hook) {
    if ($hook !== 'toplevel_page_kik-plugin') return;
    wp_enqueue_script('my-plugin-admin-script', plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'kik_enqueue_admin_scripts');