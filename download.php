<?php
/*
 * download.php - download stored info
 * input:
 *  - $_GET['user']
 *     name of user
 *  - $_POST['password']
 *     password for user
 *
 * output:
 *  - NOT_OK:message
 *     user could not be created
 *  - xml data
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

    $shows = $db->query("SELECT * FROM series WHERE user='" . $user_id . "';");

    // Get the fields that are to be exported
    $data_fields_res = $db->query("SHOW columns FROM series WHERE `Field` LIKE 'data\_%';");

    while($df = mysql_fetch_assoc($data_fields_res))
    {
		$data_fields[] = $df['Field'];
    }

    $xml = new SimpleXMLElement("<showlist />");

    while($show = mysql_fetch_assoc($shows))
    {
	$show_xml = $xml->addChild("show");
	foreach($data_fields as $df)
	{
	    $show_xml->addAttribute(preg_replace('/^data_/', '', $df), $show[$df]);
	}

    }
    print $xml->asXML();
}

$db->close();

?>
