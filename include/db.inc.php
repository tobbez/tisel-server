<?php

include("config.inc.php");

class db
{
	var $db_server_link;

	// Constructor; creates a database connection
	function db()
	{
		global $dbhost, $dbuser, $dbpass, $dbname;
		$this->db_server_link = @mysql_connect($dbhost, $dbuser, $dbpass);
		mysql_select_db($dbname, $this->db_server_link) ;
	}

	// Closes the database connection
	function close()
	{
		mysql_close($this->db_server_link);
	}

	// Handles a query to the database
	function query($thisQuery)
	{
		//$esc_query = mysql_real_escape_string($thisQuery, $this->db_server_link);
		$result = mysql_query($thisQuery, $this->db_server_link) or die(mysql_error());
		return $result;
	}

	function escape($text)
	{
		$new_text = mysql_real_escape_string($text, $this->db_server_link);
		return $new_text;
	}
}

?>
