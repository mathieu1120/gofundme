<?php

ini_set('display_errors', E_ALL);

define('URI', '/gofundme/');

define('VIEW_DIR', dirname(__FILE__).'/view/');
define('CONTROLLER_DIR', dirname(__FILE__).'/controller/');
define('CLASS_DIR', dirname(__FILE__).'/class/');
define('CSS_URI', URI.'css/');
define('JS_URI', URI.'js/');
define('CSS_DIR', dirname(__FILE__).'/css/');
define('JS_DIR', dirname(__FILE__).'/js/');

require_once(dirname(__FILE__).'/database.php');

spl_autoload_register(function($class){

  $classLower = strtolower($class);
  if (($controllerPos = strpos($classLower, 'controller')) !== false)
  {
    if (!$controllerPos)
    $controllerName = $classLower;
    else
    $controllerName = substr($classLower, 0, $controllerPos);
    if (file_exists(CONTROLLER_DIR.'/'.$controllerName.'.controller.php'))
    require_once(CONTROLLER_DIR.'/'.$controllerName.'.controller.php');
    else
    d($controllerName.'.controller.php doesn\'t exists');
  }
  else
  {
    if (file_exists(CLASS_DIR.'/'.$classLower.'.php'))
    require_once(CLASS_DIR.'/'.$classLower.'.php');
    else
    d($classLower.'.php doesn\'t exists');
  }
});

function d($object, $die = true)
{
  echo '<pre>';
  var_dump($object);
  if ($die)
  die();
}

function dp($string) //display proctect
{
  return htmlspecialchars($string);
}

function pSQL($string)
{
  return Db::getInstance()->escape($string);
}

function post($string)
{
  if (isset($_POST[$string]) && $_POST[$string])
  return $_POST[$string];
  return false;
}

function get($string)
{
  if (isset($_GET[$strinG]) && $_GET[$string])
  return $_GET[$string];
  return false;
}
