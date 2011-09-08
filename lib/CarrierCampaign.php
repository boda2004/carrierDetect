<?php
class CarrierCampaign extends BaseClass {
    const SQL_CC_ROW = 'SELECT * FROM carrier_campaign WHERE carrier_id=:carrier_id AND campaign_id=:campaign_id';
    const SQL_CC_ROWS = 'SELECT carriers.id AS carrier_id, campaigns.id AS campaign_id, carrier_campaign.redirect_url AS redirect_url FROM carrier_campaign INNER JOIN carriers ON carrier_campaign.carrier_id=carriers.id INNER JOIN campaigns ON carrier_campaign.campaign_id=campaigns.id LIMIT :start, :limit';
    const SQL_CC_ROWS_FOR_CARRIER = 'SELECT carriers.id AS carrier_id, campaigns.id AS campaign_id, carrier_campaign.redirect_url AS redirect_url FROM carrier_campaign INNER JOIN carriers ON carrier_campaign.carrier_id=carriers.id INNER JOIN campaigns ON carrier_campaign.campaign_id=campaigns.id WHERE carrier_campaign.carrier_id=:carrier_id LIMIT :start, :limit';
    const SQL_CC_ROWS_FOR_CAMPAIGN = 'SELECT carriers.id AS carrier_id, carriers.carrier AS carrier, campaigns.id AS campaign_id, campaigns.campaign AS campaign, carrier_campaign.redirect_url AS redirect_url FROM carrier_campaign INNER JOIN carriers ON carrier_campaign.carrier_id=carriers.id INNER JOIN campaigns ON carrier_campaign.campaign_id=campaigns.id WHERE carrier_campaign.campaign_id=:campaign_id LIMIT :start, :limit';
    const SQL_CC_ADD = 'INSERT INTO carrier_campaign (carrier_id, campaign_id, redirect_url) VALUES(:carrier_id, :campaign_id, :redirect_url)';
    const SQL_CC_EDIT = 'UPDATE carrier_campaign SET redirect_url=:redirect_url WHERE carrier_id=:carrier_id AND campaign_id=:campaign_id';
    const SQL_CC_DELETE = 'DELETE FROM carrier_campaign WHERE carrier_id=:carrier_id AND campaign_id=:campaign_id';
    public function getCC($carrier_id, $campaign_id) {
        $sth = $this->sql->prepare(self::SQL_CC_ROW, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':carrier_id', $carrier_id, PDO::PARAM_INT);
        $sth->bindParam(':campaign_id', $campaign_id, PDO::PARAM_INT);
        $sth->execute();
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            throw new Exception('Could not find carrier campaign');
        }
        return $row;
    }
    public function getList($start = 0, $limit = 100) {
        $sth = $this->sql->prepare(self::SQL_CC_ROWS, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':start', $start, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getListForCarrier($carrier_id, $start = 0, $limit = 100) {
        $sth = $this->sql->prepare(self::SQL_CC_ROWS_FOR_CARRIER, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':carrier_id', $carrier_id, PDO::PARAM_INT);
        $sth->bindParam(':start', $start, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getListForCampaign($campaign_id, $start = 0, $limit = 100) {
        $sth = $this->sql->prepare(self::SQL_CC_ROWS_FOR_CAMPAIGN, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->bindParam(':campaign_id', $campaign_id, PDO::PARAM_INT);
        $sth->bindParam(':start', $start, PDO::PARAM_INT);
        $sth->bindParam(':limit', $limit, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function add($carrier_id, $campaign_id, $redirect_url) {
        $sth = $this->sql->prepare(self::SQL_CC_ADD);
        $sth->bindParam(':carrier_id', $carrier_id, PDO::PARAM_INT);
        $sth->bindParam(':campaign_id', $campaign_id, PDO::PARAM_INT);
        $sth->bindParam(':redirect_url', $redirect_url);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not add carrier campaign':$ei[2]);
        }
    }

    public function edit($carrier_id, $campaign_id, $redirect_url) {
        $sth = $this->sql->prepare(self::SQL_CC_EDIT);
        $sth->bindParam(':carrier_id', $carrier_id, PDO::PARAM_INT);
        $sth->bindParam(':campaign_id', $campaign_id, PDO::PARAM_INT);
        $sth->bindParam(':redirect_url', $redirect_url);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not edit carrier campaign':$ei[2]);
        }
    }

    public function delete($carrier_id, $campaign_id) {
        $sth = $this->sql->prepare(self::SQL_CC_DELETE);
        $sth->bindParam(':carrier_id', $carrier_id, PDO::PARAM_INT);
        $sth->bindParam(':campaign_id', $campaign_id, PDO::PARAM_INT);
        $sth->execute();
        if ($sth->rowCount() != 1) {
            $ei = $sth->errorInfo();
            throw new Exception(empty($ei[2])?'Could not delete carrier campaign':$ei[2]);
        }
    }
}
?>
