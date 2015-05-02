<?php
$content = '<table id="last-restaurant" class="table table-striped table-bordered">
  <tr>
    <th>ID</th>
    <th>Restaurant Name</th>
    <th>Description</th>
    <th>Cuisine</th>
    <th>Rate</th>
    <th>Location</th>
  </tr>';

  foreach ($viewVars['restaurantList'] as $restaurant)
  {
    $content .= '<tr>
                        <td>'.dp($restaurant['id_restaurant']).'</td>
                        <td>'.dp($restaurant['name']).'</td>
                        <td>'.dp($restaurant['description']).'</td>
                        <td>'.dp($restaurant['cuisine_name']).'</td>
                        <td>'.dp($restaurant['rate']).' / 5</td>
                        <td>'.dp($restaurant['location']).'</td>
                </tr>';
  }

$content .= '</table>';