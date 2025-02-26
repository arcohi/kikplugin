<?php 


add_shortcode('kik_register_form', 'kik_register_form');

// Handle Shortcode for Registration Form
function kik_register_form() {
    if (is_user_logged_in()) {
        return '<p>You are already registered and logged in.</p>';
    }

    ob_start(); ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="kik_register" value="Register">
    </form>
    <?php
    if (isset($_POST['kik_register'])) {
        kik_handle_registration();
    }
    return ob_get_clean();
}

// Handle User Registration
function kik_handle_registration() {
    $username = sanitize_user($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    if (username_exists($username) || email_exists($email)) {
        echo '<p style="color:red;">Username or Email already exists.</p>';
        return;
    }

    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) {
        echo '<p style="color:red;">Registration failed.</p>';
        return;
    }

    echo '<p style="color:green;">Registration successful! You can now login.</p>';
}