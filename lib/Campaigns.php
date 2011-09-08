<?php
class Campaigns extends BaseClass {
    const SQL_CAMPAIGN_ROW = 'SELECT * FROM campaigns WHERE id=:id';
    const SQL_CAMPAIGN_BY_NAME_ROW = 'SELECT * FROM campaigns WHERE campaign=:campaign';
    const SQL_CAMPAIGNS_ROWS = 'SELECT id, campaign, description FROM campaigns LIMIT :start, :limit';
    const SQL_CAMPAIGN_ADD = 'INSERT INTO campaigns (campaign, description) VALUES(:campaign, :description)';
    const SQL_CAMPAIGN_EDIT = 'UPDATE campaigns SET campaign=:campaign, description=:description WHERE id=:id';
    const SQL_CAMPAIGN_DELETE = 'DELETE FROM campaigns WHERE id=:id';

    public function getCampaign($id) {
        $sth = $this->sql->prepare(self::SQL_CAMPAIGN_ROW, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            throw new Exception('Could not find campaign');
        }
        return $row;
    }
    public function getByName($campaign) {
        $sth = $this->sql->prepare(self::SQL_CAMPAIGN_BY_NAME_ROW, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':campaign', $campaign, PDO::PARAM_INT);
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            throw new Exception('Could not find campaign');
        }
        return $row;
    }
    public function getList($start = 0, $limit = 100) {
        $sth = $this->sql->prepare(self::SQL_CAMPAIGNS_ROWS, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':start', $start, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function add($campaign, $description) {
        $sth = $this->sql->prepare(self::SQL_CAMPAIGN_ADD);
        $sth->bindParam(':campaign', $campaign);
        $sth->bindParam(':description', $description);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not add campaign':$ei[2]);
        }
    }

    public function edit($id, $campaign, $description) {
        $sth = $this->sql->prepare(self::SQL_CAMPAIGN_EDIT);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->bindParam(':campaign', $campaign);
        $sth->bindParam(':description', $description);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not edit campaign':$ei[2]);
        }
    }

    public function delete($id) {
        $sth = $this->sql->prepare(self::SQL_CAMPAIGN_DELETE);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not delete campaign':$ei[2]);
        }
    }
}
?>
