<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="language" content="ru" />
    <title><?=$this->title;?></title> 
   
    <link rel="stylesheet" type="text/css" href="/admin/css/jquery-ui.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="/admin/css/main.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="/admin/css/config.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="/admin/css/dopstyle.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="/admin/css/smoothness.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="/admin/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    
    <script src="/admin/js/jquery.js" type="text/javascript"></script>
    <script src="/admin/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/admin/js/jquery.multifile.js" type="text/javascript"></script>
       
    <!-- Для таблицы -->
    <link rel="stylesheet" type="text/css" href="/admin/css/grid/grid-view.css" />
    <script src="/admin/js/grid/jquery.ba-bbq.js" type="text/javascript"></script>
    <script src="/admin/js/grid/jquery.yiigridview.js" type="text/javascript"></script>
    
    <script src="/admin/vendor/ckeditor/ckeditor.js"></script>
	<script src="/admin/js/leftmenu.js" type="text/javascript"></script>
	<script src="/admin/js/mass.js" type="text/javascript"></script> 
    <script src="/admin/js/image.js" type="text/javascript"></script>
    <script src="/admin/js/main.js" type="text/javascript"></script>
	<script src="/admin/js/update.js" type="text/javascript"></script>	
	<!-- FANCYBOX -->
	<script src="/admin/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script src="/admin/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("a.fancybox").fancybox();
		});
	</script>   	
   	
	<link rel="shortcut icon" href="/admin/images/favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>

<div id="wrapper">
	
<div id="wrapper_middle">
	<div id="middle">
		<div class="conteiner">
			<div class="left col">

				<div style="margin: auto;" id="logo">
					<img  src="/admin/images/logo.gif" alt="Reactive.CMS 3.0">
				</div>
				<div class="conteiner">
					<?php $this->widget('application.views.widgets.MenuAdmin');?>
				</div>
			</div>
			<div class="center col">
				<div id="header">
					<div>
						<?php $this->widget('application.views.widgets.CreateButton');?>
					</div>
					<div id="exit">
						<a href="<?php echo CHtml::normalizeUrl(array('/logout'))?>">
							<span class="ico ico_power"></span>
							<span class="name">Выход</span>
						</a>
					</div>
					<div id="exit">
						<a href="<?php echo CHtml::normalizeUrl(array('/config'))?>">
							<span class="ico ico_config"></span>
							<span class="name">Настройки</span>
						</a>
					</div>
					<div id="exit">
						<a href="<?php echo Yii::app()->params['parenthost']?>" target="_blank">
							<span class="ico ico_site"></span>
							<span class="name">На сайт</span>
						</a>
					</div>
					<div id="exit">
						<a href="http://support.reactive.by/" target="_blank">
							<span class="ico ico_ask"></span>
							<span class="name">Задать вопрос</span>
						</a>
					</div>
					<div id="exit">
						<!--a href="https://vh1.ideahost.by/webmail/index.php" target="_blank">
							<span class="ico ico_mail"></span>
							<span class="name">Почта</span>
						</a-->
					</div>
					
				
				</div>


				<div id="content">
					<div class="zagolovok">
						<span><?=$this->h1; ?></span>
					</div>

					<?php $this->widget('application.views.widgets.Breadcrumbs', array('links' => $this->breadcrumbs)); ?>

					<?=$content; ?>
				</div>
			</div>		
		</div>
	</div>
</div>
</div>

<script src="/admin/js/custom_select.js" type="text/javascript"></script>
</body>
</html>