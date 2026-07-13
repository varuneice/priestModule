<?php
require_once FRAMEWORK_PATH . 'Object.class.php';
include_once FRAMEWORK_PATH . 'FluentStructure.php';
include_once FRAMEWORK_PATH . 'FluentUtils.php';
include_once FRAMEWORK_PATH . 'FluentLiteral.php';
include_once FRAMEWORK_PATH . 'BaseQuery.php';
include_once FRAMEWORK_PATH . 'CommonQuery.php';
include_once FRAMEWORK_PATH . 'SelectQuery.php';
include_once FRAMEWORK_PATH . 'InsertQuery.php';
include_once FRAMEWORK_PATH . 'UpdateQuery.php';
include_once FRAMEWORK_PATH . 'DeleteQuery.php';

class Model extends GzObject {

    protected $pdo, $structure;
    protected static $pdoPool = array();

    /** @var boolean|callback */
    public $debug;
    public $engine = 'mysql';
    public $host = '';
    public $database = '';
    public $user = '';
    public $pass = '';
    var $primaryKey = null;
    var $prefix = null;

    /**
     * Table name
     *
     * @access public
     * @var string
     */
    var $table = null;

    /**
     * Prefix of table names
     *
     * @access public
     * @var string
     */
    function setDatabase($db) {
        if (!empty($db)) {
            $this->database = $db;
        }
    }

    function setHost($host) {
        if (!empty($host)) {
            $this->host = $host;
        }
    }

    function setUser($user) {
        if (!empty($user)) {
            $this->user = $user;
        }
    }

    function setPass($pass) {
        if (!empty($pass)) {
            $this->pass = $pass;
        }
    }

    function __construct(?FluentStructure $structure = null) {

        if (defined('DEFAULT_PREFIX')) {
            $this->prefix = DEFAULT_PREFIX;
        }

        if (defined('DEFAULT_DB')) {
            $this->setDatabase(DEFAULT_DB);
        }
        if (defined('DEFAULT_HOST')) {
            $this->setHost(DEFAULT_HOST);
        }
        if (defined('DEFAULT_USER')) {
            $this->setUser(DEFAULT_USER);
        }
        if (defined('DEFAULT_PASS')) {
            $this->setPass(DEFAULT_PASS);
        }

        $is_remote = ($this->host !== 'localhost' && $this->host !== '127.0.0.1');
        $db_user = $this->user;

        $dns = $this->engine . ':dbname=' . $this->database
            . ';host=' . $this->host
            . ';charset=utf8mb4';

        $pdo_options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        );

        // Azure Database for MySQL requires SSL for remote hosts.
        if ($is_remote) {
            // Find system CA cert bundle (Windows XAMPP or Linux)
            $ca_paths = [
                'C:\xampp82\apache\bin\curl-ca-bundle.crt', // Windows XAMPP
                '/etc/ssl/certs/ca-certificates.crt',
                '/etc/pki/tls/certs/ca-bundle.crt',
                '/etc/ssl/ca-bundle.pem',
            ];
            foreach ($ca_paths as $ca) {
                if (file_exists($ca)) {
                    $pdo_options[PDO::MYSQL_ATTR_SSL_CA] = $ca;
                    break;
                }
            }
            $pdo_options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
        }

