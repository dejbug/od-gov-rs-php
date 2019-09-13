<?php
$f = fopen('update.log', 'a');
fwrite($f, date('r', $_SERVER['REQUEST_TIME'])."\r\n");
fwrite($f, $_SERVER['REMOTE_ADDR'].' ('.$_SERVER['REMOTE_HOST'].")\r\n");
fwrite($f, $_SERVER['HTTP_USER_AGENT']."\r\n");
fwrite($f, $_SERVER['HTTP_REFERER']."\r\n");
fwrite($f, "---\r\n");
fclose($f);

if (!array_key_exists('SECRET', $_POST)) die ('*');

$secret = file_get_contents('update.secret');
if (FALSE === $secret) die ('>');
if (strlen($secret) < 16) die ('#');
if ($_POST['SECRET'] != $secret) die ('=');

$result = 0;
if (FALSE === system('./update.sh', $result)) die ('!');
echo $result;
?>