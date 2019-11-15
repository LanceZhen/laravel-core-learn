<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/15
 * Time: 10:11
 */
class Model{

    // 定义查询所需要的参数
    protected $wheres;
    protected $limit;
    protected $columns;

    // 获取表名,如果没有定义，将类名转换为复数形式后，在转换为「蛇式」命名，设置表名
    // 例如 UserMobile 会转变为 users
    public function getTable()
    {
        if (! isset($this->table)) {
            return str_replace(
                '\\', '', Str::snake(Str::plural(class_basename($this)))
            );
        }

        return $this->table;
    }

    // 根据上面的一些条件拼装sql;
    public function toSql()
    {
        // 这里实现步骤大家可以自己去拼写
        $sql = '';

        return $sql;
    }

    public function get($columns = ['*'])
    {
        $this->columns = $columns;

        // 执行mysql语句
        $results = mysql_query($this->toSql());

        return $results;
    }

    // 设置参数
    public function take($value)
    {
        return $this->limit = $value;
    }

    public function first($columns)
    {
        return $this->take(1)->get($columns);
    }

    public function where($column, $operator = null, $value = null)
    {
        $this->wheres[] = compact(
            'type', 'column', 'operator', 'value'
        );

        return $this;
    }

    public function find($id, $columns = ['*'])
    {
        return $this->where($this->primaryKey, '=', $id)->first($columns);
    }

    public function __call($method, $parameters)
    {
        return $this->$method(...$parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}

class Article extends Model
{
    protected $primaryKey = 'id';

}

Article::find(1);
