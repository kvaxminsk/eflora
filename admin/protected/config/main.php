<?php
define('FILEMAN_VERSION', '0.93.2 alpha');
define('IS_FRONTEND',false);

$frontend = dirname(dirname(dirname(dirname(__FILE__)))) . DS . 'protected';
Yii::setPathOfAlias('frontend', $frontend);

$admin = explode('/', $_SERVER['REQUEST_URI']);
$params = array(
    'basePath' => __DIR__ . DS . '..',

    'name' => 'Reactive',
    
    'preload' => array('log'),
    
    'language' => 'ru',

    'import'=>array(
        'application.models.*',
            
        'application.components.*',
        'application.components.widgets.*',
    		
        'application.framework.zii.widgets.grid.CGridView',
           
        'application.modules.material.models.*',
        'application.modules.material.controllers.*',
            
		'application.modules.menu.models.*',
        'application.modules.menu.components.*',
        'application.modules.variables.models.*',
        'application.models.behaviors.*',
        'application.models.*',
        'application.controllers.*',
     ),

	'modules' => array(
		'faq',
		'articles',
		'contacts',
		'testimonials',
		'catalog',
		'brands',
		'shop',
		'parser',
		'slider',
		'material',
		'menu',
		'variables',
		'filemanager',
		'config',
		'sitemap',
		'gallery',
		'modules',
		'news',
		'sourceeditor',
        'gii' => array(
            'class' => 'application.framework.gii.GiiModule',
            'password' => '1dsadsadas23dsas456',
        ),
		
     
	),


	'components' => array(
        'image' => array(
            'class'  => 'application.extensions.image.CImageComponent',
            'driver' => 'GD',                               // ���� ImageMagick, ���� ������� � ���� ���� ����
            'params' => array( 'directory' => '/usr/bin' ), // � ���� ���������� ������ ���� convert
        ),
        
        'thumbs' => array(
            'class'   => 'application.extensions.EPhpThumb.EPhpThumb',
            'options' => array('jpegQuality' => 100),
        ),
        
		'user'  =>  array(
			'allowAutoLogin' => true,
		),	
        
        'urlManager' => array(
            'urlFormat'         => 'path',
            'showScriptName'    => false,
            'caseSensitive'     => false,    
            'appendParams'      => false,
        ),

        #������ � ��
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=glushiteli',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'sm_',
			// включает отображение sql запросов.
			'enableProfiling'=>true,
			'enableParamLogging' => true,
		),  

		'errorHandler' => array(
			'errorAction' => 'admin/error',
		),
//		'log'=>array(
//			'class' => 'CLogRouter',
//			'routes' => array(
//				array(
//					'class'=>'CFileLogRoute',
//					'levels'=>'error, warning',
//				),
//			),
//		),
//		'log'=>array(
//			'class'=>'CLogRouter',
//			'routes'=>array(
//        array(
//			// направляем результаты профайлинга в ProfileLogRoute (отображается
//			// внизу страницы)
//			'class'=>'CProfileLogRoute',
//			'levels'=>'profile',
//			'enabled'=>true,
//				),
//			),
//		),
		'ih' => array(
			'class'=>'CImageHandler',
		),
	),
	
	'params' => array(
		'parenthost' => 'http://'. $_SERVER['HTTP_HOST'].'/',
		'rootDir' => '',
	  	'dateTimeFormat' => 'HH:mm:ss dd.MM.y',
	    'dirPermissions' => '755',
  		'filePermissions' => '755',
  		'itemsOnPage' => '50',
	),
);

if($admin[1] == 'admin') {
    $params['components']['urlManager']['rules'] = array(
        '/' => array('admin/index'),
        '/login' => array('admin/login', 'urlSuffix'=>''),
        '/login-test' => array('admin/logintest',),
        '/logout' => array('admin/logout'),
        '/password' => array('admin/password'),
    );
} else {
    $params['components']['urlManager']['rules'] = array(		
        #sitemap
		'/sitemap' => array('sitemap/sitemap/index'),
        
        #������ �����
        '/online' => array('front/online'),
//        '/ajax-products' => array('front/catalog/ajaxproducts'),

        
        #pages
        '<alias:[\w\d\-_\/]*>' => array('front/alias', 'urlSuffix' => '.html'),
    
    );   
}
return $params;