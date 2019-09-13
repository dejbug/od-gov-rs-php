<?php
/// Write some logs.
$f = fopen('update.log', 'a');
fwrite($f, date('r', $_SERVER['REQUEST_TIME'])."\r\n");
fwrite($f, $_SERVER['REMOTE_ADDR']."\r\n");
fwrite($f, $_SERVER['HTTP_USER_AGENT']."\r\n");
fwrite($f, "---\r\n");
fclose($f);
// die (var_export($_SERVER, TRUE));

// if (!array_key_exists('X-GitHub-Event', $_SERVER)) die ('e');

/// We want to make sure that requester sent our secret, so first
/// we need to unpack the secret from GH's HMAC signature. E.g.:
/// X-Hub-Signature: sha1=7d38cdd689735b008b3c702edd92eea23791c5f6
if (!array_key_exists('HTTP_X_HUB_SIGNATURE', $_SERVER)) die ('*');
$sig = $_SERVER['HTTP_X_HUB_SIGNATURE'];
$sig_pair = explode('=', $sig, 2);
if (count($sig_pair) != 2) die ('"');
$sig_algo = strtolower($sig_pair[0]);
$sig_hmac = strtoupper($sig_pair[1]);

/// Does our PHP distro support the HMAC's algorithm?
// if (FALSE === array_search($sig_algo, hash_algos(), TRUE)) die ('?');
if (FALSE === array_search($sig_algo, hash_hmac_algos(), TRUE)) die ('?');

/// Read the payload.
$in = fopen('php://input', 'rb');
$payload = stream_get_contents($in);
fclose($in);
// die ($payload);

/// Read our secret against which to authenticate the HMAC.
$secret = trim(file_get_contents('update.secret'));
if (FALSE === $secret) die ('>');
if (strlen($secret) < 16) die ('#');

/// Verify that request came from someone who shares our secret.
$hmac = strtoupper(hash_hmac($sig_algo, $payload, $secret));
if ($sig_hmac !== $hmac) die ('=');

/// Execute our update script.
$result = 0;
if (FALSE === system('./update.sh', $result)) die ('!');
echo $result;
?>