<?php

$content = '<table class="table table-striped table-bordered">
  <tr>
    <th>ID</th>
    <th>Restaurant Name</th>
    <th>Description</th>
    <th>Cuisine</th>
    <th>Rate (x/5)</th>
    <th>Location</th>
    <th>action</th>
  </tr>';
if (!$viewVars['restaurantList'])
$content .= '<tr><td colspan="6">No restaurants found</td></tr>';
foreach ($viewVars['restaurantList'] as $restaurant)
{
  $content .= '<tr>
                        <td data-field="id_restaurant">'.(int)$restaurant['id_restaurant'].'</td>
                        <td data-field="name" data-form-type="text">'.dp($restaurant['name']).'</td>
                        <td data-field="description" data-form-type="textarea">'.dp($restaurant['description']).'</td>
                        <td data-field="cuisine.name" data-form-type="select" data-form-options="ajaxGetCuisineList">'.dp($restaurant['cuisine.name']).'</td>
                        <td data-field="rate" data-form-type="text">'.(int)$restaurant['rate'].'</td>
                        <td data-field="location" data-form-type="textarea">'.dp($restaurant['location']).'</td>
                        <td data-action="id_restaurant">
                                <button rel="'.(int)$restaurant['id_restaurant'].'" data-edit="data-edit" class="btn btn-default">Edit</button>
                                <button rel="'.(int)$restaurant['id_restaurant'].'" data-remove="data-remove" class="btn btn-danger">Remove</button>
                        </td>
                </tr>';
}

$content .= '</table>';