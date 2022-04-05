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

$IP = $_SERVER['REMOTE_ADDR'];
$MAC = exec('getmac');
$MAC = strtok($MAC, ' ');
$date = date('Y/m/d');
$data = [
    'date' => $date,
    'ip' => $IP,
    'mac' => $MAC,
];
$db->insert('user_statics', $data);

$email = $_SESSION['email'];
$db->where('email', $email);
$user = $db->getOne('user');

$service = $db->get('service');

$total_user = $db->getValue("user", "count(*)");
$total_ticket = $db->getValue("ticket", "count(*)");
$total_quotes = $db->getValue("prequest", "count(*)");
$db->where('status', 1);
$total_remarked_quotes = $db->getValue("prequest", "count(*)");

$month = array();
$total = array();
$daily_visitors = $db->rawQuery("SELECT DATE_FORMAT(`date`,'%M') AS month, COUNT(*) as total FROM user_statics GROUP BY MONTH(date)");
foreach($daily_visitors as $v){
    $month[] = "'".$v['month']."'";
    $total[] = $v['total'];
}
$month_label = implode(", ", $month);
$total_label = implode(", ", $total);
