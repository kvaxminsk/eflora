<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0 , user-scalable=no">
	<title><?=$this->title;?></title>
	<meta name="description" content="<?=$this->description;?>"/>
	<meta name="keywords" content="<?=$this->keywords;?>"/>
	<link rel="stylesheet" type="text/css" href="/styles/css/main_style.css"/>
	<link rel="stylesheet" type="text/css" href="/styles/css/main_page/main_page_style.css"/>
	<link rel="stylesheet" type="text/css" href="/styles/css/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="/styles/css/main_page/slider_style.css"/>
	<link rel="stylesheet" type="text/css" href="/styles/css/select/style.css"/>




	<script type="text/javascript" src="javascript/eflora/jquery-1.12.3.js"></script>
	<script type="text/javascript" src="javascript/eflora/slick/slick.min.js"></script>


	<script type="text/javascript" src="javascript/eflora/common.js"></script>

	<script type="text/javascript">

		function DropDown(el) {
			this.dd = el;
			this.initEvents();
		}
		DropDown.prototype = {
			initEvents : function() {
				var obj = this;

				obj.dd.on('click', function(event){
					$(this).toggleClass('active');
					event.stopPropagation();
				});
			}
		}

		$(function() {
			var dd1 = new DropDown( $('#criterion_filter'));
			var dd = new DropDown( $('#theme_filter') );

			$(document).click(function() {
				// all dropdowns
				$('.wrapper-dropdown-5').removeClass('active');
			});

		});

	</script>

</head>
<body>
<div id ="container">
	<div id="header">
		<div id = "logo">
			<a href="http://www.eflora.by" target="_blank"><img src="/images/eflora/main_logo.png" alt="Тут должен быть логотип" class  = "logo_pic"></a>

			<p id = "logo_text">
				Belarus flowers delivery service
			</p>
		</div>
		<div class = "column_list">
			<ul class="list">
				<li id="first_column">
					<div class="menu">
						<div id = "menu_selector" >
							<div id='sandwich' class="active_menu" >
								<div class='sw-topper'></div>
								<div class='sw-bottom'></div>
								<div class='sw-footer'></div>
							</div>
							<img src="/images/eflora/main_cross.png">
						</div>
						<div class="hidden_menu show">
							<div class="catalog_logo_pic">
								<p>Belarus flowers delivery service  </p>
							</div>
							<div class= "menu_panel_close">
								<img src="/images/eflora/main_cross.png">
							</div>
							<div class = "hidden_menu_title">
								Меню
							</div>

							<? $this->widget('MenuBlock', array('type' => 'main', 'file' => 'main', 'tree' => true)) ?>
<!--							<ul class="hidden_menu_list">-->
<!--								<li><a href="#">Главная</a></li>-->
<!--								<li><a href="#">Как заказать цветы?</a></li>-->
<!--								<li><a href="#">Наши цветочные магазины</a></li>-->
<!--								<li><a href="#">Контакты</a></li>-->
<!--								<li><a href="#">События и стат</a></li>-->
<!--								<li><a href="#">Обратная связь</a></li>-->
<!--							</ul>-->
						</div>
					</div>
					<div class="help_menu">
						<div id = "question_icon" >
							<img src="/images/eflora/main_cross.png">
							<a href="#"  ><img class ="pic_position" src="/images/eflora/question_icon.png" alt="menu" />  </a>

						</div>
						<div class="question_panel" >
							<div class="catalog_logo_pic">
								<p>Belarus flowers delivery service  </p>
							</div>
							<div class= "help_panel_close">
								<img src="/images/eflora/main_cross.png">
							</div>
							<div class = "hidden_menu_title">
								Помощь
							</div>
							<? $this->widget('MenuBlock', array('type' => 'help_menu', 'file' => 'help-menu', 'tree' => true)) ?>
