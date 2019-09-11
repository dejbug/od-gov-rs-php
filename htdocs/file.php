<?php
function file_age($path) {
	return is_file($path) ? time() - filectime($path) : NULL;
}

function file_expired($path, $maxage=3600) {
	$age = file_age($path);
	return NULL == $age || $age > $maxage;
}
?>