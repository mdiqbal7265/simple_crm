<?php 

require_once 'lib/classes/MysqliDb.php';

$db = new MysqliDb('localhost', 'root', '', 'crm');

// $email = "admin@gmail.com";
// $password = password_hash(12345, PASSWORD_BCRYPT);

// $data =  [
//     'name' => 'Iqbal Hossen',
//     'email' => $email,
//     'password' => $password,
//     'type' => 1
// ];
// if($db->insert('user',$data)){
//     echo 'Admin Inserted Succesfully';
// }

// $IP = $_SERVER['REMOTE_ADDR'];
// echo $IP;

// print_r($_SERVER);
$month = array();
$daily_visitors = $db->rawQuery("SELECT DATE_FORMAT(`date`,'%M') AS month, COUNT(*) as total FROM user_statics GROUP BY MONTH(date)");
foreach($daily_visitors as $v){
    $month[] = "'".$v['month']."'";
}
echo implode(", ", $month);
// print_r($daily_visitors);
