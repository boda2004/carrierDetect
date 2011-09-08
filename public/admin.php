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

require_once DROOT.'/lib/functions_admin.php';
switch ($action) {
    case 'index':
        admin_carriers($action, $data);
        break;
    case 'campaigns':
        admin_campaigns($action, $data);
        break;
    case 'carrier_campaign':
        admin_carrier_campaign($action, $data);
        break;
    case 'add_carrier_campaign':
        admin_add_carrier_campaign($action, $data);
        break;
    case 'delete_carrier':
        admin_delete_carrier($action, $data);
        break;
    case 'add_carrier':
        admin_add_carrier($action, $data);
        break;
    case 'edit_carrier':
        admin_edit_carrier($action, $data);
        break;
    case 'edit_carrier_submit':
        admin_edit_carrier_submit($action, $data);
        break;
    case 'delete_campaign':
        admin_delete_campaign($action, $data);
        break;
    case 'add_campaign':
        admin_add_campaign($action, $data);
        break;
    case 'edit_campaign':
        admin_edit_campaign($action, $data);
        break;
    case 'edit_campaign_submit':
        admin_edit_campaign_submit($action, $data);
        break;
    case 'carrier_ip':
        admin_carrier_ip($action, $data);
        break;
    case 'add_ip_range':
        admin_add_ip_range($action, $data);
        break;
    case 'delete_range':
        admin_delete_ip_range($action, $data);
        break;
    case 'delete_carrier_campaign':
        admin_delete_carrier_campaign($action, $data);
        break;
    default:
        $action = 'error';
        $data['error'] = 'Unknown action';
        break;
}
echo process_template('admin_'.$action, $data);
?>
