<?php


/**
 * Plugin Name: Kikplug new
 * Description: A custom WordPress plugin that creates a humanbenchmark-like addon.
 * Version: 1.0
 * Author: Patryk Kik
 */


if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Include necessary files
// include_once plugin_dir_path(__FILE__) . 'includes/functions.php';

require_once plugin_dir_path(__FILE__) . 'includes/user-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/register-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/login-handler.php';
require_once plugin_dir_path(__FILE__) . 'templates/register-form.php';
require_once plugin_dir_path(__FILE__) . 'templates/login-form.php';
// require_once plugin_dir_path(__FILE__) . 'templates/.php';


// Register hooks
register_activation_hook(__FILE__, 'kik_plugin_activate');
register_deactivation_hook(__FILE__, 'kik_plugin_deactivate');

function kik_plugin_activate() {
    // Code to run on activation 

    // create reaction time table

    //create number sequence memory, table if not created

    //create kik_users table, if not created
    // create_users_table();
    
    // add register to menu
    // file form to register php code

    // add login to menu
    //file form to login php code

    // create reaction testing page
    // create number sequence memory testing page
    // create user profile page with user stats
}

function kik_plugin_deactivate() {
    // Code to run on deactivation 

    // remove register from menu
    // remove login from menu
    // remove reaction testing page
    // remove number sequence memory testing page
    // remove user profile page with user stats

    
    

}
// ON UNINSTALL
// init deactivate function, then:
// destroy all tables created by plugin



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





