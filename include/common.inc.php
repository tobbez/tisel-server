<?php
function check_input()
{
    if(!isset($_GET['user']))
    {
	print "NOT_OK:user not set";
	exit();
    }

    if(!isset($_POST['password']))
    {
	print "NOT_OK:password not set";
    	exit();
    }

    if(strlen($_POST['password']) == 0)
    {
	print "NOT_OK:zero length password not permitted";
    	exit();
    }

    if(strlen($_GET['user']) == 0)
    {
	print "NOT_OK:zero length username not permitted";
    	exit();
    }
}

function GetAppRoot()
{
    $tmp_script = $_SERVER["SCRIPT_NAME"];
    $tmp_last_slash = strrpos($_SERVER["SCRIPT_NAME"], "/");
    $return_val = substr($tmp_script, 0, 1 + $tmp_last_slash);
    return $return_val;
}


?>
