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

$email = $_SESSION['email'];
$db->where('email', $email);
$user = $db->getOne('users');

$branch = $db->get('branches');

$total_branch = $db->getValue('branches','count(*)');
$total_parcel = $db->getValue('parcels', 'count(*)');
$db->where('type', 2);
$total_staff = $db->getValue('users', 'count(*)');

$db->where('status',0);
$item_accepted_by_courier = $db->getValue('parcels','count(*)');
$db->where('status',1);
$collected = $db->getValue('parcels','count(*)');
$db->where('status',2);
$shipped = $db->getValue('parcels','count(*)');
$db->where('status',7);
$delivery = $db->getValue('parcels','count(*)');
$db->where('status',8);
$pickup = $db->getValue('parcels','count(*)');

$setting = $db->getOne('system_settings');
