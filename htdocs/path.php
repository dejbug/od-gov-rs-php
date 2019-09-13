<?php
function path_normalize($path) {
	$path = trim($path);
	$path = str_replace('\\', '/', $path);
	$path = rtrim($path, '/');
	return $path;
}

function path_pop_right($path) {
	// $cut = strrpos($path, '/');
	// $root = substr($path, 0, $cut);
	$res = preg_match('#(.*)(?:/|\\\\)[^/]+#', $path, $matches);
	if (FALSE === $res) return NULL;
	if (0 === $res) return "";
	return $matches[1];
}
?>