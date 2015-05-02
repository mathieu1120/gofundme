$('.nav-tabs li').click(function(){
    $('.tab-content, .nav-tabs li').removeClass('active');
    $(this).addClass('active');
    $('#'+$(this).attr('data-display')).addClass('active');
});

$('form').submit(function(){
    var error = false;
    $.each($(this).find('.required'), function(){
	if ($(this).hasClass('required') && $(this).val() == '')
	{
	    $(this).closest('.form-group').addClass('has-error');
	    $(this).next().show();
	    error = true;
	}
    });
    if (error)
	return false;
    return true;
});

$('#load-more-rows').click(function(){
    var button = $(this);
    var text = button.text();
    if (text == 'Loading...')
	return false;

    var start = parseInt(button.attr('rel'));
    button.text('Loading...');
    $.ajax({url: 'ajax.php',
	    method: 'POST',
	    data: {controller: 'restaurant',
		   action: 'ajaxLoadMoreRestaurant',
		   start: start
		  }
	   }).done(function(data){
	       var restaurants = JSON.parse(data);
	       var lastRestaurant = $('#list table');

	       if (restaurants.restaurants)
	       {
		   var size = restaurants.restaurants.length;
		   $.each(restaurants.restaurants, function(i, restaurant){
		       lastRestaurant.append('<tr><td>'+restaurant.id_restaurant+'</td><td>'+restaurant.name+'</td><td>'+restaurant.description+'</td><td>'+restaurant['cuisine.name']+'</td><td>'+restaurant.rate+' / 5</td><td>'+restaurant.location+'</td></tr>');
		   });
		   button.attr('rel', start + parseInt(size));
	       }
	       button.text(text);
	       
	   }).fail(function(data){
	       console.log('fail, please do something');
	       button.text(text);
	   });
});


$('input[name="search"]').keyup(function(){
    var search = $(this).val();
    
    $.ajax({url: 'ajax.php',
	    method: 'POST',
	    data: {controller: 'restaurant',
		   action: 'ajaxLoadTableFromSearch',
		   search: search
		  }
	   }).done(function(data){
	       $('#results').html(data);
	   }).fail(function(data){
	       console.log('fail, please do something');
	   });
});

