<?php

class Ajax
{
  public $controller;
  public $action;
  public $id;
  public $param;

  public function __construct($controller, $action, $id = 0, $param = array())
  {
    $this->action = $action;
    $this->id = $id;
    $this->param = $param;
    $this->controller = ucfirst($controller).'Controller';

    unset($this->param['controller']);
    unset($this->param['action']);
  }

  public function execute()
  {
    $obj = new $this->controller((int)$this->id);
    $methode = $this->action;
    return $obj->$methode($this->param);
  }
}