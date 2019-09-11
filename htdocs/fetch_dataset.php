<?php
function fetch_dataset($page_size=20, $outpath=NULL) {
	$page_size = is_int($page_size) ? $page_size : 20;

	$ch = curl_init("https://data.gov.rs/api/1/datasets/?page_size=".$page_size);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 3);

	$fp = NULL;

	if (is_string($outpath)) {
		// If outpath is relative to the "cache" folder, then
		// just overwrite if path exists; else fail if file
		// exists. Note that only forward slashes are checked.
		if (strncmp($outpath, "cache/", 6) && is_file($outpath))
		{
			curl_close($ch);
			return FALSE;
		}
		$fp = fopen($outpath, "w");
		curl_setopt($ch, CURLOPT_FILE, $fp);
	}
	else if (is_resource($outpath)) {
		curl_setopt($ch, CURLOPT_FILE, $outpath);
	}
	else {
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$text = curl_exec($ch);
		curl_close($ch);
		return FALSE !== $text ? $text : NULL;
	}

	$ok = curl_exec($ch);

	curl_close($ch);
	if ($fp) fclose($fp);
	return $ok;
}
?>