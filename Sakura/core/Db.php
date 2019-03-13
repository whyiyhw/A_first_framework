<?php

/**
 * Created by PhpStorm.
 * User: 13091
 * Date: 2019/3/13
 * Time: 23:10
 */
class Db
{
    /**
     * @var PDO 对象
     */
    private $dbLink;

    protected $queryNum = 0;
    private static $instance;
    protected $PDOStatement;
    // 事物数目
    protected $transTimes = 0;
    protected $bind = [];
    public $rows = 0;

    /**
     * Db constructor.
     * @param $config
     * @throws Throwable
     */
    private function __construct($config)
    {
        $this->connect($config);
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    // 单例

    /**
     * @param $config
     * @return Db
     * @throws Throwable
     */
    public static function getInstance($config)
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * 数据库连接
     *
     * @param $config
     * @return PDO
     * @throws Throwable
     */
    public function connect($config)
    {
        try {
            $this->dbLink = new PDO($config['dsn'], $config['username'], $config['password'], $config['param']);
        } catch (\Throwable $e) {
            throw $e;
        }
        return $this->dbLink;
    }

    /**
     * 原生查询
     *
     * @param $sql
     * @param array $bind
     * @param int $fetchType
     * @return array
     * @throws Exception
     */
    public function query($sql, $bind = [], $fetchType = PDO::FETCH_ASSOC)
    {
        if (!$this->dbLink) {
            throw new \Exception('数据库链接失败');
        }

        $this->PDOStatement = $this->dbLink->prepare($sql);
        $this->PDOStatement->execute($bind);
        $ret = $this->PDOStatement->fetchAll($fetchType);
        $this->rows = count($ret);
        return $ret;
    }

    /**
     * @param $sql
     * @param array $bind
     * @return bool
     * @throws Exception
     */
    public function execute($sql, $bind = [])
    {
        if (!$this->dbLink) {
            throw new \Exception('数据库链接失败');
        }

        $this->PDOStatement = $this->dbLink->prepare($sql);
        $ret = $this->PDOStatement->execute($bind);
        $this->rows = $this->PDOStatement->rowCount();
        return $ret;
    }

    public function startTrans()
    {
        ++$this->transTimes;
        if ($this->transTimes == 1) {
            // 不存在已经开启的事务
            $this->dbLink->beginTransaction();
        } else {
            $this->dbLink->prepare("SAVEPOINT tr{$this->transTimes}")->execute();
        }

    }

    public function commit()
    {
        if ($this->transTimes == 1) {

            $this->dbLink->commit();
        }
        --$this->transTimes;
    }

    public function rollback()
    {
        if ($this->transTimes == 1) {
            $this->dbLink->rollback();
        } elseif ($this->transTimes > 1) {
            $this->dbLink->prepare("ROLLBACK TO SAVEPOINT tr{$this->transTimes}")->execute();
        }
        $this->transTimes = max(0, $this->transTimes - 1);
    }
}