<!--							<ul class="help_list">-->
<!--								<li><a href="#">Способы оплаты</a></li>-->
<!--								<li><a href="#">Оформление свадьбы</a></li>-->
<!--								<li><a href="#">Доставка цветов</a></li>-->
<!--								<li><a href="#">О нас</a></li>-->
<!--								<li><a href="#">Частые вопросы</a></li>-->
<!--								<li><a href="#">Отзывы клиентов</a></li>-->
<!--								<li><a href="#">Гарантия качества</a></li>-->
<!--								<li><a href="#">Юридическим лицам</a></li>-->
<!--								<li><a href="#">Наши друзья</a></li>-->
<!--							</ul>-->
						</div>
					</div>
					<div class= "phone_number">
						<div class="phone">
							<p class="first_phone">
								<a href="tel:<?= strip_tags($this->variables['phone']);?>"><?=$this->variables['phone']?> </a>
							<div id="triangle"></div>
							</p>
						</div>
						<div class="description">
							<p id ="first_description"><?=$this->variables['header_slogan_rus']; ?></p>
						</div>
						<p id = "logo_text_mobile">
							<?=$this->variables['header_slogan_en'];?>
						</p>
					</div>
				</li>
				<li id="second_column">
					<div class="second_column_number">
						<div class="phone1">
							<p class="second_phone">
								<a href="tel:<?= strip_tags($this->variables['phone_mts']);?>"><?=$this->variables['phone_mts']?> </a>
							</p>
						</div>
						<div class="description">
							<p id ="second_description"><?= $this->variables['header_time_work']?></p>
						</div>
					</div>
				</li>
				<li id="third_column">
					<div class="third_column_number">
						<div class="phone1">
							<p class="third_phone">
								<a href="tel:<?= strip_tags($this->variables['phone_velcom']);?>"><?=$this->variables['phone_velcom']?> </a>
							</p>
						</div>
						<div class="description">
							<p id ="third_description"><?= $this->variables['header_time_delivery']?></p>
						</div>
					</div>
				</li>
			</ul>
			<div id= "backet_wrap">
				<div id = "header_price">
					<p id = "header_price_text">		1 256  <span id = "zero"> 000 </span></p>
				</div>
				<div id = "header_backet">
					<a href="#"   ><img class ="backet_pic"  src="/images/eflora/header_backet.png" alt="menu" /> <div class="backet_circle"><p> 2</p></div> </a>
				</div>
				<div id = "header_price_symbol">
					<p id = "symbol">Цены в   <span id ="dollar">$</span>   <span id = "delimeter">/</span>  <span id = "unit">Br</span>    						<p id = "points">   ......  </p>
				</div>
				<div class="header_price_icon">
					<img src="/images/eflora/header_price.png" alt="">
					<div class="backet_circle"><p>$</p></div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix" style="clear:both"></div>

	<div class="main_slick_slider">
		<div class="slide_box">
			<div class="left_box show">
				<p>Букеты из роз
				<div class="title_line"></div>
				</p>

				<div class="white_circle">

				</div>
			</div>
			<div class="right_box">  <p class="right_box_title">Королевские цветы</p>
				<hr> </hr>
				<p class="rb_discribe">
					У нас можно заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.
				</p>
			</div>
			<div style="clear:both;"></div>
		</div>

		<div class="fade">
			<? $this->widget('CatalogCategoryBlock', array('file' => 'catalog_main_tree')) ?>
