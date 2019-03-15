<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/14 0014
 * Time: 10:25
 */
class Model
{

    public function save()
    {

    }

    public function deleteById()
    {

    }

    public function update()
    {

    }

    public function find()
    {

    }

    public function buildPrimaryWhere()
    {

    }

    public function getRealTableName($tableName, $prefix = '')
    {
        if (!empty($prefix)) {
            $realTableName = $prefix . "_{$tableName}";

        } elseif (isset($GLOBALS['_config']['db']['prefix']) && !empty($GLOBALS['_config']['db']['prefix'])) {
            $realTableName = $GLOBALS['_config']['db']['prefix'] . "_{$tableName}";
        } else {
            $realTableName = $tableName;
        }
        return $realTableName;
    }

    public function buildPO($tableName, $prefix = '')
    {
        $db = Db::getInstance($GLOBALS['_config']['db']);
        $ret = $db->query('SELECT * FROM `information_schema` . `COLUMNS` WHERE TABLE_NAME = :TABLENAME ',
            ['TABLENAME' => $this->getRealTableName($tableName, $prefix)]);
        $className = ucfirst($tableName); // 暂时不考虑驼峰法命名
        $file = _APP . 'model' . DIRECTORY_SEPARATOR . $className . '.php';
        $classString = "<?php \r\nclass $className extends Model{ \r\n";
        foreach ($ret as $key => $value) {
            $classString .= 'public $'."{$value['COLUMN_NAME']};";
            if (!empty($value['COLUMN_COMMENT'])){
                $classString .= "                // {$value['COLUMN_COMMENT']}";
            }
            $className .= "\r\n";
        }
        $classString .="}";
        file_put_contents($file,$classString);
    }


    public function getTableNameByPO($reflect)
    {
        // 反向降解 从类名生成表名
        return $this->getRealTableName(strtolower($reflect->getShortName));
    }
}