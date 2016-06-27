var lang = {
	basketButtonText : "0",
	inBasketButtonText : "0",
	basketTextNull : "0",
	basketText : "",
}
var shopProductCount = 0;
var kurs = 20100;
function updatePage() {
	var shopArr = getBasketInfo();
	var shopProductCount = 0;
	var price_us = 0;
	var price_br = 0;
	for(var key in shopArr) {
		shopProductCount = shopProductCount + parseInt(shopArr[key]['count']);
		price_us = price_us + parseInt(shopArr[key]['price']) * shopProductCount;
	}
	var currency = JSON.parse(localStorage['currency'])
	if(currency != 'us'){
		currency = 'br';
		price_br = 20100* price_us;
		price_br = number_format(price_br, 0, ',', ' ');
	}
	else {
		price_br = 20100* price_us;
		price_br = number_format(price_br, 0, ',', ' ');
	}


	$('.addtobasket').each(function () {
		var id = $(this).attr('data-productid');
		if (shopArr[id]) {
			$(this).find('.basketButtonText').text(lang.inBasketButtonText);
			$(this).addClass('inBasket');
		} else {
			$(this).find('.basketButtonText').text(lang.basketButtonText);
			$(this).removeClass('inBasket');
		}
	});

	if (shopProductCount == 0) {
		$('.baskettext').text(lang.basketTextNull);
		$('#header_price_text_br').text(price_br);
		$('#header_price_text_us').text(price_us);


		$('#order_list_price_old').html(0);
		$('#order_list_price_new').html(0);

		$('#header_price_text_us').text(price_us);
	}
	else
	{
		$('.baskettext').text(shopProductCount + ' ' + lang.basketText);

		$('#order_list_price_old').html( "<sub> " + parseInt(price_us * kurs / 1000)  + "</sub>" + "<sup>" +
			Math.round(((price_us * kurs / 1000) -  (parseInt(price_us * kurs / 1000)))*1000) +"</sup>" );


		$('#order_list_price_new').html( "<sub> " + parseInt(price_us * kurs / 10000)  + "</sub>" + "<sup>" +
			Math.round(((price_us * kurs / 1000) -  (parseInt(price_us * kurs / 1000)))*100) +"коп</sup>" );

		$('#order_list_price_dollar').html(price_us );

		$('#header_price_text_br').text(price_br);
		$('#header_price_text_us').text(price_us);
	}

}
function getCountByProductId() {
	var shopId = getShopId();
	var shopArr = [];
	for (var i = 0; i <= shopId.length - 1; i++) {
		shopArr[i] = JSON.parse(localStorage['shop_product_' + shopId[i]]);
	}
	return shopArr;
}

function getBasketInfo() {
	var shopId = getShopId();
	var shopArr = [];
	for (var i = 0; i <= shopId.length - 1; i++) {
		shopArr[shopId[i]] = JSON.parse(localStorage['shop_product_' + shopId[i]]);
	}
	//console.log(shopArr[3]['count']);
	return shopArr;
}

function getShopId() {
	if (localStorage['shop_count']) {
		//alert(localStorage['shop_count']);
		//console.log(localStorage['shop_count']);
		return JSON.parse(localStorage['shop_count']);
	} else {
		return [];
	}
}

function addShopId(id) {
	var shopArr = getShopId();

	shopArr.push(id);
	localStorage['shop_count'] = JSON.stringify(shopArr);
}

function deleteShopId(id) {
	var shopId = getShopId();
	var shopArr = getBasketInfo();

	for (var i = 0; i <= shopId.length - 1; i++) {
		if (shopId[i] == id) {
			localStorage.removeItem('shop_product_' + shopId[i]);
			shopId.splice(i, 1);
		}
	}

	localStorage['shop_count'] = JSON.stringify(shopId);
	updatePage();
	updatePriceTable();
}

function clearShop() {
	var shopId = getShopId();

	for (var i = 0; i <= shopId.length - 1; i++) {
		localStorage.removeItem('shop_product_' + shopId[i]);
	}
	localStorage.removeItem('shop_count');

	updatePage();
	updatePriceTable();
}

