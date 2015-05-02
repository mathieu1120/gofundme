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
	       var row = lastRestaurant.find('tr').last().clone();
	       if (restaurants.restaurants)
	       {
		   var size = restaurants.restaurants.length;
		   $.each(restaurants.restaurants, function(i, restaurant){
		       var rowEdit = row.clone();
		       $.each(rowEdit.find('td'), function(){
			   if ($(this).attr('data-field') != undefined)
			       $(this).html(restaurant[$(this).attr('data-field')]);
			   else if ($(this).attr('data-action') != undefined)
			       $(this).find('button').attr('rel', restaurant[$(this).attr('data-action')]);
		       });
		       lastRestaurant.append(rowEdit);
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

$('#list').on('click', 'table button[data-remove]', function(){
    if (!confirm('Are you sure?'))
	return false;

    var rel = $(this).attr('rel');
    if (!rel)
    {
	console.log('can\'t remove row');
	return false;
    }
    var row = $(this).closest('tr');
    $.ajax({url: 'ajax.php',
	    method: 'POST',
	    data: {controller: 'restaurant',
		   action: 'ajaxRemoveRestaurant',
		   restaurant: rel
		  }
	   }).done(function(data){
	       if (!data)
		   return false;
	       var jsondata = JSON.parse(data);
	       if (jsondata.remove)
		   row.remove();
	       else
		   console.log('can\'t remove row');
	   }).fail(function(data){
	       console.log('fail, please do something');
	   });
});

$('#list').on('click', 'table button[data-edit]', function(){
    $.each($(this).closest('tr').find('td[data-form-type]'), function(){
	if ($(this).attr('data-form-type') == 'text')
	    $(this).html('<input type="text" value="'+$(this).text()+'" />');
	else if ($(this).attr('data-form-type') == 'textarea')
	    $(this).html('<textarea>'+$(this).text()+'</textarea>');
	else if ($(this).attr('data-form-type') == 'select')
	{
	    if ((action = $(this).attr('data-form-options')) == undefined)
		return;
	    var tdElm = $(this);
	    $.ajax({url: 'ajax.php',
		    method: 'POST',
		    data: {controller: 'restaurant',
			   action: action,
			  }
		   }).done(function(data){
		       if (!data)
			   return false;
		       var jsondata = JSON.parse(data);
		       if (jsondata.options)
		       {
			   var select = $('<select></select>');
			   $.each(jsondata.options, function(i, option){
			       select.append('<option'+(option.text == tdElm.text() ? ' selected="selected"' : '')+' value="'+option.value+'">'+option.text+'</option>'); 
			   });
			   tdElm.html(select[0].outerHTML);
		       }
		   });
	}
    });
    $(this).text('Save');
    $(this).removeAttr('data-edit');
    $(this).attr('data-save', 'data-save');
});

$('#list').on('click', 'table button[data-save]', function(){
    var data = {};
    $.each($(this).closest('tr').find('td[data-form-type]'), function(){
	var val, valText;
	if ($(this).attr('data-form-type') == 'text')
	    val = $(this).find('input').val();
	else if ($(this).attr('data-form-type') == 'textarea')
	    val = $(this).find('textarea').val();
	else if ($(this).attr('data-form-type') == 'select')
	{
	    val = $(this).find('select').val();
	    valText = $(this).find('select option:selected').text();
	}
	data[$(this).attr('data-field')] = val;
	$(this).html(valText ? valText : val);
    });
    if (data)
    {
	var rel = $(this).attr('rel');
	data.controller = 'restaurant';
	data.action = 'ajaxEditRestaurant';
	data.restaurant = rel;

	$.ajax({url: 'ajax.php',
		method: 'POST',
		data: data
	       });
    }
    $(this).text('Edit');
    $(this).removeAttr('data-save');
    $(this).attr('data-edit', 'data-edit');
});
