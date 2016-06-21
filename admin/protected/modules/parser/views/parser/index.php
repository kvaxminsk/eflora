<? $this->breadcrumbs = array('Выгрузка'); ?>

<div class="form_pretext">
	<sup class="form_title_marker">*</sup> Выгрузка возможна только из файла .xls
</div>	

<form method="POST" action="" enctype="multipart/form-data" style="padding: 30px 0 20px 0;">
	Выгрузка из файла: 
	<input type="file" name="file" required /><br /><br />
	<span style="float: none;">Курс доллара на сегодняшний день: </span><br />
	<input type="text" name="kurs" style="width: 200px; float: none;" required /><br /><br /><br />
	<input type="submit" value="Выгрузить" />
</form>

<div style="color: red;"><? if ($error) echo $error ?></div>


