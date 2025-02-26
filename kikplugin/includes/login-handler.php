<?php 




// Start a session (if not already started)
function cpr_start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'cpr_start_session');

// Track failed login attempts
function cpr_track_failed_login($username) {
    if (!session_id()) {
        session_start();
    }
    
    if (!isset($_SESSION['failed_attempts'])) {
        $_SESSION['failed_attempts'] = 0;
    }

    $_SESSION['failed_attempts']++;

    // Reset after successful login
    if ($_SESSION['failed_attempts'] >= 3) {
        $_SESSION['show_reset_link'] = true;
    }
}
add_action('wp_login_failed', 'cpr_track_failed_login');

// Reset attempts after successful login
function cpr_reset_failed_attempts($user_login, $user) {
    if (!session_id()) {
        session_start();
    }
    $_SESSION['failed_attempts'] = 0;
    $_SESSION['show_reset_link'] = false;
}
add_action('wp_login', 'cpr_reset_failed_attempts', 10, 2);

// Add "Forgot Password?" link only after 3 failed attempts
function cpr_add_reset_password_link() {
    if (!session_id()) {
        session_start();
    }

    if (isset($_SESSION['show_reset_link']) && $_SESSION['show_reset_link']) {
        if(get_option('kik_reset_password_page_id')){
            echo '<p><a href="'.get_permalink(get_option('kik_reset_password_page_id')). '">Forgot your password?</a></p>';
        }else{
            echo '<p><a href="/reset-password/">Forgot your password?</a></p>';
        }
    }
}
add_action('login_form', 'cpr_add_reset_password_link');