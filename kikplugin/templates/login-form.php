<?php 

add_shortcode('kik_login_form', 'kik_login_form');

// Handle Shortcode for Login Form
function kik_login_form() {
    if (is_user_logged_in()) {
        return '<p>You are already logged in.</p>';
    }

    ob_start(); 
    session_start(); // Start session to track failed attempts

    // Check if a login attempt was made
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $username = sanitize_text_field($_POST['username']);
        $password = $_POST['password'];
        
        // Authenticate user
        $user = wp_authenticate($username, $password);
        
        if (is_wp_error($user)) {
            // Increase failed attempts count
            $_SESSION['failed_attempts'] = ($_SESSION['failed_attempts'] ?? 0) + 1;
        } else {
            // Reset failed attempts on success
            $_SESSION['failed_attempts'] = 0;
            wp_set_auth_cookie($user->ID);
            wp_redirect(home_url()); // Redirect after login
            exit;
        }
    }


 
    ?>



<form method="post">
    <input type="text" name="log" placeholder="Username" required>
    <input type="password" name="pwd" placeholder="Password" required>
    <input type="submit" name="kik_login" value="Login">
</form>
<?php
    if (isset($_POST['kik_login'])) {
        kik_handle_login();
    }
    // Show the forgot password link only after 3 failed attempts
    if (!empty($_SESSION['failed_attempts']) && $_SESSION['failed_attempts'] >= 3): 
    ?>
<p><a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a></p>
<?php endif; 

 
    return ob_get_clean();
}

// Handle User Login
function kik_handle_login() {
    $credentials = array(
        'user_login'    => $_POST['log'],
        'user_password' => $_POST['pwd'],
        'remember'      => true,
    );

    $user = wp_signon($credentials, false);

    if (is_wp_error($user)) {
        echo '<p style="color:red;">Invalid login credentials.</p>';
        return;
    }

    echo '<p style="color:green;">Login successful! Redirecting...</p>';
    wp_redirect(site_url('/profile/'));
    exit;
}