function updatePriceTable() {
	var pcount = 0, priceAll = 0;

	$('.table_shopping table').find('.countProduct').each(function () {
		var tCount = parseInt($(this).val());
		var tPrice = parseInt($(this).parents('.table_product').find('.priceProduct').text());
		var tPriceAll = tCount * tPrice;

		pcount += tCount;
		priceAll += tPriceAll;

		$(this).parents('.table_product').find('.priceAllProduct').text(tPriceAll);
	})

	$('.countMainProduct').text(pcount);
	$('.priceMainProduct').text(priceAll);
}

$(document).ready(function () {
	updatePage();

	$(document).on('click','.addtobasket',function () {
		var newProductId = $(this).attr('data-productid');
		var newProduct = {
			"id" : newProductId,
			//"name" : $(this).attr('data-productname'),
			//"url" : $(this).attr('data-proucturl'),
			//"img" : $(this).attr('data-productimg'),
			"price" : $(this).attr('data-productprice'),
			"count" : $("#count-"+newProductId).val(),
		};

		//if (!localStorage['shop_product_' + newProductId]) {
			localStorage['shop_product_' + newProductId] = JSON.stringify(newProduct);
			addShopId(newProductId);

			updatePage();
		//}
		//else {
		//
		//}
	});

	$('.basket').click(function () {
		var shopId = getShopId();
		var shopArr = getBasketInfo();

		$('.table_shopping table tr:not(.shopTableHead)').remove();


		for (var i = 0; i <= shopId.length - 1; i++) {
			$('.table_shopping table').append('\
				<tr class="table_product" data-productid="' + shopArr[shopId[i]].id + '"> \
					<td><div><img style="height:55px; width: 75px" src="' + shopArr[shopId[i]].img + '" /><a href="' + shopArr[shopId[i]].url + '">' + shopArr[shopId[i]].name + '</a></div></td> \
					<td> \
						<input class="countProduct" name="data[order][product][' + shopArr[shopId[i]].id + ']" type="number" min="1" value="' + shopArr[shopId[i]].count + '" /> \
						<input type="hidden" name="data[order][price][' + shopArr[shopId[i]].id + ']" value="' + shopArr[shopId[i]].price + '" /> \
					</td> \
					<td><span class="priceProduct">' + shopArr[shopId[i]].price + '</span></td> \
					<td><span class="priceAllProduct">' + (shopArr[shopId[i]].price * shopArr[shopId[i]].count) + '</span></td> \
					<td><img style="cursor:pointer;" class="deleteProductFromTable" src="/images/shopping_close.png" alt=""/></td> \
				</tr> \
			');
		}

		updatePriceTable();

		if (shopProductCount) {
			$('.fon').css('display', 'block');
			$('.shopping_basket').css('display', 'block');
		}

		$('.countProduct').change(function () {
			updatePriceTable();
		});

		$('.deleteProductFromTable').click (function () {
			$(this).parents('.table_product').remove();
			deleteShopId($(this).parents('.table_product').attr('data-productid'));

			if(!shopProductCount) {
				$('.fon').css('display', 'none');
				$('.shopping_basket').css('display', 'none');
			}
		});
	});

	$('.closeFirsShopModal').click(function () {
		$('.fon').css('display', 'none');
		$('.shopping_basket').css('display', 'none');
	});
	$('.openSecondShopModal').click(function () {
		$('.shopping_basket').css('display', 'none');
		$('.ordering').css('display', 'block');
	});
	$('.closeSecondShopModal').click(function () {
		$('.shopping_basket').css('display', 'block');
		$('.ordering').css('display', 'none');
	});

	$('.changeNumInProduct').change(function () {
		var tId = $(this).attr('data-productid');
		$('a[data-productid=' + tId + ']').attr('data-productcount', $(this).val());
	});


	$('form[name=shopPost]').submit(function () {
		var msg = $(this).serialize();
		var tAction = $(this).attr('action');
		$.ajax({
			type: 'POST',
			url: tAction,
			data: msg,
			success: function(data) {
				alert('Спасибо! Ваш заказ успешно отправлен и будет обработан нашим менеджером в ближайшее время и мы свяжемся с Вами по указанным контактным данным. Если возникли вопросы, свяжитесь с нами по телефону');

				clearShop();

				$('.fon').css('display', 'none');
				$('.shopping_basket').css('display', 'none');
				$('.ordering').css('display', 'none');
			},
			error:  function(xhr, str){
				alert('Возникла ошибка: ' + xhr.responseCode);
			}
		});

		return false;
	});

});
