<?php
$dns = "mysql:host=localhost;dbname=blog_db;charset=utf8";
$user = "root";
$password = "root";

$db = new PDO($dns, $user, $password);
$db->exec("set names utf8");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>