        try {
            $poolKey = sha1($dns . "\n" . $this->user . "\n" . $this->pass . "\n" . serialize($pdo_options));
            if (!isset(self::$pdoPool[$poolKey])) {
                if (class_exists('DbProfiler')) {
                    DbProfiler::start();
                    $connectStartedAt = microtime(true);
                }
                self::$pdoPool[$poolKey] = new PDO($dns, $db_user, $this->pass, $pdo_options);
                if (class_exists('DbProfiler')) {
                    DbProfiler::recordConnect(microtime(true) - $connectStartedAt, $this->host, $this->database);
                }
                // Azure MySQL enforces ONLY_FULL_GROUP_BY; remove it once per request connection.
                $queryStartedAt = microtime(true);
                self::$pdoPool[$poolKey]->exec("SET SESSION sql_mode = REPLACE(@@SESSION.sql_mode, 'ONLY_FULL_GROUP_BY', '')");
                if (class_exists('DbProfiler')) {
                    DbProfiler::recordQuery(microtime(true) - $queryStartedAt, "SET SESSION sql_mode = REPLACE(@@SESSION.sql_mode, 'ONLY_FULL_GROUP_BY', '')");
                }
            }
            $this->pdo = self::$pdoPool[$poolKey];
        } catch (Exception $e) {
            $msg = 'DB connection failed: ' . $e->getMessage();
            error_log('[Model] ' . $msg . ' | host=' . $this->host . ' user=' . $db_user . ' db=' . $this->database);
            die($msg);
        }
        if (!$structure) {
            $structure = new FluentStructure;
        }
        $this->structure = $structure;
    }

    /** Create SELECT query from $table
     * @param string $table  db table name
     * @param integer $primaryKey  return one row by primary key
     * @return \SelectQuery
     */
    public function from($table, $primaryKey = null) {
        $query = new SelectQuery($this, $table);
        if ($primaryKey) {
            $tableTable = $query->getFromTable();
            $tableAlias = $query->getFromAlias();
            $primaryKeyName = $this->structure->getPrimaryKey($tableTable);
            $query = $query->where("$tableAlias.$primaryKeyName", $primaryKey);
        }
        return $query;
    }

    /** Create INSERT INTO query
     *
     * @param string $table
     * @param array $values  you can add one or multi rows array @see docs
     * @return \InsertQuery
     */
    public function insertInto($table, $values = array()) {

        $query = new InsertQuery($this, $table, $values);
// echo   $query->getQuery();
        return $query;
    }

    /** Create UPDATE query
     *
     * @param string $table
     * @param array|string $set
     * @param string $primaryKey
     *
     * @return \UpdateQuery
     */
     
     
    //  4 0ctober  2025 update changes -varun
    public function update_4october_2025($data = array()) {
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
    
    public function update($data = array())
{
    $primaryKeyName = $this->getStructure()->getPrimaryKey($this->getTable());

    // 1. Require primary key to prevent accidental full updates
    if (!isset($data[$primaryKeyName]) || $data[$primaryKeyName] === '') {
        $this->logAction("Update skipped: missing primary key in data");
        return false;
    }

    $save = [];
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

    if (empty($save)) {
        $this->logAction("No data to update for ID: " . $data[$primaryKeyName]);
        return false;
    }

    $query = new UpdateQuery($this, $this->getTable());
    $query->set($save);
    $query = $query->where($primaryKeyName, $data[$primaryKeyName]);

     $sqlString = method_exists($query, 'getQuery')
        ? $query->getQuery()
        : (method_exists($query, 'getSql') ? $query->getSql() : '[SQL not available]');


    $this->logAction(
        "Updating table: " . $this->getTable() .
        " | WHERE " . $primaryKeyName . " = " . $data[$primaryKeyName] .
        " | Data: " . json_encode($save) .
        " | SQL: " . $sqlString
    );

    // Execute the update
    $result = $query->execute();

    // 3. Log the result
    $this->logAction("Update completed for " . $primaryKeyName . " = " . $data[$primaryKeyName]);

    return $result;
}

private function logAction($message)
{
    $logDir = __DIR__ . '/logs'; // directory for logs
    $logFile = $logDir . '/db_update_log.txt';

    // Create folder if not exists
    if (!file_exists($logDir)) {
        mkdir($logDir, 0777, true);
    }

    $timestamp = date("Y-m-d H:i:s");
    $entry = "[$timestamp] $message" . PHP_EOL;

    file_put_contents($logFile, $entry, FILE_APPEND);
}

    /** Create DELETE query
     *
     * @param string $table
     * @param string $primaryKey  delete only row by primary key
     * @return \DeleteQuery
     */
    public function delete($table, $primaryKey = null) {
        $query = new DeleteQuery($this, $table);
        if ($primaryKey) {
            $primaryKeyName = $this->getStructure()->getPrimaryKey($table);
            $query = $query->where($primaryKeyName, $primaryKey);
        }
        return $query;
    }

    /** Create DELETE FROM query
     *
     * @param string $table
     * @param string $primaryKey
     * @return \DeleteQuery
     */
    public function deleteFrom($table, $primaryKey = null) {
        $args = func_get_args();
        return call_user_func_array(array($this, 'delete'), $args);
    }

    /** @return \PDO
     */
    public function getPdo() {
        return $this->pdo;
    }

    /** @return \FluentStructure
     */
    public function getStructure() {
        return $this->structure;
    }

    public function getTable() {
        return $this->prefix . $this->table;
    }

    public function getAll($options = null, $column = null, $limit = null) {

        $query = $this->from($this->getTable() . ' as t1')->where($options);

        if (!empty($column)) {
            if (strpos($column, ' ') !== false) {
                $query->orderBy($column);
            } else {
                $query->orderBy("`" . $column . "`");
            }
        }
        if (!empty($limit)) {
            $query->limit($limit);
        }
        /*
          $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />';
         */

        return $query->fetchAll();
    }

    public function getI18nAll($options = null, $column = null) {
        $this->loadFiles('model', array('Field'));
        $FieldModel = new FieldModel();

        $query = $this->from($this->getTable())->where($options);

        if (!empty($column)) {

            $query->orderBy("`" . $column . "`");
        }

        $arr = $query->fetchAll();
/////////////////////////////////////////////////////
        $result = array();
        if (!empty($arr)) {
            foreach ($arr as $key => $row) {
                $result[$key] = $row;

                $opts['table_name'] = $this->getTable();
                $opts['in_id'] = $row['id'];

                $query = $this->from($FieldModel->getTable())->where($opts);
                $i18n_arr = $query->fetchAll();

                foreach ($i18n_arr as $k => $value) {
                    $result[$key]['i18n'][$value['language_id']][$value['field_name']] = $value['value'];
                }
            }
        }
        /* $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />'; */
        return $result;
    }

    function getI18n($id = null) {
        $this->loadFiles('model', array('Field'));
        $FieldModel = new FieldModel();
        $options['id'] = $id;
        $query = $this->from($this->getTable())->where($options);

        $arr = $query->fetchAll();
        if (empty($arr)) {
            return array();
        }
        $row = $arr[0];
/////////////////////////////////////////////////////
        $result = array();
        $result = $row;

        $opts['table_name'] = $this->getTable();
        $opts['in_id'] = $row['id'];

        $query = $this->from($FieldModel->getTable())->where($opts);
        $i18n_arr = $query->fetchAll();

        foreach ($i18n_arr as $k => $value) {
            $result['i18n'][$value['language_id']][$value['field_name']] = $value['value'];
        }

        /* $query->debug=true;
          echo $query->getQuery();
          print_r($query->getParameters());
          echo '<br />'; */
        return $result;
    }

    public function get($id = null) {

        $primaryKeyName = $this->getStructure()->getPrimaryKey($this->getTable());
        if (!empty($id)) {

            return $this->from($this->getTable())->where($primaryKeyName, $id)->fetch();
        }
    }

    public function save($data) {
        $save = array();

        foreach ($this->schema as $field) {

            if (isset($data[$field['name']])) {

                $val = is_array($data[$field['name']])
                    ? (isset($data[$field['name']][0]) ? $data[$field['name']][0] : null)
                    : $data[$field['name']];

                if ($val === null) {
                    continue; // skip NULLs — let DB default handle it
                }

                // MySQL strict mode: empty string or non-numeric string is invalid for numeric/date columns.
                // Convert to NULL so DB uses column default or allows NULL.
                $type = strtolower($field['type'] ?? '');
                if (in_array($type, ['int','integer','smallint','tinyint','mediumint','bigint','float','double','decimal','real'])) {
                    if ($val === '' || (is_string($val) && !is_numeric($val))) {
                        $val = null;
                    }
                } elseif (in_array($type, ['date','datetime','timestamp','time','year'])) {
                    if ($val === '') {
                        $val = null;
                    }
                }

                if ($val !== null) {
                    $save["`" . $field['name'] . "`"] = $val;
                }
            }
        }
        if (count($save) > 0) {

            $query = $this->insertInto($this->getTable(), $save);
            
            return $lastInsert = $query->execute();
        }
        return false;
    }

    function getColumnType($column) {
        foreach ($this->schema as $col) {
            if ($col['name'] == $column) {
                return $col['type'];
            }
        }
        return false;
    }

    function escape($value, $column = null, $type = null) {
        if (is_null($type) && !is_null($column)) {
            $type = $this->getColumnType($column);
        }

        switch ($type) {
            case 'null':
                return $value;
                break;
            case 'int':
            case 'smallint':
            case 'tinyint':
            case 'mediumint':
            case 'bigint':
                return intval($value);
                break;
            case 'float':
            case 'decimal':
            case 'double':
            case 'real':
                return floatval($value);
            default : return $value;
                break;
        }
    }

    function execute($sql) {
        $pdo = $this->getPdo();

        $stmt = $pdo->prepare($sql);

        $stmt->execute();
        return $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCount($opts) {
        $arr = $this->getAll($opts);

        return is_array($arr) ? count($arr) : 0;
    }
    public function getbymemberid($id = null) {
        $sql = 'SELECT * FROM '.$this->getTable().' WHERE Member_id="'."$id".'"';
        $arr = $this->execute($sql);
        return !empty($arr) ? $arr[0] : null;
    }
    public function getparking($ID) {

        $sql = 'SELECT * FROM '.$this->getTable().' WHERE ID="'."$ID".' ORDER BY `donation_pay_date` DESC LIMIT 1"';
        $arr = $this->execute($sql);
        return !empty($arr) ? $arr[0] : null;
    }
    public function membersave($data) {
        $save = array();

        foreach ($this->schema as $field) {

            if (isset($data[$field['name']])) {

                $val = !is_array($data[$field['name']])
                    ? $data[$field['name']]
                    : (isset($data[$field['name']][0]) ? $data[$field['name']][0] : null);

                if ($val === null) {
                    continue;
                }

                $type = strtolower($field['type'] ?? '');
                if ($val === '' && in_array($type, ['int','integer','smallint','tinyint','mediumint','bigint','float','double','decimal','real'])) {
                    $val = null;
                } elseif ($val === '' && in_array($type, ['date','datetime','timestamp','time','year'])) {
                    $val = null;
                }

                if ($val !== null) {
                    $save["`" . $field['name'] . "`"] = $val;
                }
            }
        }
        if (count($save) > 0) {

            $query = $this->insertInto($this->getTable(), $save);

            $result = $query->execute();
            return $result !== false;
        }
        return false;
    }

}