<!--			<div>-->
<!--				<p   style="background: url(images/eflora/slide1.jpg) 0 0 no-repeat; "></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide2.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide3.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide4.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide5.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide6.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide7.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide8.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide9.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide10.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide11.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide12.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide13.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
<!--			<div>-->
<!--				<p style="background: url(images/eflora/slide14.jpg) 100% 100% no-repeat;background-size: cover;"></p>-->
<!--			</div>-->
		</div>
	</div>

	<div class="clearfix">
	</div>
	<div class="catalog_logo">
		<div class="catalog_logo_pic"></div>

		<div class= "catalog_close">

			<img src="/images/eflora/main_cross.png">
		</div>
	</div>
	<div
		class="mob_list_wrapp">
		<div class  = "mobile_list">
			<p> <span class="open_catalog">&#8249;</span>
				Каталог товаров </p>
		</div>
	</div>


	<div class="main_content page1">
		<div class="mp_left_main_content">
			<div class="search_area">
				<input type="text" placeholder="Поиск...">
				<div class="go_find"></div>
			</div>
			<div class="left_sidebar">
				<div class = "square">
					<div class="flower_car"></div>
				</div>
				<p class= "where_deliver"> Куда доставить?	</p>
				<hr>
				<p class = "where_deliver_text">
					Бесплатная доставка цветов, букетов по Минску. Обеспечиваем доставку с  гарантией практически в любом городе РБ     		Особые условя доставки цветов поМоскве и Санкт-Петербургу
				</p>
				<div class = "square">
					<div class="flower_smile">	</div>
				</div>
				<p class= "where_deliver"> Сколько счастливых?</p>
				<hr>
				<p class = "happen_text">
					Мы всегда доставляем свежие цветы, поскольку доставка выполняется из ближайшего салона цветов.
				</p>
				<ul class= "happen_count">
					<li class="happen_number" >7160  </li>
					<li class="happen_number" >71    </li>
					<li class="happen_number" >5     </li>
					<li class="happen_value">всего	 </li>
					<li class="happen_value">вчера   </li>
					<li class="happen_value">сегодня </li>
					<div class= "clearfix" style="clear:both"> </div>
				</ul>
			</div>
		</div>


		<div class="mp_right_main_content">
			<div class="under_slider">
				<div class = "mobile_categoria">
					Акции
				</div>
				<div class="mobile_filter">
					<div class="filter_wrapper">
						<div id="criterion_filter" class="wrapper-dropdown-5 select_filter" tabindex="1">
									<span id='criterion_filter_text'>
									Фильтр</span>
							<ul class="dropdown " id="dropdown2">
								<li><a href=""><i class="icon-user"></i>По популярности</a></li>
								<li><a href=""><i class="icon-cog"></i>По цене:</a></li>
								<li><a href=""><i class="icon-remove"></i>До 100</a></li>
								<li><a href=""><i class="icon-remove"></i> До 200</a></li>
							</ul>
						</div>
					</div>
				</div>
				<p class="theme"> Тематика: </p>
				<div class="select_theme_wrapp">
<!--					<div id="theme_filter" class="wrapper-dropdown-5 select_theme" tabindex="1"> <span id="theme_text">--><?//= $item['name']?><!--</span>-->
						<? $this->widget('CatalogCategoryBlock', array('file' => 'catalog_select_tree')) ?>
<!--						<ul class="dropdown" id="dropdown1">-->
<!--							<li><a href="#"><i></i>8 марта</a></li>-->
<!--							<li><a href="#"><i></i>23 февраля</a></li>-->
<!--							<li><a href="#"><i></i>9 мая</a></li>-->
<!--						</ul>-->
					</div>
				</div>
				<div class= "clearfix" style="clear:both"> </div>

				<div class ="sort_criterion" >
					<p class = "choice">
						Сортировать по:
						<a class="choice_link" href="#">Популярности</a>
						<a class="choice_link" href="#">Цене</a>
						<a class="choice_link" href="#">До 50</a>
						<a class="choice_link" href="#">До 100</a>
						<a class="choice_link" href="#">До 200</a>
					</p>
				</div>

			</div>

			<div class="flower_container">
				<ul class="flower_products">
