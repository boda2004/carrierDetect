<?php
class Carriers {
    const SQL_CARRIERS_ROW = 'SELECT * FROM carriers LIMIT :start, :limit';
    const SQL_CARRIER_ADD = 'INSERT INTO carriers (carrier, description, redirect_url) VALUES(:carrier, :description, :redirect_url)';
    const SQL_CARRIER_DELETE = 'DELETE FROM carriers WHERE id=:id';

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

    public function add($carrier, $description, $redirect_url) {
        $sth = $this->sql->prepare(self::SQL_CARRIER_ADD);
        $sth->bindParam(':carrier', $carrier);
        $sth->bindParam(':description', $description);
        $sth->bindParam(':redirect_url', $redirect_url);
        return $sth->execute();
    }

    public function delete($id) {
        $sth = $this->sql->prepare(self::SQL_CARRIER_DELETE);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->rowCount() > 0;
    }
}
?>
