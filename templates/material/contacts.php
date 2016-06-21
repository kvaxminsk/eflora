<div class="wrap">
	<div class="wrap_contacts">
		<div class="content">
			<h1><?=$this->h1?></h1>
		</div>
	</div>
	<div class="content content_contacts">
		<? include HOME . '/templates/blocks/breadcrumbs.php'; ?>
		
        <?=$model->content?>
		
        <div id="map"></div>
        <div class="feedback">			
          <h1>Обратная связь</h1>
			<? if (!empty($_GET['result'])):?>
				<? if ($_GET['result'] == 'yes'): ?>
					<font style="margin-left: 10px;" color="green">Спасибо за сообщение, мы свяжимся с Вами в ближайшее время.</font><br /><br />
				<? elseif($_GET['result'] == 'no'): ?>
					<font style="margin-left: 10px;" color="red">Извините, сообщение не отправлено, свяжитесь с нами по телефону.</font><br /><br />
				<? endif; ?>
			<? endif; ?>
          <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" value="" placeholder="Имя" required/>
            <input type="email" name="email" value="" placeholder="Электронная почта"/>
            <textarea name="message" id="" cols="" rows="" placeholder="Сообщение" required></textarea>
            <input type="submit" name="submitMessage" value="отправить">
          </form>
        </div>
	</div>
</div>

<script src="https://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<?=$model->code1?>

