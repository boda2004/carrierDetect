<?php
class BaseClass {
    /**
     * @var PDO
     */
    protected $sql;
    public function __construct(&$database = null) {
        if (is_null($database)) {
            $database = &$GLOBALS['CONFIG']['SQL'];
        }
        if (empty($database['connection'])) {
            $database['connection'] = new PDO($database['dsn'], $database['user'], $database['password'], $database['options']);
        }
        $this->sql = $database['connection'];
    }
}
?>