<!--					<li class = "product">-->
<!--						<div class="product_wrap">-->
<!--							<div class="flower">-->
<!--								<div class="discount">-->
<!--									<p>-15%</p>-->
<!--								</div>-->
<!--								<img class ="flower_pic"  src="/images/eflora/flower1.png" alt="menu" />-->
<!--							</div>-->
<!--							<div class="old_price">-->
<!--								<span class="um">BR </span>-->
<!--								116-->
<!--								<div class = "line"></div>-->
<!--								<span class="zero_old_price">000</span>-->
<!--							</div>-->
<!--							<div class="new_price">-->
<!--								<span class="um">BR </span>-->
<!--								11-->
<!--								<span class="zero_old_price">16 коп</span>-->
<!--							</div>-->
<!--							<div class="flower_discribe">-->
<!--								<p>«25 роз РБ.»</p>-->
<!--							</div>-->
<!--							<div class="count_product_selector">-->
<!--								<div class="decrement">-</div>-->
<!--								<div class="count_product"><input type="text" value="0" maxlength="4"> </div>-->
<!--								<div class="increment">+</div>-->
<!--							</div>-->
<!--							<div class="in_cart_wrap">-->
<!--								<a href="" class="in_cart"><p> В КОРЗИНУ </p></a>-->
<!--							</div>-->
<!--							<div class="hover_description">-->
<!--								<p>	Добродушная корзинка из 5 веток белой ромашковой хризатемы, 3 веток синей статицы и зелени. Диаметр готовой корзинки около 40 см</p>-->
<!--							</div>-->
<!--						</div>-->
<!--					</li>-->
<!--					<li class = "product">-->
<!--						<div class="product_wrap">-->
<!--							<div class="flower">-->
<!--								<div class="discount">-->
<!--									<p>-15%</p>-->
<!--								</div>-->
<!--								<img class ="flower_pic"  src="/images/eflora/flower2.png" alt="menu" />-->
<!--							</div>-->
<!--							<div class="old_price">-->
<!--								<span class="um">BR </span>-->
<!--								116-->
<!--								<div class = "line"></div>-->
<!--								<span class="zero_old_price">000</span>-->
<!--							</div>-->
<!--							<div class="new_price">-->
<!--								<span class="um">BR </span>-->
<!--								11-->
<!--								<span class="zero_old_price">16 коп</span>-->
<!--							</div>-->
<!--							<div class="flower_discribe">-->
<!--								<p>«25 роз РБ.»</p>-->
<!--							</div>-->
<!--							<div class="count_product_selector">-->
<!--								<div class="decrement">-</div>-->
<!--								<div class="count_product"><input type="text" value="0" maxlength="4"> </div>-->
<!--								<div class="increment">+</div>-->
<!--							</div>-->
<!--							<div class="in_cart_wrap">-->
<!--								<a href="" class="in_cart"><p> В КОРЗИНУ </p></a>-->
<!--							</div>-->
<!--							<div class="hover_description">-->
<!--								<p>	Добродушная корзинка из 5 веток белой ромашковой хризатемы, 3 веток синей статицы и зелени. Диаметр готовой корзинки около 40 см</p>-->
<!--							</div>-->
<!--						</div>-->
<!--					</li>-->
<!--					<li class = "product">-->
<!--						<div class="product_wrap">-->
<!--							<div class="flower">-->
<!--								<div class="discount">-->
<!--									<p>-10%</p>-->
<!--								</div>-->
<!--								<img class ="flower_pic"  src="/images/eflora/flower3.png" alt="menu" />-->
<!--							</div>-->
<!--							<div class="old_price">-->
<!--								<span class="um">BR </span>-->
<!--								116-->
<!--								<div class = "line"></div>-->
<!--								<span class="zero_old_price">000</span>-->
<!--							</div>-->
<!--							<div class="new_price">-->
<!--								<span class="um">BR </span>-->
<!--								11-->
<!--								<span class="zero_old_price">16 коп</span>-->
<!--							</div>-->
<!--							<div class="flower_discribe">-->
<!--								<p>«Дочка родилась»</p>-->
<!--							</div>-->
<!--							<div class="count_product_selector">-->
<!--								<div class="decrement">-</div>-->
<!--								<div class="count_product"><input type="text" value="0" maxlength="4"> </div>-->
<!--								<div class="increment">+</div>-->
<!--							</div>-->
<!--							<div class="in_cart_wrap">-->
<!--								<a href="" class="in_cart"><p> В КОРЗИНУ </p></a>-->
<!--							</div>-->
<!--							<div class="hover_description">-->
<!--								<p>	Добродушная корзинка из 5 веток белой ромашковой хризатемы, 3 веток синей статицы и зелени. Диаметр готовой корзинки около 40 см</p>-->
<!--							</div>-->
<!--						</div>-->
<!--					</li>-->
<!--					<li class = "product">-->
<!--						<div class="product_wrap">-->
<!--							<div class="flower">-->
<!--								<div class="discount">-->
<!--									<p>-25%</p>-->
<!--								</div>-->
<!--								<img class ="flower_pic"  src="/images/eflora/flower4.png" alt="menu" />-->
<!--							</div>-->
<!--							<div class="old_price">-->
<!--								<span class="um">BR </span>-->
<!--								116-->
<!--								<div class = "line"></div>-->
<!--								<span class="zero_old_price">000</span>-->
<!--							</div>-->
<!--							<div class="new_price">-->
<!--								<span class="um">BR </span>-->
<!--								11-->
<!--								<span class="zero_old_price">16 коп</span>-->
<!--							</div>-->
<!--							<div class="flower_discribe">-->
<!--								<p>«Утренний поцелуй»</p>-->
<!--							</div>-->
<!--							<div class="count_product_selector">-->
<!--								<div class="decrement">-</div>-->
<!--								<div class="count_product"><input type="text" value="0" maxlength="4"> </div>-->
<!--								<div class="increment">+</div>-->
<!--							</div>-->
<!--							<div class="in_cart_wrap">-->
<!--								<a href="" class="in_cart"><p> В КОРЗИНУ </p></a>-->
<!--							</div>-->
<!--							<div class="hover_description">-->
<!--								<p>	Добродушная корзинка из 5 веток белой ромашковой хризатемы, 3 веток синей статицы и зелени. Диаметр готовой корзинки около 40 см</p>-->
<!--							</div>-->
<!--						</div>-->
<!--					</li>-->
<!--					<li class = "product">-->
<!--						<div class="product_wrap">-->
<!--							<div class="flower">-->
<!--								<div class="discount">-->
<!--									<p>-15%</p>-->
<!--								</div>-->
<!--								<img class ="flower_pic"  src="/images/eflora/flower5.png" alt="menu" />-->
<!--							</div>-->
<!--							<div class="old_price">-->
<!--								<span class="um">BR </span>-->
<!--								116-->
<!--								<div class = "line"></div>-->
<!--								<span class="zero_old_price">000</span>-->
<!--							</div>-->
<!--							<div class="new_price">-->
<!--								<span class="um">BR </span>-->
<!--								11-->
<!--								<span class="zero_old_price">16 коп</span>-->
<!--							</div>-->
<!--							<div class="flower_discribe">-->
<!--								<p>«Сельский мотив»</p>-->
<!--							</div>-->
<!--							<div class="count_product_selector">-->
<!--								<div class="decrement">-</div>-->
<!--								<div class="count_product"><input type="text" value="0" maxlength="4"> </div>-->
<!--								<div class="increment">+</div>-->
<!--							</div>-->
<!--							<div class="in_cart_wrap">-->
<!--								<a href="" class="in_cart"><p> В КОРЗИНУ </p></a>-->
<!--							</div>-->
<!--							<div class="hover_description">-->
<!--								<p>	Добродушная корзинка из 5 веток белой ромашковой хризатемы, 3 веток синей статицы и зелени. Диаметр готовой корзинки около 40 см</p>-->
<!--							</div>-->
<!--						</div>-->
<!--					</li>-->
<!--					<li class = "product">-->
<!--						<div class="product_wrap">-->
<!--							<div class="flower">-->
<!--								<div class="discount">-->
<!--									<p>-10%</p>-->
<!--								</div>-->
<!--								<img class ="flower_pic"  src="/images/eflora/flower6.png" alt="menu" />-->
<!--							</div>-->
<!--							<div class="old_price">-->
<!--								<span class="um">BR </span>-->
<!--								116-->
<!--								<div class = "line"></div>-->
<!--								<span class="zero_old_price">000</span>-->
<!--							</div>-->
<!--							<div class="new_price">-->
<!--								<span class="um">BR </span>-->
<!--								11-->
<!--								<span class="zero_old_price">16 коп</span>-->
<!--							</div>-->
<!--							<div class="flower_discribe">-->
<!--								<p>«25 роз»</p>-->
<!--							</div>-->
<!--							<div class="count_product_selector">-->
<!--								<div class="decrement">-</div>-->
<!--								<div class="count_product"><input type="text" value="0" maxlength="4"> </div>-->
<!--								<div class="increment">+</div>-->
<!--							</div>-->
<!--							<div class="in_cart_wrap">-->
<!--								<a href="" class="in_cart"><p> В КОРЗИНУ </p></a>-->
<!--							</div>-->
<!--							<div class="hover_description">-->
<!--								<p>	Добродушная корзинка из 5 веток белой ромашковой хризатемы, 3 веток синей статицы и зелени. Диаметр готовой корзинки около 40 см</p>-->
<!--							</div>-->
<!--						</div>-->
<!--					</li>-->
<!--					<li class = "product">-->
<!--						<div class="product_wrap">-->
<!--							<div class="flower">-->
<!--								<div class="discount">-->
<!--									<p>-10%</p>-->
<!--								</div>-->
<!--								<img class ="flower_pic"  src="/images/eflora/flower7.png" alt="menu" />-->
<!--							</div>-->
<!--							<div class="old_price">-->
<!--								<span class="um">BR </span>-->
<!--								116-->
<!--								<div class = "line"></div>-->
<!--								<span class="zero_old_price">000</span>-->
<!--							</div>-->
<!--							<div class="new_price">-->
<!--								<span class="um">BR </span>-->
<!--								11-->
<!--								<span class="zero_old_price">16 коп</span>-->
<!--							</div>-->
<!--							<div class="flower_discribe">-->
<!--								<p>«Сиреневая вуаль»</p>-->
<!--							</div>-->
<!--							<div class="count_product_selector">-->
<!--								<div class="decrement">-</div>-->
<!--								<div class="count_product"><input type="text" value="0" maxlength="4"> </div>-->
<!--								<div class="increment">+</div>-->
<!--							</div>-->
<!--							<div class="in_cart_wrap">-->
<!--								<a href="" class="in_cart"><p> В КОРЗИНУ </p></a>-->
<!--							</div>-->
<!--							<div class="hover_description">-->
<!--								<p>	Добродушная корзинка из 5 веток белой ромашковой хризатемы, 3 веток синей статицы и зелени. Диаметр готовой корзинки около 40 см</p>-->
<!--							</div>-->
<!--						</div>-->
<!--					</li>-->
					<li class = "product" id="show_more_item">
						<div class="download_more">
							<div class="download_icon">
								+
							</div>
							<span>
								ПОКАЗАТЬ ЕЩЕ
							</span>
						</div>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>

			<div class="clearfix"></div>
			<div class="content">
				<div class="column1">
					<p>	Доставка цветов Минск

					</p>
					<div class="vawe1">
						<p>
						</p>
					</div>
					<div class  = "column1_text">
						<?=$this->variables['flower_delivery_minsk']?>
					</div>
				</div>
				<div class="column2">
					<p>
						Доставка цветов Беларусь
					</p>
					<div class="vawe2">
						<p>
						</p>
					</div>

					<div class  = "column2_text">
						<?=$this->variables['flower_delivery_belarus']?>
					</div>
				</div>
				<div class="column3">
					<div class = "column3_up">
						<p class="title"> Международная доставка	цветов 	</p>
						<div class  = "column3_text">
							<?=$this->variables['international_flower_delivery']?>
						</div>
					</div>
					<div class = "column3_down">
						<p class="what_payment">
							Принимаем к оплате
						</p>
						<div class = "card_type">
							<img src="/images/eflora/card-type.jpg">
						</div>
					</div>


				</div>
				<div class="clearfix"></div>
			</div>







		</div>


		<div class="clearfix"></div>
	</div>



	<div class="clearfix"></div>
	<div class = "footer">
		<div class="footer_logo">
			<div class="footer_logo_describe">
				<p><?=$this->variables['header_slogan_rus']?></p>
			</div>
		</div>
		<div class="footer_contact_info">
			<div class="first_contact_column">
				<div class="col1_wrapp">
					<div class="phone_icon">
					</div>
					<div class="phones">
						<p class="fotter_phone">
							<a href="tel:<?= strip_tags($this->variables['phone'])?>">	 <?= $this->variables['phone']?> </a>
						</p>
						<p class="fotter_phone">
							<a href="tel:<?= strip_tags($this->variables['phone_mts'])?>">	 <?= $this->variables['phone_mts']?> </a>
						</p>
						<p class="fotter_phone">
							<a href="tel:<?= strip_tags($this->variables['phone_velcom'])?>">	 <?= $this->variables['phone_velcom']?> </a>
						</p>
					</div>
				</div>
			</div>
			<div class="second_contact_column">
				<div class="col2_wrapp">
					<div class="adress_icon">
					</div>
					<div class = "adress_info">
						<p id="our_adress">Наш адрес:</p>
						<p>
							<?= $this->variables['address']?> <?= $this->variables['time_work']?>
						</p>
					</div>
				</div>
			</div>
			<div class="third_contact_column">
				<div class = "col3_wrapp">
					<div class="shop_icon">
					</div>
					<p> <a href="">Наши магазины </a> </p>
				</div>

			</div>
		</div>
		<div class = "footer_down_part">
			<div class="text_author">
				<p>&#169;2006-<?= Date('Y');?></p>
				<p> eFlora.by</p>
				<p id ="t_author_3">	flowers delivery service</p>
			</div>
			<div class="social_icons">
				<div class="social_icons_wrap">
					<ul>
						<li><a href="<?=$this->variables['social_fb']?>"><img src="/images/eflora/facebook_icon.png" alt=""></a></li>
						<li><a href="<?=$this->variables['social_tw']?>"><img src="/images/eflora/twitter_icon.png" alt=""></a></li>
						<li><a href="<?=$this->variables['social_vk']?>"><img src="/images/eflora/vk_icon.png" alt=""></a></li>
						<li><a href="<?=$this->variables['social_in']?>"><img src="/images/eflora/instagram_icon.png" alt=""></a></li>
						<li><a href="<?=$this->variables['social_google']?>"><img src="/images/eflora/gmail_icon.png" alt=""></a></li>
						<li><a href="<?=$this->variables['social_pinterest']?>"><img src="/images/eflora/R-icon.png" alt=	""></a></li>
					</ul>






				</div>

			</div>
			<div class="reactive_logo">
				<div class="reactive_logo_wrap">
					<p>Дизайн и разработка-</p>
					<div class = "logo_picture">
					</div>

				</div>

			</div>
			<div class ="up_button">
				<img class ="" src="/images/eflora/up_button.png" alt="menu" />
			</div>
		</div>
	</div>
	<div class="clearfix" style="clear:both"></div>
</div>
</body>
</html>