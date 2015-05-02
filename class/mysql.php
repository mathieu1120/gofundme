<?php

abstract class MySQL
{
  protected $table = '';
  public $id = null;

  protected $_fields = array();

  public function __construct($id = null)
  {
    if ($id)
    {
      if ($row = Db::getInstance()->getRow($this->table, array('id_'.$this->table => (int)$id)))
      {
        foreach ($row as $field => $value)
        {
          if (isset($this->$field))
          {
            $this->$field = $value;
            $this->_fields[] = $field;
          }
        }
        $this->id = $id;
      }
    }
    if (!$this->_fields)
    {
      $columns = Db::getInstance()->getColumnsFromTable($this->table);
      foreach ($columns as $column)
      {
        if ($column['Field'] == 'id_'.$this->table)
        continue;
        $this->_fields[] = $column['Field'];
      }
    }
    if (isset($row))
    return $row;
    return true;
  }

  public function create()
  {
    if (!$this->_fields)
    return false;

    $param = array();
    foreach ($this->_fields as $field)
    {
      if (isset($this->$field))
      $param[$field] = $this->$field;
    }

    return Db::getInstance()->insert($this->table, $param);
  }

  public function update($param = array(), $where = array())
  {
    if (!$where)
    $where['id_'.$this->table] = (int)$this->id;

    if (!$param)
    {
      if (!$this->_fields)
      return false;

      foreach ($this->_fields as $field)
      {
        if (isset($this->$field))
        $param[$field] = $this->$field;
      }
    }

    return Db::getInstance()->update($this->table, $param, $where);
  }

  public function remove()
  {
    if ($this->id)
    return Db::getInstance()->remove($this->table, array('id_'.$this->table => (int)$this->id));
    return false;
  }

  public function getList($where = array(), $order = array(), $start = 0, $limit = null)
  {
    $join = array();
    $leftJoin = '';
    $select = array('id_'.$this->table);
    foreach ($this->_fields as $field)
    {
      $select[] = $this->table.'.'.$field;
      if ($field != 'id_'.$this->table && strpos($field, 'id_') !== false)
      {
        $table = str_replace('id_', '', $field);
        $class = str_replace(' ', '', ucwords(str_replace('_', ' ', $table)));
        $obj = new $class();
        foreach ($obj->getColumn() as $f)
        $select[] = $table.'.'.$f.' AS "'.$table.'.'.$f.'"';
        $join[] = $table;
        $leftJoin .= ' LEFT JOIN '.$table.' AS '.$table.' ON ('.$table.'.'.$field.' = '.$this->table.'.'.$field.')';
      }
    }
    $w = '';
    if ($where)
    $w = Db::getInstance()->getWhere($where, $this->table);

    $o = '';
    if (count($order) == 1)
    {
      $o = ' ORDER BY '.$this->table.'.`'.key($order).'` '.$order[key($order)];
    }
    else if ($order)
    {
      $o = ' ORDER BY';
      foreach ($order as $field => $ord)
      $o .= ' '.$this->table.'.`'.$field.'` '.$ord.',';
      $o = substr($o, 0, -1);
    }

    $sql = 'SELECT '.implode(', ', $select).'
            FROM '.$this->table.' AS '.$this->table.$leftJoin.$w.$o.($limit ? ' LIMIT '.(int)$start.', '.($limit) : '');

    return Db::getInstance()->executeSelect($sql);
  }

  public function addUpdate()
  {
    if ($this->id)
    return $this->update();
    else 
    if ($this->id = $this->create())
    return $this->id;
  }

  public function find()
  {
    $param = array();

    foreach ($this->_fields as $field)
    {
      if (isset($this->$field) && $this->$field)
      $param[$field] = $this->$field;
    }
    
    if ($row = Db::getInstance()->getRow($this->table, $param))
    {
      foreach ($row as $field => $value)
      {
        if (isset($this->$field))
        $this->$field = $value;
        else if ($field == 'id_'.$this->table)
        $this->id = (int)$value;
      }
      return $row;
    }
    return true;
  }

  public function getColumn()
  {
    return $this->_fields;
  }
}
