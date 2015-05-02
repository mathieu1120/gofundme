<?php

$content = '<table class="table table-striped table-bordered">
  <tr>
    <th>ID</th>
    <th>Restaurant Name</th>
    <th>Description</th>
    <th>Cuisine</th>
    <th>Rate</th>
    <th>Location</th>
  </tr>';
if (!$viewVars['restaurantList'])
$content .= '<tr><td colspan="6">No restaurants found</td></tr>';
foreach ($viewVars['restaurantList'] as $restaurant)
{
  $content .= '<tr>
                        <td>'.dp($restaurant['id_restaurant']).'</td>
                        <td>'.dp($restaurant['name']).'</td>
                        <td>'.dp($restaurant['description']).'</td>
                        <td>'.dp($restaurant['cuisine.name']).'</td>
                        <td>'.dp($restaurant['rate']).' / 5</td>
                        <td>'.dp($restaurant['location']).'</td>
                </tr>';
}

$content .= '</table>';