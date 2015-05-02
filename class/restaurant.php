<?php

class Restaurant extends MySQL
{
  public $table = 'restaurant';

  public $name = '';
  public $description = '';

  public $id_cuisine = 0;
  public $rate = 0;
  public $location = '';

  public function findAllLikeStartName()
  {
    return Db::getInstance()->executeSelect('SELECT r.*, c.name as "cuisine.name" FROM restaurant AS r
                                             LEFT JOIN cuisine AS c ON (c.id_cuisine = r.id_cuisine)
                                             WHERE r.name LIKE "'.pSQL($this->name).'%" OR c.name LIKE "'.pSQL($this->name).'%"');
  }
}