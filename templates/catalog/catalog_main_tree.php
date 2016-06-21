<?// foreach($categories as $item): ?>
<!--	--><?// if (!empty($item['children'])): ?>
<!--		<li class="click_list_categ --><?// if ($item['url_current']):?><!--active_list_categ--><?// endif; ?><!--">-->
<!--			<a href="--><?//=$item['url']?><!--" style="text-transform: uppercase;">--><?//=$item['name']?><!--</a>-->
<!--			<div class="list_arrow"></div>-->
<!--			<ul>-->
<!--				--><?// foreach ($item['children'] as $item2): ?>
<!--					<li><a href="--><?//=$item2['url']?><!--">--><?//=$item2['name']?><!--</a></li>-->
<!--				--><?// endforeach; ?>
<!--			</ul>-->
<!--		</li>-->
<!--	--><?// else: ?>
<!--		<li>-->
<!--			<a href="--><?//=$item['url']?><!--">--><?//=$item['name']?><!--</a>-->
<!--		</li>-->
<!--	--><?// endif; ?>
<?// endforeach; ?>
<? $i=0;
foreach($categories as $item): ?>
	<div>
		<?
//		var_dump($item['img']);die('fdsaf');
		$image = ($item['img']['path']) ? $item['img']['path'] : '/images/no-photo.gif';
		$image = image($image, 'resize', '1500', '986');
		?>
		<p   style="background: url(<?=$image;?>) 0 0 no-repeat; "></p>
	</div>

<? endforeach; ?>

<script>

	$('.fade').slick({
		dots: true,
		infinite: true,
		speed: 500,
		fade: true,
		arrows: false,

		cssEase: 'linear',
		customPaging: function(slick,index) {
			var title ="";
			switch(index){
			<? $i=0;
				foreach($categories as $item): ?>
				case  <?=$i++;?>:
					title = "<?=$item['name']?>";
					idCategory = "<?=$item['id']?>";

					break;
			<? endforeach; ?>

//				case  1:
//					title = "Подарочные букеты"
//					break;
//				case  2:
//					title = "Букеты из роз"
//					break;
//				case  3:
//					title = "Корзины цветов"
//					break;
//				case  4:
//					title = "Люкс-буеты"
//					break;
//				case  5:
//					title = "Свадебные букеты"
//					break;
//				case  6:
//					title = "Экзотические букеты"
//					break;
//				case  7:
//					title = "Горшечные растения"
//					break;
//				case 8:
//					title = "Бизнес-букет"
//					break;
//				case 9:
//					title = "8 марта"
//					break;
//				case 10:
//					title = "День св. Валентина"
//					break;
//				case 11:
//					title = "Мягкие игрушки"
//					break;
//				case 12:
//					title = "Подарки"
//					break;
//				case 13:
//					title = "Ритуальные"
//					break;
			}
			if ( index == 0 ) {
				return '<span data-category="' + idCategory + '" class="reason_link" > ' + title + '</span>';

			}else{
				return '<span data-category="' + idCategory + '" class="reason_link" > ' + title + '</span>';


			}

		}
	});

</script>
