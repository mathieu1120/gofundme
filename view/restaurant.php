<div class="row">
  <form class="form-horizontal" action="./" method="post">
    <div class="form-group">
      <label class="control-label col-sm-4">Search:</label>
      <div class="col-sm-4">
        <input type="text" name="search" class="form-control" />
        <span class="help-block">Please type a restaurant name or a cuisine name</span>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-4">
        <input type="submit" name="search-restaurant" value="search" class="btn btn-default" />
      </div>
    </div>
  </form>
</div>
<hr/>
<div class="row">
  <?php
echo '<div id="results">'.(isset($viewVars['restaurant-result']) ? $viewVars['restaurant-result'] : '').'</div>';
?>
</div>
<hr/>
<div class="margin-20">
  <button type="button" class="btn btn-default" id="restaurant-toggle-form">Add Restaurant</button><button type="button" class="btn btn-default" id="cuisine-toggle-form">Add Cuisine</button>
</div>
<div class="row margin-20" id="restaurant-form">
  <form name="add-restaurant" class="form-horizontal" action="./" method="post">
    <div class="form-group">
      <label class="control-label col-sm-4">Restaurant Name:</label>
      <div class="col-sm-4">
        <input type="text" name="name" class="form-control required" />
        <span class="help-block error">This Field is required</span>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4">Description:</label>
      <div class="col-sm-4">
        <textarea name="description" class="form-control"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4">Cuisine:</label>
      <div class="col-sm-4">
        <select name="id_cuisine" class="form-control required"><option value="">Please Choose</option>
          <?php
          foreach ($viewVars['cuisines'] as $cuisine)
          echo '<option value="'.(int)$cuisine['id_cuisine'].'">'.dp($cuisine['name']).'</option>';
          ?>
        </select>
        <span class="help-block error">Please, select a cuisine</span>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4">Rate:</label>
      <div class="col-sm-4">
        <label class="radio-inline">
          <input type="radio" name="rate" id="inlineRadio1" value="0"> 0
        </label>
        <label class="radio-inline">
          <input type="radio" name="rate" id="inlineRadio1" value="1"> 1
        </label>
        <label class="radio-inline">
          <input type="radio" name="rate" id="inlineRadio1" value="2"> 2
        </label>
        <label class="radio-inline">
          <input type="radio" name="rate" id="inlineRadio1" value="3"> 3
        </label>
        <label class="radio-inline">
          <input type="radio" name="rate" id="inlineRadio1" value="4"> 4
        </label>
        <label class="radio-inline">
          <input type="radio" name="rate" id="inlineRadio1" value="5"> 5
        </label>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4">Location:</label>
      <div class="col-sm-4">
        <textarea name="location" class="form-control"></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-4">
        <input type="submit" name="add-restaurant" value="Add" class="btn btn-default" />
      </div>
    </div>
  </form>
</div>

<div class="row margin-20" id="cuisine-form">
  <form name="add-cuisine" class="form-horizontal" action="./" method="post">
    <div class="form-group">
      <label class="control-label col-sm-4">Cuisine Name:</label>
      <div class="col-sm-4">
        <input type="text" name="name" class="form-control required" />
        <span class="help-block error">This Field is required</span>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-4">
        <input type="submit" name="add-cuisine" value="Add" class="btn btn-default" />
      </div>
    </div>
  </form>
</div>
<hr/>
<div class="row<?php echo (!isset($viewVars['submitted-restaurant']) ? ' hidden' : '');?>">
  <h2>Last Added Restaurant</h2>
  <table id="last-restaurant" class="table table-striped table-bordered">
    <tr>
      <th>ID</th>
      <th>Restaurant Name</th>
      <th>Description</th>
      <th>Cuisine</th>
      <th>Rate</th>
      <th>Location</th>
    </tr>
    <?php
    $i = 0;
    foreach ($viewVars['restaurantList'] as $restaurant)
    {
      echo '<tr>
                        <td>'.dp($restaurant['id_restaurant']).'</td>
                        <td>'.dp($restaurant['name']).'</td>
                        <td>'.dp($restaurant['description']).'</td>
                        <td>'.dp($restaurant['cuisine.name']).'</td>
                        <td>'.dp($restaurant['rate']).' / 5</td>
                        <td>'.dp($restaurant['location']).'</td>
                </tr>';
      $i++;
    }
    ?>
  </table>
  <button class="btn btn-primary center-block" id="load-more-rows" rel="<?php echo $i;?>">Load more rows (Max 5)</button>
</div>
<hr/>