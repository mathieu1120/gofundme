<?php

class IndexController extends Controller
{
  public function run()
  {
    $controller = new RestaurantController();
    $controller->init();

    if (isset($_POST) && $_POST)
    $controller->postProcess();

    $this->displayHeader();
    $controller->run();
    $this->displayFooter();                    
  }

  public function displayHeader()
  {
    parent::display('header');
  }

  public function displayFooter()
  {
    parent::display('footer');
  }
}