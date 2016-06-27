

<div class="cp_right_main_content">
	<div id="map" style="width: 100%; height: 700px"></div>
	<div class="map_contact">
		<div class="map_contact_text">
			<h1> КОНТАКТЫ </h1>
			<h2> Адрес офиса </h2>
			<p> <?=$this->variables['address']?>
			</p>
			<div class="map_mobile_phone">
				<h2>Моб. телефоны</h2>
				<p> <?=strip_tags($this->variables['phone_mts_second'])?></p>
				<p> <?=strip_tags($this->variables['phone_mts'])?></p>
				<p> <?=strip_tags($this->variables['phone_velcom'])?></p>
				<br>
				<br>
				<h2 class="map_contact_email">Email</h2>
				<p id="map_mail"><a href="mailto:info.eflora@gmail.com"><?=$this->variables['email']?></a> </p>
			</div>
			<div class="map_fax_phone">
				<h2>Гор.тел/факс</h2>
				<p> <?=strip_tags($this->variables['phone'])?>,</p>
				<p> <?=strip_tags($this->variables['phone_fax'])?></p>
				<br>
				<br>
				<h2 class="map_contact_skype">Skype</h2>
				<p id="map_skype"><a href="skype:eflora.by?call"><?=$this->variables['skype_company']?></a> </p>

			</div>
			<div class="clearfix"></div>
			<p class="map_describe"><?=$this->variables['info_bank']?></p>
			<div class="message_icon_wrap">
				<!-- <img class="message_icon" src="/images/eflora/message.png" alt=""> -->
				<!-- <img class="map_info_icon" src="/images/eflora/map_info_icon.png" alt=""> -->
			</div>
			<div class="map_info_wrap">
			</div>



			<div class="feedback">
				<div class="close_feedback_cross">
					<img src="/images/eflora/close_cross.png" alt="">
				</div>

<!--					<input type="text" name="name" value="" placeholder="Имя" required/>-->
<!--					<input type="email" name="email" value="" placeholder="Электронная почта"/>-->
<!--					<textarea name="message" id="" cols="" rows="" placeholder="Сообщение" required></textarea>-->
<!--					<input type="submit" name="submitMessage" value="отправить">-->

				<h2>ОБРАТНАЯ СВЯЗЬ</h2>
				<form method="post" enctype="multipart/form-data">
					<input class="name" name="name" type="text" placeholder="Имя и Фамилия" required>
					<input class="email" name="email" type="email" placeholder="Ваш email" required>
					<input class="order_number" name="order_number" type="text" placeholder="Номер заказа">
					<p class="order_number_desc">	(или другая информация для его идентификации - <br>
						дата, адрес, телефон, состав и т.д.): </p>
					<!-- <p> Текст сообщения</p> -->
					<textarea class="feedback_message" name="message"  placeholder="Текст сообщения"></textarea>
					<input type="submit" name = "feedback_submit"class="feedback_submit" value="Отправить">
				</form>
			</div>


		</div>
		<div class="map_contact_icons">
			<ul>
				<li><a href=""><img class="h_facebook" src="/images/eflora/map_facebook.png" alt="">   </a></li>
				<li><a href=""><img class="h_twitter" src="/images/eflora/contact_twitter.png" alt=""></a></li>
				<li><a href=""><img class="h_vk" src="/images/eflora/contact_vk.png" alt="">     </a></li>
				<li><a href=""><img class="h_inst" src="/images/eflora/contact_inst.png" alt="">   </a></li>
				<li><a href=""><img class="h_gmail" src="/images/eflora/contact_gmail.png" alt="">  </a></li>
				<li><a href=""><img class="h_ri" src="/images/eflora/contact_ri.png" alt="">     </a></li>
			</ul>
		</div>

	</div>
	<div class="clearfix" style="clear:both"></div>
</div>

