<?php

class AjaxController extends Controller
{
  public function run()
  {
    if (!post('controller') || !post('action'))
    return null;

    $id = (int)post('id');
    $controller = post('controller');
    $action = post('action');
    $ajax = new Ajax($controller, $action, $id, $_POST);
    $ajax->execute();
  }
}