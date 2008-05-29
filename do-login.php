<?php
require("include/db.inc.php");
require("include/common.inc.php");
session_start();

$db = new DB();
$login = $db->escape($_POST['login']);
$result = $db->query("SELECT * FROM users WHERE name='" . $login . "' AND password='" . md5($_POST['password']) . "';");

if (mysql_num_rows($result) != 1) die ("Wrong login or password!");

$info = mysql_fetch_assoc($result);
$db->close();
$_SESSION['uid'] = $info['id'];
header("Location: " . GetAppRoot());

?>
