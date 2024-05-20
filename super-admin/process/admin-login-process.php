<?php

include('../config/connect.php');

// Check if the database connection is successful
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Select the database
$db_selected = mysqli_select_db($con, 'ep');

// Check if the database selection succeeded
if (!$db_selected) {
    die("Database selection failed: " . mysqli_error($con));
}

if(isset($_POST['super_admin_username'], $_POST['super_admin_password'])) {
    $super_admin_username = mysqli_real_escape_string($con, $_POST['super_admin_username']);
    $super_admin_password = mysqli_real_escape_string($con, $_POST['super_admin_password']);

    // Hash the password for basic security
    $hashed_password = md5($super_admin_password);

    // Default username and password
    $default_username = 'admin';
    $default_password = md5('admin');

    if($super_admin_username === $default_username && $hashed_password === $default_password) {
        // Start session only if login is successful
        session_start();
        $_SESSION['super_admin_username'] = $super_admin_username;
        
        // Redirect to admin-meal-report.php
        header("Location: ../admin-meal-report.php");
        exit();
    } else {
        // Display error message if login fails
        echo "<script>alert('Incorrect information, try again !!')</script>";
        echo "<script>window.open('../index.php','_self')</script>";
        exit();
    }
} else {
    // Handle case when username or password is not set
    echo "<script>alert('Please provide both username and password')</script>";
    echo "<script>window.open('../index.php','_self')</script>";
    exit();
}
?>
