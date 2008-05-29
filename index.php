<?php
require("include/logincheck.inc.php");
logincheck();

require("include/common.inc.php");
// DB stuff
require("include/db.inc.php");
$database = new db();


$data_fields_res = $database->query("SHOW columns FROM series WHERE `Field` LIKE 'data\_%';");

while($df = mysql_fetch_assoc($data_fields_res))
{
    $data_fields[] = $df['Field'];
}


$db_result = $database->query("SELECT " . implode(", ", $data_fields) . " FROM series WHERE user=" . $_SESSION['uid'] . ";");

$output_series_list = "";
while($row = mysql_fetch_assoc($db_result))
{

    $output_series_list .= "<tr>\n";

    foreach($data_fields as $cf)
    {
        $output_series_list .= " <td>" . $row[$cf] . "</td>\n";
    }

    $output_series_list .= "</tr>\n";

}

$th_field_array = array_map(create_function('$elem','return ucfirst(preg_replace(array("/^data_/", "/_/"), array(""," "), $elem));'), $data_fields);

$table_header = "<th>" . implode("</th> <th>", $th_field_array) . "</th>";

$database->close();

?>
<html>
<head>
<title>EPisode MEMory</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>

<?php require("header.php"); ?>

<div id="div_content">
<table>
<tr>
<?= $table_header ?>
</tr>
<?php echo $output_series_list; ?>
</table>
</div>

</body>
</html>
