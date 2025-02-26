<?php 

function redirect_subscribers_from_dashboard() {
    if (is_admin() && !current_user_can('edit_posts') && !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('admin_init', 'redirect_subscribers_from_dashboard');


function hide_admin_bar_for_subscribers() {
    if (!current_user_can('edit_posts')) {
        add_filter('show_admin_bar', '__return_false');
    }
}
add_action('after_setup_theme', 'hide_admin_bar_for_subscribers');

function redirect_profile_if_not_logged_in() {
    if (is_page('profile') && !is_user_logged_in()) {
        wp_redirect(home_url('/login/'));
        exit;
    }
}
add_action('template_redirect', 'redirect_profile_if_not_logged_in');