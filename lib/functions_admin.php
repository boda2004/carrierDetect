<?php
function admin_delete_carrier(&$action, &$data) {
    $id = empty($_REQUEST['id'])?'':$_REQUEST['id'];
    try {
        $carriers = new Carriers();
        $carriers->delete($id);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
        exit;
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

function admin_add_carrier(&$action, &$data) {
    $carrier = empty($_REQUEST['carrier'])?'':$_REQUEST['carrier'];
    $description = empty($_REQUEST['description'])?'':$_REQUEST['description'];
    $redirectUrl = empty($_REQUEST['redirect_url'])?'':$_REQUEST['redirect_url'];
    try {
        $carriers = new Carriers();
        $carriers->add($carrier, $description, $redirectUrl);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
        exit;
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

function admin_carrier_ip(&$action, &$data) {
    $carrier = empty($_REQUEST['carrier'])? '': $_REQUEST['carrier'];
    try {
        $carriers = new Carriers();
        $data['carrierInfo'] = $carriers->getCarrier($carrier);
        $data['IpRanges'] = $carriers->getIpRanges($data['carrierInfo']['id']);
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

function admin_delete_ip_range(&$action, &$data) {
    $id = empty($_REQUEST['id'])?'':$_REQUEST['id'];
    $carrier = empty($_REQUEST['carrier'])?'':$_REQUEST['carrier'];
    try {
        $carriers = new Carriers();
        $carriers->deleteIpRange($id);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?action=carrier_ip&carrier='.$carrier);
        exit;
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

function admin_add_ip_range(&$action, &$data) {
    $carrier = empty($_REQUEST['carrier'])?'':$_REQUEST['carrier'];
    $min_ip = empty($_REQUEST['min_ip'])?'':$_REQUEST['min_ip'];
    $max_ip = empty($_REQUEST['max_ip'])?'':$_REQUEST['max_ip'];
    $priority = empty($_REQUEST['priority'])?'':$_REQUEST['priority'];
    try {
        $carriers = new Carriers();
        $carriers->addIpRange($carrier, $min_ip, $max_ip, $priority);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?action=carrier_ip&carrier='.$carrier);
        exit;
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

?>