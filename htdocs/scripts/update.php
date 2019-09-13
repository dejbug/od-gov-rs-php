<?php
$f = fopen('update.log', 'a');
fwrite($f, date('r', $_SERVER['REQUEST_TIME'])."\r\n");
fwrite($f, $_SERVER['REMOTE_ADDR'].' ('.$_SERVER['REMOTE_HOST'].")\r\n");
fwrite($f, $_SERVER['HTTP_USER_AGENT']."\r\n");
fwrite($f, $_SERVER['HTTP_REFERER']."\r\n");
fwrite($f, "---\r\n");
fclose($f);
$result = 0;
if (!array_key_exists('YOUR_SECRET_KEY', $_POST)) echo '*';
else if ($_POST['YOUR_SECRET_KEY'] != 'YOUR_SECRET_VALUE') echo '=';
else if (FALSE === system('./update.sh', $result)) echo '!';
else echo $result;
?>