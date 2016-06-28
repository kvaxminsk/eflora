$(window).load(function() {
	$('.delete-img').click(function(){
	    if(!confirm('Удалить изображение?')){
	       return false;
	    }

	    var t = $(this);
        var objectid = t.attr('objectid');
        var model = t.attr('model');
        var attr = t.attr('attr');

        imgid = attr + '-' + objectid;
		res   =   {
		      'objectid': objectid,
		      'model': model,
              'attr': attr
        };
		jQuery.ajax({
			'type':      'POST',
			'dataType':  'json',
			'data':      res,
			'url':       'deleteimg',
			'success':function(data) {
			    t.remove();
                $('#'+imgid).remove();
			}
		});
        return false;
	});

})