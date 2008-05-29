<?php
require_once("include/db.inc.php");
require_once("include/common.inc.php");

$hdb = new db();

$tmp_username = mysql_fetch_assoc($hdb->query("SELECT name FROM users WHERE id=" . $_SESSION['uid'] . ";"));

$output_username = $tmp_username['name'];

?>

<html>
<head>
<title>EPisode MEMory</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>

<div id="div_header">
 EPMEM[<?php echo $output_username; ?>] 
 <a href="<?php echo GetAppRoot(); ?>">List Content</a> | 
<!-- <a href="add.php">Add new</a> | -->
 <a href="logout.php">Logout</a>
<hr /></div>
