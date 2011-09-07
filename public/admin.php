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
$action = empty($_REQUEST['action'])? 'index': $_REQUEST['action'];
$data = array(
    'user' => $user
);
switch ($action) {
    case 'index':
        break;
    default:
        $action = 'error';
        $data['error'] = 'Unknown action';
}
echo process_template('admin_'.$action, $data);
?>
