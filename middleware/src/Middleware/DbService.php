<?php
namespace Middleware;
use Throwable;
use PDO;
class DbService {
    const FIELDS   = ['date','status','amount','description','customer'];
    const STATUS   = ['all','open','cancelled','held','invoiced','complete'];
    const OK_INS   = 'SUCCESS: data inserted OK';
    const OK_DEL   = 'SUCCESS: data removed OK';
    const ERR_CUST = 'ERROR: missing or invalid customer ID';
    const ERR_EXEC = 'ERROR: unable to execute database statement';
    const ERR_STATUS = 'ERROR: status must be one of "all|open|cancelled|held|invoiced|complete"';
    const ERR_AMOUNT = 'ERROR: amount must be a non-zero value';
    const ERR_INS    = 'ERROR: unable to insert data';
    public static $pdo = NULL;
    public static function getPDO()
    {
        if (empty(self::$pdo)) {
            $dsn = 'mysql:host=localhost;dbname=' . DB_CONFIG['dbname'];
            self::$pdo = new PDO($dsn,  DB_CONFIG['dbuser'], DB_CONFIG['dbpwd']);
        }
        return self::$pdo;
    }
	public static function getList(int $id = 0) {
        $pdo = self::getPDO();
        $sql = 'SELECT * FROM orders';
        if ($id !== 0) {
            $sql .= ' WHERE id=' . $id;
        } else {
            $sql .= ' ORDER BY `date` DESC';
        }
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function remove(int $id) : int {
        $pdo = self::getPDO();
        $sql = 'DELETE FROM orders WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        if (!$stmt->execute([$id])) {
            $msg[] = self::ERR_EXEC;
            return FALSE;
        }
        $msg[] = self::OK_DEL;
        return $stmt->rowCount();
    }
    public static function insert(array $data, array &$msg = []) : int {
        foreach ($data as $key => $val)
            $data[$key] = strip_tags(trim($val));
        $pdo = self::getPDO();
        $err = 0;
        // not all validation code is shown
        if (empty($data['status']) || !in_array($data['status'], self::STATUS, TRUE)) {
            $msg[] = self::ERR_STATUS;
            $err++;
        }
        if (empty($data['amount'])) {
            $msg[] = self::ERR_AMOUNT;
            $err++;
        }
        if ($err) return 0;
        $data['amount'] = (float) $data['amount'];
        $data['customer'] = (int) $data['customer'];
        $data['date'] = date('Y-m-d');
        $sql = 'INSERT INTO orders (`' . implode('`,`', self::FIELDS) . '`) ';
        $sql .= 'VALUES (:' . implode(',:', self::FIELDS) . ')';
        $ins = [];
        $result = 0;
        foreach (self::FIELDS as $name)
            $ins[':' . $name] = $data[$name] ?? '';
        try {
            $stmt = $pdo->prepare($sql);
            if (!$stmt->execute($ins)) {
                $msg[] = self::ERR_EXEC;
            } else {
                $msg[] = ['insert_id' => $pdo->lastInsertId()];
                $result = $stmt->rowCount();
            }
        } catch (Throwable $t) {
            error_log(__METHOD__ . ':' . $t->getMessage());
            $msg[] = self::ERR_INS;
        }
        return $result;
    }
}
