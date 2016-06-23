$(document).ready(function() {

	SM.Shop.init();
	curr = $('#shop-currency');
	SM.Currency.init({name: curr.attr('name'), course: curr.attr('course'), decimals : curr.attr('decimals'), dsep: curr.attr('dsep'), tsep: curr.attr('tsep')});


	SM.Shop.onsave = function(){

		count = this.getCount();
		price = this.getPrice();

		if (count)
		{
			$('.shop-empty').hide();
			$('.shop-notempty').show();

			$('.shop-count').html(count + '&nbsp;' + SM.ruscomp(count, ''));
			$('.shop-price').html(SM.formatPrice(price) + '&nbsp;' + SM.Currency.name);

			$('#cart-total').html( SM.formatPrice(price) + '&nbsp;<span>' + SM.Currency.name + '</span>');
		}
		else
		{
			$('.shop-empty').show();
			$('.shop-notempty').hide();
		}

	};



	$(document).on('click','.addtocart', function(){
		t = $(this);
		var product_id = t.attr('data-productid');
		var price = t.attr('data-productprice');
		var count = parseInt($('#count-' + product_id).val());
		alert(count);
		if(!count){
			count = 1;
		}

		SM.Shop.add(SM.checkId(product_id), count, parseFloat(price));
		count = SM.Shop.getCount();
		price = SM.Shop.getPrice();

		if (count)
		{
			if (t.attr('show')) $(t.attr('show')).show();
			if (t.attr('hide')) $(t.attr('hide')).hide();
		}
		return false;
	});

	$('.cart-delete').bind('click', function(){
		t = $(this);

		var product_id = t.attr('productid');
		if (confirm('Удалить этот товар из заказа?'))
		{
			SM.Shop.del(SM.checkId(product_id));
			$('.row-' + product_id).empty();
		}

		return false;
	});

	$('.cart-count-input').bind('keyup', function(){
		var t = $(this);

		var id = SM.checkId(t.attr('productid'));
		var price = parseFloat(t.attr('price'));
		var count = parseInt(t.attr('value'));

		if(count){
			count = count ? count : 1;
			t.attr('value', count);
			SM.Shop.update(id, count, price);
			$(t.attr('update')).html( SM.formatPrice(price*count) + '&nbsp;<span>' + SM.Currency.name + '</span>' );
		}

	});
	$('.cart-count-input').bind('blur', function(){
		var t = $(this);

		var id = SM.checkId(t.attr('data-productid'));
		var price = parseFloat(t.attr('data-price'));
		var count = parseInt(t.attr('value'));

		if(!count)
		{
			count = 1;
			t.attr('value', count);
			SM.Shop.update(id, count, price);
			$(t.attr('update')).html( SM.formatPrice(price*count) + '&nbsp;<span>' + SM.Currency.name + '</span>' );
		}

	});

	$('.product_quantity_up').click(function(e){
		e.preventDefault();
		fieldName = $(this).attr('rel');
		var currentVal = parseInt($('input[name='+fieldName+']').val());
		if (!isNaN(currentVal)) {
			$('input[name='+fieldName+']').val(currentVal + 1).trigger('keyup');
		}
		return false;
	});

	$(".product_quantity_down").click(function(e) {
		e.preventDefault();
		fieldName = $(this).attr('rel');
		var currentVal = parseInt($('input[name='+fieldName+']').val());
		if (!isNaN(currentVal) && currentVal > 1) {
			$('input[name='+fieldName+']').val(currentVal - 1).trigger('keyup');
		} else {
			$('input[name='+fieldName+']').val(1);
		}
		return false;
	});

});
