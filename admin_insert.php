<?php 

require_once 'lib/classes/MysqliDb.php';

$db = new MysqliDb('localhost', 'root', '', 'crm');

$email = "admin@gmail.com";
$password = password_hash(12345, PASSWORD_BCRYPT);

$data =  [
    'name' => 'Iqbal Hossen',
    'email' => $email,
    'password' => $password,
    'type' => 1
];
if($db->insert('user',$data)){
    echo 'Admin Inserted Succesfully';
}
