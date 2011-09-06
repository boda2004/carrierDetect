<?php
class Resolver {
    const SQL_CARRIER_NAME_BY_IP = 'SELECT `carrier` FROM carriers INNER JOIN ip_ranges ON carriers.id=ip_ranges.carrier_id WHERE INET_ATON(:ip) BETWEEN min_ip and max_ip ORDER BY priority DESC LIMIT 1';
    const SQL_CARRIER_ROW_BY_IP = 'SELECT `carriers`.* FROM carriers INNER JOIN ip_ranges ON carriers.id=ip_ranges.carrier_id WHERE INET_ATON(:ip) BETWEEN min_ip and max_ip ORDER BY priority DESC LIMIT 1';
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

    public function carrierNameByIp($ip = null) {
        if (is_null($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $sth = $this->sql->prepare(self::SQL_CARRIER_NAME_BY_IP, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':ip' => $ip));
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        return $row['carrier'];
    }

    public function carrierRowByIp($ip = null) {
        if (is_null($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $sth = $this->sql->prepare(self::SQL_CARRIER_ROW_BY_IP, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array(':ip' => $ip));
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}
?>
