<?php

session_start();

require_once 'classes/MysqliDb.php';
require_once 'classes/Helper.php';

$db = new MysqliDb('localhost', 'root', '', 'crm');
$helper = new Helper();

if (!isset($_SESSION['email'])) {
    header('location: index.php');
    die();
}

$email = $_SESSION['email'];
$db->where('email', $email);
$user = $db->getOne('user');
