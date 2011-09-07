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
?>
