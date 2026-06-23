<?php

require_once MODELS_PATH . 'App.model.php';
class ConfirmCodeModel extends AppModel
{
    public $primaryKey = 'id';
    public $table = 'confirm_code';
    public $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'date', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Confirmation', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Amount', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'Description', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'DonarName', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'UpdatedOn', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'paymentfrom', 'type' => 'date', 'default' => ':NULL')
    );
    public function getMaxAll($payment_system)
    {
       // $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        //$sql = 'SELECT CONCAT(DATE_FORMAT(date,"%d-%M-%Y")," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().' where UpdatedOn="0000-00-00" and `date` >= last_day(now()) + interval 1 day - interval 2 month order by date desc';
        // $sql = 'SELECT CONCAT(DATE_FORMAT(date,"%d-%M-%Y")," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().' where UpdatedOn="0000-00-00" and paymentfrom ="Regularsystem" and `date` > now() - INTERVAL 2 day order by date desc';
        $sql = 'SELECT CONCAT(DATE_FORMAT(date,"%d-%M-%Y")," / ",DonarName," / ",Amount," / ",Confirmation," / ",Description)
        AS Amount
        FROM '.$this->getTable().'
        WHERE (UpdatedOn IS NULL OR CAST(UpdatedOn AS CHAR) = \'0000-00-00\')
        AND paymentfrom="'.$payment_system.'"
        AND `date` > NOW() - INTERVAL 2 DAY
        ORDER BY date DESC';
        
        $arr = $this->execute($sql);
        return $arr;
    }
    public function UpdateCode($cmCode)
    {
        $code =trim($cmCode);
        date_default_timezone_set("America/Chicago");
        $Date = date("Y/m/d");
         $sql = 'UPDATE '.$this->getTable().' SET UpdatedOn="'."$Date".'" WHERE Confirmation="'."$code".'"';
        // $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        $result = array();
        $arr = $this->execute($sql);
        
        return $arr;
        
    }

    public function getAllcode($options = null, $column = null, $limit = null)
    {
        $query = $this->from($this->getTable() . ' as t1')->where($options);

        if (!empty($column)) {
            if (strpos($column, ' ')) {
                $query->orderBy($column);
            } else {
                $query->orderBy("`" . $column . "`");
            }
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }
    }

    public function getMaxAll1()
    {
        $sql = 'SELECT CONCAT(date," / ",DonarName," / ", Amount," / " ,Confirmation," / " ,Description) AS Amount FROM '.$this->getTable().'; ';
        $result = array();
        $arr = $this->execute($sql);
        foreach ($arr as $key => $value) {
            $result[$value['Amount']] = $value['value'];
        }
        return $arr;
        
    }
    public function getByMember($name, $amount, $date = null, $payment_system = 'Regularsystem', $include_id = false)
    {
        $pdo      = $this->getPdo();
        $amtVal   = rtrim(rtrim(str_replace(',', '', ltrim(trim($amount), '$')), '0'), '.');

        $selectId = $include_id ? 'id, ' : '';
        $sql = 'SELECT ' . $selectId . 'CONCAT(DATE_FORMAT(date,"%d-%M-%Y")," / ",DonarName," / ",Amount," / ",Confirmation," / ",Description)
                AS Amount, DonarName
                FROM confirm_code
                WHERE TRIM(TRAILING \'.\' FROM TRIM(TRAILING \'0\' FROM REPLACE(REPLACE(Amount, \'$\', \'\'), \',\', \'\'))) = ?
                AND (UpdatedOn IS NULL OR CAST(UpdatedOn AS CHAR) = \'0000-00-00\')
                AND paymentfrom = ?';

        $params = [$amtVal, $payment_system];

        if (!empty($date)) {
            $sql .= ' AND DATE(date) = ?';
            $params[] = $date;
        }

        $sql .= ' ORDER BY date DESC';

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_values(array_filter($rows, function ($row) use ($name) {
            return $this->zelleNameMatches($row['DonarName'] ?? '', $name);
        }));
    }

    private function normalizeZelleName($value)
    {
        $value = strtolower((string) $value);
        $value = preg_replace('/[^a-z0-9\s]/', ' ', $value);
        return trim(preg_replace('/\s+/', ' ', $value));
    }

    private function zelleNameMatches($zelleName, $searchName)
    {
        $zelleName = $this->normalizeZelleName($zelleName);
        $searchName = $this->normalizeZelleName($searchName);
        if ($zelleName === '' || $searchName === '') {
            return false;
        }
        if ($zelleName === $searchName) {
            return true;
        }
        if (strpos($zelleName, $searchName) !== false || strpos($searchName, $zelleName) !== false) {
            return true;
        }

        $zelleTokens = array_values(array_unique(array_filter(explode(' ', $zelleName))));
        $searchTokens = array_values(array_unique(array_filter(explode(' ', $searchName))));
        if (empty($zelleTokens) || empty($searchTokens)) {
            return false;
        }

        $matches = array_intersect($zelleTokens, $searchTokens);
        $requiredMatches = min(count($zelleTokens), count($searchTokens), 2);
        return count($matches) >= $requiredMatches;
    }

    public function getConfirmCodeCheck($code)
    {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE Confirmation="'."$code".'"';
        return $this->execute($sql);
        
    }

    public function update1($data = array())
    {
        foreach ($this->schema as $field) {
            if (isset($data[$field['name']])) {
                if (!is_array($data[$field['name']])) {
                    $save["`" . $field['name'] . "`"] = $data[$field['name']];
                } else {
                    if (isset($data[$field['name']][0])) {
                        $save["`" . $field['name'] . "`"] = $data[$field['name']][0];
                    }
                }
            }
        }

        $query = new UpdateQuery($this, $this->getTable());
        $query->set($save);
        $primaryKeyName = $this->getStructure()->getPrimaryKey($this->getTable());
        if (!empty($data[$primaryKeyName])) {
            $query = $query->where($primaryKeyName, $data[$primaryKeyName]);
        }

        return $query->execute();
    }
}
?>
