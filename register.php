<?php
/*
 * register.php - register a new account
 * input:
 *  - $_GET['user']
 *     name of new user
 *  - $_POST['password']
 *     password for new user
 *
 * output:
 *  - NOT_OK:message
 *     user could not be created
 *  - OK:message
 *     user created successfully
 *  message is a textual description of the result
 */
require("include/db.inc.php");
require("include/common.inc.php");

check_input();

$db = new DB();

// Check if requested username is taken
$username = $db->escape($_GET['user']);
$result = $db->query("SELECT * FROM users WHERE name='" . $username . "';");
if (mysql_num_rows($result) != 0)
{
    print "NOT_OK:user already exists";
}
else
{
    // Add new user
    $db->query("INSERT INTO users (name, password) VALUES ('" . $username . "', '" . md5($_POST['password']) . "');");
    print "OK:user successfully created";
}

$db->close();

?>
