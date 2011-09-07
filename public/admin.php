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
    case 'delete_carrier':
        $id = empty($_REQUEST['id'])?'':$_REQUEST['id'];
        try {
            $carriers = new Carriers();
            if ($carriers->delete($id)) {
                header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
                exit;
            }
        } catch (Exception $e) {
            $action = 'error';
            $data['error'] = $e->getMessage();
        }
        break;
    case 'add_carrier':
        $carrier = empty($_REQUEST['carrier'])?'':$_REQUEST['carrier'];
        $description = empty($_REQUEST['description'])?'':$_REQUEST['description'];
        $redirectUrl = empty($_REQUEST['redirect_url'])?'':$_REQUEST['redirect_url'];
        try {
            $carriers = new Carriers();
            if ($carriers->add($carrier, $description, $redirectUrl)) {
                header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
                exit;
            } else {
                $action = 'error';
                $data['error'] = 'Could not add carrier';
            }
        } catch (Exception $e) {
            $action = 'error';
            $data['error'] = $e->getMessage();
        }
        break;
    default:
        $action = 'error';
        $data['error'] = 'Unknown action';
        break;
}
echo process_template('admin_'.$action, $data);
?>
