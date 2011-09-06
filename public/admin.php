<?php
require_once '../config.php';
$user = empty($_SERVER['PHP_AUTH_USER'])?'anonymous':$_SERVER['PHP_AUTH_USER'];
$password = empty($_SERVER['PHP_AUTH_PW'])?'':$_SERVER['PHP_AUTH_PW'];
if (empty($CONFIG['AUTH']['users'][$user]) || $CONFIG['AUTH']['users'][$user] != $password) {
    header('WWW-Authenticate: Basic realm="'.$CONFIG['AUTH']['realm'].'"');
    header('HTTP/1.0 401 Unauthorized');
    echo $CONFIG['AUTH']['text'];
    exit;
}
echo 'Hello, '.$user.'!';
?>
