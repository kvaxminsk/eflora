
<div class="list_product">
	<h1><?=$this->h1;?></h1>
		<ul class="flower_products_catalog">

		</ul>

	<br />
	<br />
</div>
<script>
	if (localStorage['reviews']) {
		var reviewsArr = JSON.parse(localStorage['reviews']);
		for (var i = reviewsArr.length - 1; i >= 0; i--) {
//			if (i == (reviewsArr.length - 4)) {
//				break;
//			}
			$.ajax({
				type: 'get',
				data: 'id=' + reviewsArr[i],
				url: '/ajax-product-reviews-catalog',
				success: function (data) {
					//document.write();

					$('.flower_products_catalog').append(data);
					// changeCurrency();
				}
			});
		}
	}

</script>







