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
<?php
echo '<div id="results">'.(isset($viewVars['restaurant-result']) ? $viewVars['restaurant-result'] : '').'</div>';
?>
<div class="margin-20">
  <ul class="nav nav-tabs">
    <li data-display="list" class="active"><a href="#">List</a></li>
    <li data-display="restaurant-form"><a href="#">Add Restaurant</a></li>
    <li data-display="cuisine-form"><a href="#">Add Cuisine</a></li>
  </ul>
</div>

<div class="tab-content" id="restaurant-form">
  <form name="add-restaurant" class="form-horizontal margin-20" action="./" method="post">
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

<div class="tab-content" id="cuisine-form">
  <form name="add-cuisine" class="form-horizontal margin-20" action="./" method="post">
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

<div id="list" class="tab-content active">
  <h2>Last Added Restaurant</h2>
  <?php echo $viewVars['restaurantList'];?>
  <button class="btn btn-primary center-block" id="load-more-rows" rel="5">Load more rows (Max 5)</button>
</div>
<hr/>