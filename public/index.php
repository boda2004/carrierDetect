<?php
require_once '../config.php';
$resolver = new Resolver();
$carrierRow = $resolver->carrierRowByIp();
$campaign = empty($_REQUEST['campaign'])?'default':$_REQUEST['campaign'];
$campaignName = 'undetected';
$carrierName = $carrierRow['carrier'];
try {
    $campaigns = new Campaigns();
    $campaignRow = $campaigns->getByName($campaign);
    $campaignName = $campaignRow['campaign'];
    $cc = new CarrierCampaign();
    $ccRow = $cc->getCC($carrierRow['id'], $campaignRow['id']);
    $url = $ccRow['redirect_url'];
} catch (Exception $e) {
    $url = $carrierRow['redirect_url'];
}
add_to_log('[remote_addr='.$_SERVER['REMOTE_ADDR'].'][carrier='.$carrierName.'][campaign='.$campaignName.'][redirect_url='.$url.'][request_url=http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].']', SEVERITY_DEBUG);
header('Location: '.$url);
?>
