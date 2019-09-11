<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta http-equiv="encoding" content="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="default.css" media="all">
<title>app/eu/sr</title>
</head>
<body>
<div>
<?php
require_once("file.php");
require_once("fetch_dataset.php");

$cache_max_age = 3600;
$cache_path = "cache/dataset1_30.json";
$cache_age = file_age($cache_path);
if ($cache_age > $cache_max_age)
{
	if (!fetch_dataset(30, "cache/dataset1_30.json"))
		die("Error fetching list of datasets.");
	$cache_age = 1;
}
echo "<p class=\"cache-status\">last update was $cache_age seconds ago (next update in ".($cache_max_age-$cache_age)." seconds)</p>\n";

$text = file_get_contents("cache/dataset1_30.json");
$json = json_decode($text, true);
if (NULL == $json) die("Error parsing list of datasets.");

require_once("cyr_to_lat.php");

$i = 1;
foreach ($json["data"] as $x) {
	$text = cyr_to_lat($x["description"]);
	$text = str_replace(array("\r\n", "\n", "\r"), " / ", trim($text));
	echo '<p class="clickable" onclick="cb_toggle_expand(this)"><span class="row long">';
	echo sprintf("%02d: %s</span></p>\n", $i, $text);
	$i = $i + 1;
}
?>
<p><small>(... and there's more where this came from.)</small></p>
</div>
<script src="index.js"></script>
</body>
</html>