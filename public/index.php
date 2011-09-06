<?php
require_once '../config.php';
$resolver = new Resolver();
$carrierRow = $resolver->carrierRowByIp();
add_to_log($carrierRow, SEVERITY_DEBUG);
$url = $carrierRow['redirect_url'];
header('Location: '.$url);
?>
