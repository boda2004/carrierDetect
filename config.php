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

require_once DROOT.'/lib/functions.php';
spl_autoload_register('__class_loader');
?>
