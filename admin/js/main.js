$(window).load(function() {
    $('.delete-one').click(function(){
        if(!confirm('Удалить?')){
	       return false;
	    }
	    var t = $(this);
        var href = t.attr('href');
        	
        $.get(href, function(data) {
            id = $('.grid-view').attr('id');
            $.fn.yiiGridView.update(id);
        });
        return false;
	})
    $('.public-one').live('click',function(){

	    var t = $(this);
        var href = t.attr('href');
        	
        $.get(href, function(data) {
            id = $('.grid-view').attr('id');
            $.fn.yiiGridView.update(id);
        });
        return false;
	})
    
    $('input[type=password]').val('');
    
    $('#add-product-order').click(function(){
        var orderid = $('#order-id').val();
        var id = $('#product-id').val();
        var articul = $('#product-articul').val();
        if((id == '') && (articul == '')){
            alert('Введите ИД или Артикул товара!');
            return false;
        }
        if((id != '') && (articul != '')){
            alert('Введите только один параметр!');
            return false;
        }
        
        res   =   {
		      'orderid': orderid,
		      'id': id,
              'articul': articul
        };	
		jQuery.ajax({
			'type':      'POST',
			'dataType':  'json',
			'data':      res,
			'url':       '/admin/shop/oproducts/addproduct',
			'success':function(data) {
			    if(data == '-1'){
		              alert('Товар уже есть в данном заказе!');
                      return false;  
			    }else if(data == '0'){
			          alert('Запрашиваемый Вами товар не найден, попробуйте ещё раз.');
                      return false;
			    }else{ 
				    id = 'order-products-grid';
				    $.fn.yiiGridView.update(id);
                    $('#product-id').val('');
                    $('#product-articul').val('');
                }
			}
		});
        return false;
        
    });
        
});

$(document).ready(function() {
    
    $('.datepicker').datepicker({
			numberOfMonths: 1,
			showOn: 'button',
			buttonImage: '/admin/images/calendar.png',
			buttonImageOnly: true,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true

	});

});