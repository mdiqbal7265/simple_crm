<?php

session_start();

require_once 'classes/Validation.php';
require_once 'classes/MysqliDb.php';
require_once 'classes/Helper.php';

$db = new MysqliDb('localhost', 'root', '', 'cms_db');
$validation = new Validation();
$helper = new Helper();

// Handle User Login
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = $validation->sanitize_data($_POST['email']);
    $password = $validation->sanitize_data($_POST['password']);

    $validation->name('email')->value($email)->pattern('email')->required();
    $validation->name('password')->value($password)->required();

    if ($validation->isSuccess()) {
        $db->where('email', $email);
        $loggedIn = $db->getOne('users');
        if ($loggedIn != null) {
            if (password_verify($password, $loggedIn['password'])) {
                if (!empty($_POST['rem'])) {
                    setcookie("email", $email, time() + (30 * 24 * 60 * 60), '/');
                    setcookie("password", $password, time() + (30 * 24 * 60 * 60), '/');
                } else {
                    setcookie("email", "", 1, '/');
                    setcookie("password", "", 1, '/');
                }
                echo 'login';
                $_SESSION['email'] = $email;
            } else {
                echo 'password_not_matched';
            }
        } else {
            echo 'data_not_found';
        }
    } else {
        echo "Validation Error!";
        echo $validation->displayErrors();
    }
}


// Handle User Logout
if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    unset($_SESSION['email']);
    echo 'logout';
}


