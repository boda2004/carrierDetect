<?php
function tpl_get_carriers() {
    $carriers = new Carriers();
    return $carriers->getList();
}
?>
