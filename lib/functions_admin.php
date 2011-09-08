<?php
function admin_carriers(&$action, &$data) {
    $carriers = new Carriers();
    $data['carriers'] = $carriers->getList();
}

function admin_campaigns(&$action, &$data) {
    $campaigns = new Campaigns();
    $data['campaigns'] = $campaigns->getList();
}

function admin_carrier_campaign(&$action, &$data) {
    $campaign_id = empty($_REQUEST['campaign_id'])?'':$_REQUEST['campaign_id'];
    $campaigns = new Campaigns();
    $data['campaignInfo'] = $campaigns->getCampaign($campaign_id);
    $carriers = new Carriers();
    $data['carriers'] = $carriers->getList();
    $cc = new CarrierCampaign();
    $data['carrier_campaign'] = $cc->getListForCampaign($campaign_id);
}

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

function admin_delete_carrier_campaign(&$action, &$data) {
    $carrier_id = empty($_REQUEST['carrier_id'])?'':$_REQUEST['carrier_id'];
    $campaign_id = empty($_REQUEST['campaign_id'])?'':$_REQUEST['campaign_id'];
    try {
        $cc = new CarrierCampaign();
        $cc->delete($carrier_id, $campaign_id);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?action=carrier_campaign&campaign_id='.$campaign_id);
        exit;
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

function admin_delete_campaign(&$action, &$data) {
    $id = empty($_REQUEST['id'])?'':$_REQUEST['id'];
    try {
        $campaigns = new Campaigns();
        $campaigns->delete($id);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?action=campaigns');
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

function admin_add_campaign(&$action, &$data) {
    $campaign = empty($_REQUEST['campaign'])?'':$_REQUEST['campaign'];
    $description = empty($_REQUEST['description'])?'':$_REQUEST['description'];
    try {
        $campaigns = new Campaigns();
        $campaigns->add($campaign, $description);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?action=campaigns');
        exit;
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}
function admin_add_carrier_campaign(&$action, &$data) {
    $campaign_id = empty($_REQUEST['campaign_id'])?'':$_REQUEST['campaign_id'];
    $carrier_id = empty($_REQUEST['carrier_id'])?'':$_REQUEST['carrier_id'];
    $redirectUrl = empty($_REQUEST['redirect_url'])?'':$_REQUEST['redirect_url'];
    try {
        $cc = new CarrierCampaign();
        $cc->add($carrier_id, $campaign_id, $redirectUrl);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?action=carrier_campaign&campaign_id='.$campaign_id);
        exit;
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

function admin_edit_carrier(&$action, &$data) {
    $id = empty($_REQUEST['id'])?'':$_REQUEST['id'];
    try {
        $carriers = new Carriers();
        $data['carrierInfo'] = $carriers->getCarrier($id);
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

function admin_edit_campaign(&$action, &$data) {
    $id = empty($_REQUEST['id'])?'':$_REQUEST['id'];
    try {
        $campaigns = new Campaigns();
        $data['campaignInfo'] = $campaigns->getCampaign($id);
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

function admin_edit_carrier_submit(&$action, &$data) {
    $id = empty($_REQUEST['id'])?'':$_REQUEST['id'];
    $carrier = empty($_REQUEST['carrier'])?'':$_REQUEST['carrier'];
    $description = empty($_REQUEST['description'])?'':$_REQUEST['description'];
    $redirectUrl = empty($_REQUEST['redirect_url'])?'':$_REQUEST['redirect_url'];
    try {
        $carriers = new Carriers();
        $carriers->edit($id, $carrier, $description, $redirectUrl);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
        exit;
    } catch (Exception $e) {
        $action = 'error';
        $data['error'] = $e->getMessage();
    }
}

function admin_edit_campaign_submit(&$action, &$data) {
    $id = empty($_REQUEST['id'])?'':$_REQUEST['id'];
    $campaign = empty($_REQUEST['campaign'])?'':$_REQUEST['campaign'];
    $description = empty($_REQUEST['description'])?'':$_REQUEST['description'];
    try {
        $campaigns = new Campaigns();
        $campaigns->edit($id, $campaign, $description);
        header('Location: http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?action=campaigns');
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
        $data['backUrl'] = 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?action=carrier_ip&amp;carrier='.$carrier;
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
        $data['backUrl'] = 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?action=carrier_ip&amp;carrier='.$carrier;
    }
}

?>
