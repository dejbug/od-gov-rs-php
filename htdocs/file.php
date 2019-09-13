<?php
function file_expired($path, $maxage=3600) {
	return file_age_expired(file_age($path), $maxage);
}

function file_age($path) {
	if (!is_file($path)) return NULL;
	if (!filesize($path)) return NULL;
	return time() - filectime($path);
}

function file_age_expired($age, $maxage=3600) {
	return NULL == $age || $age > $maxage;
}
?>