<?php

session_start();

require_once 'classes/MysqliDb.php';
require_once 'classes/Helper.php';

$db = new MysqliDb('localhost', 'root', '', 'cms_db');
$helper = new Helper();

if(!isset($_SESSION['email'])){
    header('location: index.php');
    die();
}


