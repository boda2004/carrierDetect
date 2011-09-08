<?php
class Carriers {
    const SQL_CARRIER_ROW = 'SELECT * FROM carriers WHERE id=:id';
    const SQL_CARRIERS_ROWS = 'SELECT id, carrier, description, redirect_url FROM carriers LIMIT :start, :limit';
    const SQL_CARRIER_ADD = 'INSERT INTO carriers (carrier, description, redirect_url) VALUES(:carrier, :description, :redirect_url)';
    const SQL_CARRIER_EDIT = 'UPDATE carriers SET carrier=:carrier, description=:description, redirect_url=:redirect_url WHERE id=:id';
    const SQL_CARRIER_DELETE = 'DELETE FROM carriers WHERE id=:id';
    const SQL_CARRIER_RANGES_ROWS = 'SELECT id, INET_NTOA(min_ip) AS min_ip, INET_NTOA(max_ip) AS max_ip, carrier_id, priority FROM ip_ranges WHERE carrier_id=:carrier LIMIT :start, :limit';
    const SQL_CARRIER_ADD_IP_RANGE = 'INSERT INTO ip_ranges (min_ip, max_ip, carrier_id, priority) VALUES(INET_ATON(:min_ip), INET_ATON(:max_ip), :carrier_id, :priority)';
    const SQL_CARRIER_DELETE_IP_RANGE = 'DELETE FROM ip_ranges WHERE id=:id';

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
    public function getCarrier($id) {
        $sth = $this->sql->prepare(self::SQL_CARRIER_ROW, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            throw new Exception('Could not find carrier');
        }
        return $row;
    }
    public function getIpRanges($carrier, $start = 0, $limit = 100) {
        $sth = $this->sql->prepare(self::SQL_CARRIER_RANGES_ROWS, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':carrier', $carrier, PDO::PARAM_INT);
        $sth->bindParam(':start', $start, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getList($start = 0, $limit = 100) {
        $sth = $this->sql->prepare(self::SQL_CARRIERS_ROWS, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
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
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not add carrier':$ei[2]);
        }
    }

    public function edit($id, $carrier, $description, $redirect_url) {
        $sth = $this->sql->prepare(self::SQL_CARRIER_EDIT);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->bindParam(':carrier', $carrier);
        $sth->bindParam(':description', $description);
        $sth->bindParam(':redirect_url', $redirect_url);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not edit carrier':$ei[2]);
        }
    }

    public function delete($id) {
        $sth = $this->sql->prepare(self::SQL_CARRIER_DELETE);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not delete carrier':$ei[2]);
        }
    }

    public function deleteIpRange($id) {
        $sth = $this->sql->prepare(self::SQL_CARRIER_DELETE_IP_RANGE);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not delete IP range':$ei[2]);
        }
    }

    public function addIpRange($carrier, $min_ip, $max_ip, $priority) {
        $sth = $this->sql->prepare(self::SQL_CARRIER_ADD_IP_RANGE);
        $sth->bindParam(':carrier_id', $carrier, PDO::PARAM_INT);
        $sth->bindParam(':min_ip', $min_ip);
        $sth->bindParam(':max_ip', $max_ip);
        $sth->bindParam(':priority', $priority, PDO::PARAM_INT);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not add IP range':$ei[2]);
        }
    }
}
?>
