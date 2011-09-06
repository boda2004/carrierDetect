<?php
error_reporting(E_ALL|E_STRICT);
define('DROOT', realpath(dirname(__FILE__)));

define('SEVERITY_DEBUG', 0);
define('SEVERITY_WARN', 1);
define('SEVERITY_CRIT', 2);

$CONFIG = array();
$CONFIG['SQL'] = array(
    'dsn' => 'mysql:host=localhost;dbname=carrier_detect',
    'user' => 'root',
    'password' => '',
    'options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);
$CONFIG['LOG'] = array('enabled' => true, 'path' => DROOT.'/logs', 'severity' => SEVERITY_WARN);
$CONFIG['AUTH'] = array('realm' => 'My Realm', 'text' => 'You must be logged in to access this page!', 'users' => array('admin' => 'adminpw'));

$host = empty($_SERVER['HTTP_HOST'])?'':$_SERVER['HTTP_HOST'];
if (strrpos($host, ':80') === strlen($host)-3) {
    $host = substr($host, 0, -3);
}
if (is_readable(DROOT.'/config/'.$host.'.php')) {
    require_once DROOT.'/config/'.$host.'.php';
}


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
spl_autoload_register('__class_loader');

?>
