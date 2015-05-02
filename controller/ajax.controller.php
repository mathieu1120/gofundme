<?php

class AjaxController extends Controller
{
  public $view = 'ajax';

  public function run()
  {
    if (!post('controller') || !post('action'))
    return null;

    $id = (int)post('id');
    $controller = post('controller');
    $action = post('action');
    $ajax = new Ajax($controller, $action, $id, $_POST);
    self::$viewVars['ajaxJSON'] = array();
    if ($ajax->execute() && self::$viewVars['ajaxJSON'])
    {
      $this->display();
      return true;
    }
    return false;
  }
}