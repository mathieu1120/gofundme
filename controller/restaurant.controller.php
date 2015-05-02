<?php

class RestaurantController extends Controller
{
  public $view = 'restaurant';

  public function init()
  {
    self::$media['css'][] = 'restaurant';
    self::$media['js'][] = 'jquery.min';
    self::$media['js'][] = 'restaurant';
    //add jquery
  }

  public function postProcess()
  {
    if (post('search-restaurant') && post('search'))
    $this->processSearch(post('search'));
    else if (post('add-restaurant'))
    $this->processRestaurant();
    else if (post('add-cuisine'))
    $this->processCuisine();
    
  }

  public function processSearch($search)
  {
    $restaurant = new Restaurant();
    $restaurant->name = pSQL($search);
    self::$viewVars['restaurantList'] = $restaurant->findAllLikeStartName();
      
    self::$viewVars['restaurant-result'] = $this->getContent('restaurant-result');
  }

  public function getRestaurantListResult()
  {
    return $this->getContent('restaurant-result');
  }

  public function run()
  {
    $cuisine = new Cuisine();
    self::$viewVars['cuisines'] = $cuisine->getList(array(), array('name' => 'ASC'));
    $restaurant = new Restaurant();
    self::$viewVars['restaurantList'] = $restaurant->getList(array(), array('id_restaurant' => 'DESC'), 0, 5);
    self::$viewVars['restaurantList'] = $this->getContent('restaurant-result');

    parent::run();
  }

  public function processRestaurant()
  {
    $restaurant = new Restaurant((int)post('id_restaurant'));
    $restaurant->name = pSQL(post('name'));
    $restaurant->description = pSQL(post('description'));
    $restaurant->id_cuisine = (int)post('id_cuisine');
    $restaurant->rate = post('rate') <= 5 ? (int)post('rate') : 0;
    $restaurant->location = pSQL(post('location'));
    $row = $restaurant->addUpdate();
    self::$viewVars['submitted-restaurant'] = true;
    return $row;
  }

  public function processCuisine()
  {
    $cuisine = new Cuisine((int)post('id_cuisine'));
    $cuisine->name = pSQL(post('name'));
    return $cuisine->addUpdate();
  }

  public function ajaxLoadMoreRestaurant()
  {
    $restaurant = new Restaurant();
    $restaurantList = $restaurant->getList(array(), array('id_restaurant' => 'DESC'), (int)post('start'), 5);

    self::$viewVars['ajaxJSON'] = array('restaurants' => $restaurantList);
    return true;
  }

  public function ajaxLoadTableFromSearch()
  {
    if (!post('search'))
    return false;

    $this->processSearch(post('search'));
    self::$viewVars['ajaxJSON'] = array('restaurant-result' => self::$viewVars['restaurant-result']);
    return true;
  }

  public function ajaxRemoveRestaurant()
  {
    if (!post('restaurant'))
    return false;

    $restaurant = new Restaurant((int)post('restaurant'));
    self::$viewVars['ajaxJSON'] = array('remove' => $restaurant->remove());
    return true;
  }

  public function ajaxGetCuisineList()
  {
    $cuisine = new Cuisine();
    $options = array();
    foreach ($cuisine->getList(array(), array('name' => 'ASC')) as $c)
    $options[] = array('value' => $c['id_cuisine'], 'text' => $c['name']);
    self::$viewVars['ajaxJSON'] = array('options' => $options);
    return true;
  }

  public function ajaxEditRestaurant()
  {
    if (!post('restaurant'))
    return false;

    $restaurant = new Restaurant((int)post('restaurant'));
    $restaurant->name = pSQL(post('name'));
    $restaurant->description = pSQL(post('description'));
    $restaurant->id_cuisine = (int)post('cuisine_name');
    $restaurant->rate = post('rate') <= 5 ? (int)post('rate') : 0;
    $restaurant->location = pSQL(post('location'));
    return $restaurant->update();
  }
}