// Function to create Register and Login pages on plugin activation
function kik_register_auth_pages() {
    // Create Register Page
    $page = get_page_by_path('register');
    if ($page == NULL) {
        $page_id = wp_insert_post(array(
            'post_title'    => 'Register',
            'post_name'     => 'register',
            'post_content'  => '[kik_register_form]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ));
        if ($page_id && !is_wp_error($page_id)) {
            update_option('kik_register_page_id', $page_id); // Save in WP options table
        }
    }else {
        update_option('kik_register_page_id', $page->ID); // Ensure ID is saved if page already exists
    }
}

// Hook function to run on plugin activation
register_activation_hook(__FILE__, 'kik_register_auth_pages');

function kik_login_auth_page() {
    $page = get_page_by_path('login');
    

 // Create Login Page
    if ($page == NULL) {
        $page_id = wp_insert_post(array(
            'post_title'    => 'Login',
            'post_name'     => 'login',
            'post_content'  => '[kik_login_form]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ));
        if ($page_id && !is_wp_error($page_id)) {
            update_option('kik_login_page_id', $page_id); // Save in WP options table
        }
    }else {
        update_option('kik_login_page_id', $page->ID); // Ensure ID is saved if page already exists
    }
}
register_activation_hook(__FILE__, 'kik_login_auth_page');


// Create Profile Page Programmatically
function kik_create_profile_page() {
    $page = get_page_by_path('profile');

    if ( $page == NULL) {
        $page_id = wp_insert_post(array(
            'post_title'    => 'Profile',
            'post_name'     => 'profile',
            'post_content'  => '[kik_profile_page]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ));
         if ($page_id && !is_wp_error($page_id)) {
            update_option('kik_profile_page_id', $page_id); // Save in WP options table
        }
    }else {
        update_option('kik_profile_page_id', $page->ID); // Ensure ID is saved if page already exists
    }
    
}


register_activation_hook(__FILE__, 'kik_create_profile_page');


// Display Profile Page
function kik_profile_page() {
    if (!is_user_logged_in()) {
        wp_redirect(site_url('/login/'));
        exit;
    }

    $current_user = wp_get_current_user();
    ob_start(); ?>
<h2>Profile Page</h2>
<p>Welcome, <?php echo esc_html($current_user->display_name); ?>!</p>
<p>Email: <?php echo esc_html($current_user->user_email); ?></p>
<a href="<?php echo '/login/' ?>">Logout</a>
<?php
    return ob_get_clean();
}
add_shortcode('kik_profile_page', 'kik_profile_page');


// Create Profile Page Programmatically
function kik_reset_password_page() {
    $page = get_page_by_path('reset-password');
    if ($page == NULL) {
        $page_id = wp_insert_post(array(
            'post_title'    => 'Reset Password',
            'post_name'     => 'reset-password',
            'post_content'  => '[kik_reset_passwd_page]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ));
     if ($page_id && !is_wp_error($page_id)) {
            update_option('kik_reset_password_page_id', $page_id); // Save in WP options table
        }
    }else {
        update_option('kik_reset_password_page_id', $page->ID); // Ensure ID is saved if page already exists
    }
    
}


register_activation_hook(__FILE__, 'kik_reset_password_page');


function kik_reset_passwd_page_content(){
    ob_start();
    // session_start(); // Start session to track failed attempts


    // Handle password reset request
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
        $user_login = sanitize_text_field($_POST['user_login']);
        $user = get_user_by('login', $user_login) ?: get_user_by('email', $user_login);

        if ($user) {
            $reset_key = get_password_reset_key($user);
            $reset_link = network_site_url("reset-password?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login));

            // Send email
            wp_mail($user->user_email, "Password Reset Request", "Click here to reset your password: $reset_link");

            echo "<p>Password reset link sent to your email.</p>";
            $_SESSION['failed_attempts'] = 0; // Reset failed attempts
        } else {
            echo "<p>User not found. Please try again.</p>";
        }
    }

?>
<h2>Forgot Password</h2>
<form method="POST">
    <label>Enter your username or email:</label>
    <input type="text" name="user_login" required>
    <button type="submit" name="reset_password">Reset Password</button>
</form>
<?php  
    return ob_get_clean();
}

add_shortcode('kik_reset_passwd_page', 'kik_reset_passwd_page_content');





// Enqueue scripts
function rtt_enqueue_scripts() {
    wp_enqueue_script('rtt-script', plugin_dir_url(__FILE__) . 'js/kik-rt.js', array('jquery'), null, true);
    wp_localize_script('rtt-script', 'rtt_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'rtt_enqueue_scripts');

// Shortcode to display the reaction timer
function rtt_shortcode() {
    ob_start(); ?>
<div id="reaction-timer">
    <div id="reaction-box" class="start"
        style="width: 100%; height: 200px; background-color: red; text-align: center; line-height: 200px; color: white; cursor: pointer;">
        Click to Start
    </div>
    <p id="reaction-time"></p>
    <button id="send-score" style="display:none;">Send Score</button>
</div>
<?php
    return ob_get_clean();
}
add_shortcode('reaction_timer', 'rtt_shortcode');

// Handle AJAX request to save reaction time
function rtt_save_score() {
    if (isset($_POST['reaction_time'])) {
        $reaction_time = intval($_POST['reaction_time']);
        $user_id = get_current_user_id();
        if ($user_id) {
            update_user_meta($user_id, 'reaction_time', $reaction_time);
            wp_send_json_success('Score saved!');
        } else {
            wp_send_json_error('User not logged in.');
        }
    }
    wp_die();
}
add_action('wp_ajax_rtt_save_score', 'rtt_save_score');
add_action('wp_ajax_nopriv_rtt_save_score', 'rtt_save_score');

// Create the /reaction-time/ page on plugin activation
function rtt_create_reaction_time_page() {
    $page = array(
        'post_title'    => 'Reaction Time',
        'post_content'  => '[reaction_timer]',
        'post_status'   => 'publish',
        'post_type'     => 'page',
    );
    
    // Check if the page already exists
    $existing_page = get_page_by_title('Reaction Time');
    if (!$existing_page) {
        wp_insert_post($page);
    }
}
register_activation_hook(__FILE__, 'rtt_create_reaction_time_page');