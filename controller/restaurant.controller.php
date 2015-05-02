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
    $this->displayProcessSearch(post('search'));
    else if (post('add-restaurant'))
    $this->processRestaurant();
    else if (post('add-cuisine'))
    $this->processCuisine();
    
  }

  public function displayProcessSearch($search)
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

    echo json_encode(array('restaurants' => $restaurantList));
    return true;
  }

  public function ajaxLoadTableFromSearch()
  {
    if (!post('search'))
    return false;

    $this->displayProcessSearch(post('search'));
    echo self::$viewVars['restaurant-result'];
    return true;
  }
}
