<?php
// GitHub Webhook Secret.
// Keep it the same with the 'Secret' field on your Webhooks / Manage webhook page of your respostory.
$secret = "doris-ucat";
// Path to your respostory on your server.
// e.g. "/var/www/respostory"
$path = "/home/dnmp/www/doris-ucat";
// Headers deliveried from GitHub
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
$data[ 'signature']=$signature;
if ($signature) {
    $hash = "sha1=" . hash_hmac('sha1', $HTTP_RAW_POST_DATA, $secret);
    $data[ 'hash'] = $hash;
    if (strcmp($signature, $hash) == 0) {
        print_r($data);
        echo shell_exec("cd {$path}  && git pull origin master 2>&1");
        exit();
    }
}
$data['succ']='error';
print_r($data);
http_response_code(404);