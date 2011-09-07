<?php
class Carriers {
    const SQL_CARRIERS_ROW = 'SELECT * FROM carriers LIMIT :start, :limit';

    /**
     * @var PDO
     */
    protected $sql;
    public function __construct($database = null) {
        if (is_null($database)) {
            $database = $GLOBALS['CONFIG']['SQL'];
        }
        $this->sql = new PDO($database['dsn'], $database['user'], $database['password'], $database['options']);
    }
    public function getList($start = 0, $limit = 100) {
        $sth = $this->sql->prepare(self::SQL_CARRIERS_ROW, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':start', $start, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
