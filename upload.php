<?php
/*
 * upload.php - upload info to service
 * input:
 *  - $_GET['user']
 *     name of user
 *  - $_POST['password']
 *     password for user
 *  - $_POST['data']
 *     data to be stored
 *
 * output:
 *  - NOT_OK:message
 *     user could not be created
 *  - OK:message
 *     the requested xml data
 *  message is a textual description of the result
 */
require("include/db.inc.php");
require("include/common.inc.php");

check_input();

$db = new DB();
$user = $db->escape($_GET['user']);
$result = $db->query("SELECT id FROM users WHERE name='" . $user . "' AND password='" . md5($_POST['password']) . "';");

if(mysql_num_rows($result) != 1)
{
    print "NOT_OK:invalid username or password";
}
else
{
    $user_assoc = mysql_fetch_assoc($result);
    $user_id = $user_assoc['id'];

    // remove old data
    $db->query("DELETE FROM series WHERE user='" . $user_id . "';");

    $xml = simplexml_load_string(stripslashes(urldecode($_POST['data'])));

    $shows = $xml->xpath("/showlist/show");

    if($shows)
	foreach($shows as $show)
	{
	    $show_fields = "";
	    $show_values = "";
	    foreach($show->attributes() as $field => $fval)
            {
		$show_fields .= "`data_" . $field . "`, ";
		$show_values .= "'" . $db->escape($fval)  . "', ";
            }
	    
	    $full_query = "INSERT INTO series (" . $show_fields . "`user`)
	                   VALUES (" . $show_values . "'" . $user_id .  "');";

	    $db->query($full_query);

	}
    print "OK:successfully stored " . count($shows) . " series";
}

$db->close();

?>
