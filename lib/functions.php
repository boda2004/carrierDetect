<?php
function severity2string($severity) {
    switch($severity) {
        case SEVERITY_CRIT:
            return 'crit';
        case SEVERITY_WARN:
            return 'warn';
        case SEVERITY_DEBUG:
            return 'debug';
        default:
            return 'unknown';
    }
}

function add_to_log($string, $severity = SEVERITY_DEBUG) {
    $log = $GLOBALS['CONFIG']['LOG'];
    if ($severity < $log['severity']) {
        return;
    }
    if (is_array($string)) {
        $string = print_r($string, true);
    }
    $string = trim(strtr($string, "\n", " "));
    $f = fopen($log['path'].'/'.date('Ymd').'.log', 'a');
    fwrite($f, '['.date("r").'] ['.severity2string($severity).'] '.$string."\n");
    fclose($f);
}

function __class_loader($class) {
    if (is_readable(DROOT.'/lib/'.$class.'.php')) {
        require_once DROOT.'/lib/'.$class.'.php';
    }
}
?>
