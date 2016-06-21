<?php
/**
 * CMenu class file.
 *
 * @author Jonah Turnquist <poppitypop@gmail.com>
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CMenu displays a multi-level menu using nested HTML lists.
 *
 * The main property of CMenu is {@link items}, which specifies the possible items in the menu.
 * A menu item has three main properties: visible, active and items. The "visible" property
 * specifies whether the menu item is currently visible. The "active" property specifies whether
 * the menu item is currently selected. And the "items" property specifies the child menu items.
 *
 * The following example shows how to use CMenu:
 * <pre>
 * $this->widget('zii.widgets.CMenu', array(
 *     'items'=>array(
 *         // Important: you need to specify url as 'controller/action',
 *         // not just as 'controller' even if default acion is used.
 *         array('label'=>'Home', 'url'=>array('site/index')),
 *         // 'Products' menu item will be selected no matter which tag parameter value is since it's not specified.
 *         array('label'=>'Products', 'url'=>array('product/index'), 'items'=>array(
 *             array('label'=>'New Arrivals', 'url'=>array('product/new', 'tag'=>'new')),
 *             array('label'=>'Most Popular', 'url'=>array('product/index', 'tag'=>'popular')),
 *         )),
 *         array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
 *     ),
 * ));
 * </pre>
 *
 *
 * @author Jonah Turnquist <poppitypop@gmail.com>
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id$
 * @package zii.widgets
 * @since 1.1
 */
class CMenuAdmin extends CWidget
{
	/**
	 * @var array list of menu items. Each menu item is specified as an array of name-value pairs.
	 * Possible option names include the following:
	 * <ul>
	 * <li>label: string, optional, specifies the menu item label. When {@link encodeLabel} is true, the label
	 * will be HTML-encoded. If the label is not specified, it defaults to an empty string.</li>
	 * <li>url: string or array, optional, specifies the URL of the menu item. It is passed to {@link CHtml::normalizeUrl}
	 * to generate a valid URL. If this is not set, the menu item will be rendered as a span text.</li>
	 * <li>visible: boolean, optional, whether this menu item is visible. Defaults to true.
	 * This can be used to control the visibility of menu items based on user permissions.</li>
	 * <li>items: array, optional, specifies the sub-menu items. Its format is the same as the parent items.</li>
	 * <li>active: boolean, optional, whether this menu item is in active state (currently selected).
	 * If a menu item is active and {@link activeClass} is not empty, its CSS class will be appended with {@link activeClass}.
	 * If this option is not set, the menu item will be set active automatically when the current request
	 * is triggered by {@link url}. Note that the GET parameters not specified in the 'url' option will be ignored.</li>
	 * <li>template: string, optional, the template used to render this menu item.
	 * When this option is set, it will override the global setting {@link itemTemplate}.
	 * Please see {@link itemTemplate} for more details. This option has been available since version 1.1.1.</li>
	 * <li>linkOptions: array, optional, additional HTML attributes to be rendered for the link or span tag of the menu item.</li>
	 * <li>itemOptions: array, optional, additional HTML attributes to be rendered for the container tag of the menu item.</li>
	 * <li>submenuOptions: array, optional, additional HTML attributes to be rendered for the container of the submenu if this menu item has one.
	 * When this option is set, the {@link submenuHtmlOptions} property will be ignored for this particular submenu.
	 * This option has been available since version 1.1.6.</li>
	 * </ul>
	 */
	public $items=array();
	/**
	 * @var string the template used to render an individual menu item. In this template,
	 * the token "{menu}" will be replaced with the corresponding menu link or text.
	 * If this property is not set, each menu will be rendered without any decoration.
	 * This property will be overridden by the 'template' option set in individual menu items via {@items}.
	 * @since 1.1.1
	 */
	public $itemTemplate;
	/**
	 * @var boolean whether the labels for menu items should be HTML-encoded. Defaults to true.
	 */
	public $encodeLabel=true;
	/**
	 * @var string the CSS class to be appended to the active menu item. Defaults to 'active'.
	 * If empty, the CSS class of menu items will not be changed.
	 */
	public $activeCssClass='active';
	/**
	 * @var boolean whether to automatically activate items according to whether their route setting
	 * matches the currently requested route. Defaults to true.
	 * @since 1.1.3
	 */
	public $activateItems=true;
	/**
	 * @var boolean whether to activate parent menu items when one of the corresponding child menu items is active.
	 * The activated parent menu items will also have its CSS classes appended with {@link activeCssClass}.
	 * Defaults to false.
	 */
	public $activateParents=false;
	/**
	 * @var boolean whether to hide empty menu items. An empty menu item is one whose 'url' option is not
	 * set and which doesn't contain visible child menu items. Defaults to true.
	 */
	public $hideEmptyItems=true;
	/**
	 * @var array HTML attributes for the menu's root container tag
	 */
	public $htmlOptions=array();
	/**
	 * @var array HTML attributes for the submenu's container tag.
	 */
	public $submenuHtmlOptions=array();
	/**
	 * @var string the HTML element name that will be used to wrap the label of all menu links.
	 * For example, if this property is set as 'span', a menu item may be rendered as
	 * &lt;li&gt;&lt;a href="url"&gt;&lt;span&gt;label&lt;/span&gt;&lt;/a&gt;&lt;/li&gt;
	 * This is useful when implementing menu items using the sliding window technique.
	 * Defaults to null, meaning no wrapper tag will be generated.
	 * @since 1.1.4
	 */
	public $linkLabelWrapper;
	/**
	 * @var string the CSS class that will be assigned to the first item in the main menu or each submenu.
	 * Defaults to null, meaning no such CSS class will be assigned.
	 * @since 1.1.4
	 */
	
	public $module="";
	
	public $firstItemCssClass;
	/**
	 * @var string the CSS class that will be assigned to the last item in the main menu or each submenu.
	 * Defaults to null, meaning no such CSS class will be assigned.
	 * @since 1.1.4
	 */
	public $lastItemCssClass;
	/**
	 * @var string the CSS class that will be assigned to every item.
	 * Defaults to null, meaning no such CSS class will be assigned.
	 * @since 1.1.9
	 */
	public $itemCssClass;
	
	protected $lines;

	/**
	 * Initializes the menu widget.
	 * This method mainly normalizes the {@link items} property.
	 * If this method is overridden, make sure the parent implementation is invoked.
	 */
	public function init()
	{
		if(isset(Yii::app()->controller->module->id)){
			$this->module=Yii::app()->controller->module->id;
		} else {
			if($this->module==""){
				if(isset(Yii::app()->controller->id)){
					$this->module=Yii::app()->controller->id;
				}
			}
		}
		$this->items=$this->getModulesMenu(0);
		$this->htmlOptions['id']=$this->getId();
		$route=$this->getController()->getRoute();
		$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild); 
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		
		$this->renderMenu($this->items); 
	}

	
	protected function getModulesMenu($parent){
		if(!isset($this->lines)){
			$this->lines=Yii::app()->db->createCommand()->select('*')->from('sm_modules')
			->where('tshow = 1')->order('sort ASC')->queryAll();
		}
		$menu=array();
		for($i=0;$i<count($this->lines);$i++){
			if($this->lines[$i]['parent']==$parent){
				$menuitem=array('label'=>$this->lines[$i]['name'], 'module'=>$this->lines[$i]['module'], 'url'=>array($this->lines[$i]['default_action']), 'image'=>$this->lines[$i]['image']);
				$childs=$this->getModulesMenu($this->lines[$i]['id']);
				if(isset($childs)){
					$menuitem['items']=$childs;
				}
				$module="";
				if(isset(Yii::app()->controller->module->id)){
					$module=Yii::app()->controller->module->id;
				}
				
				if($this->lines[$i]['module']=='catalog' && $parent==0){
					$cmenu=self::getCatalogMenu();
					$menuitem['items'][]=array('label'=>'Все товары', 'url'=>array('/catalog/product/index'));

					$menuitem['items'][]=array('label'=>'Топ товары', 'url'=>array('/catalog/product/index/top/1'));
					for($t=0;$t<count($cmenu);$t++){
						$menuitem['items'][]=$cmenu[$t];
					}
				}
				if($this->lines[$i]['module']=='gallery'){
					$menuitem['items']=self::getAlbumsMenu();
				}
				if($this->lines[$i]['module']=='articles' && $parent==0){
					$menuitem['items']=self::getArticlesCategoryMenu();
				}
				$menu[]=$menuitem;			
			}	
		}
		return $menu;
	} 
	
	static function getAlbumsMenu(){
		Yii::import('application.modules.gallery.models.*');
		require_once 'Album.php';
		$amenu = array();
		$amenu[]=array('label'=>'Все фото', 'url'=>array('/gallery/albumPhoto/index'));

		$albums=Album::getAlbums();
		if($albums){
			for($i=0;$i<count($albums);$i++){
				$amenu[]=array('label'=>$albums[$i]->name, 'url'=>array('/gallery/albumPhoto/index/album/'.$albums[$i]->id));
			}
		}
		return $amenu;
	}
	
	static function getCatalogMenu(){
		Yii::import('application.modules.catalog.models.*');
		require_once 'Category.php';
		$menu=array();

		$catalogs=Catalog::getAllCatalogs();
		for($i=0;$i<count($catalogs);$i++){
			$childs=null;
			$menuitem=array('label'=>$catalogs[$i]['name'], 'url'=>array('/catalog/product/index/category/'.$catalogs[$i]->id));
			 if(count($catalogs[$i]->childs)){
				$childs=self::getCategoriesMenu($catalogs[$i]->childs);
				$menuitem['items']=$childs;
			} 
			$menu[]=$menuitem;
		}
		return $menu;
	}
	
	static private function getCategoriesMenu($categoryes){
		$menu=array();

		for($i=0;$i<count($categoryes);$i++){
			$menuitem=array('label'=>$categoryes[$i]['name'], 'url'=>array('/catalog/product/index/category/'.$categoryes[$i]->id));
			if(count($categoryes[$i]->childs)>0){
				$childs=self::getCategoriesMenu($categoryes[$i]->childs);
				$menuitem['items']=$childs;
			}else{
				$menuitem=array('label'=>$categoryes[$i]['name'], 'url'=>array('/catalog/product/index/category/'.$categoryes[$i]->id));
				}
			$menu[]=$menuitem;
		}
		return $menu; 
	}

	static function getArticlesCategoryMenu(){
		Yii::import('application.modules.articles.models.*');
		require_once 'Articlecategory.php';
		$categories = Articlecategory::model()->findAll();
		$menu=array();
		$childs=null;
		$menu[]=array('label'=>'Все статьи', 'url'=>array('/articles/manage/index'));
		for($i=0;$i<count($categories);$i++){
			$menu[]=array('label'=>$categories[$i]->name, 'url'=>array('/articles/manage/index/category/'.$categories[$i]->id));
		}
		return $menu;
	}
	
	/**
	 * Renders the menu items.
	 * @param array $items menu items. Each menu item will be an array with at least two elements: 'label' and 'active'.
	 * It may have three other optional elements: 'items', 'linkOptions' and 'itemOptions'.
	 */
	protected function renderMenu($items)
	{
		 if(count($items))
		{
			echo CHtml::openTag('ul',array('class'=>'left_menu'))."\n";
			$this->renderMenuRecursive($items);
			echo CHtml::closeTag('ul'); 
		} 
	}

	/**
	 * Recursively renders the menu items.
	 * @param array $items the menu items to be rendered recursively
	 */
	protected function renderMenuRecursive($items, $children=0)
	{
		$count=0;
		$n=count($items);
		if($children==1){
			echo '<ul class="children">';
		}
		foreach($items as $item)
		{
			$isActive = 0;
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$class=array();
			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!==null)
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!==null)
				$class[]=$this->lastItemCssClass;
			if($this->itemCssClass!==null)
				$class[]=$this->itemCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}
			$cclass=array();
			if($children==0){
				$cclass=array('class'=>'l1_li');
				if(($this->module=='catalog' && $item['module']=='catalog') || 
					($this->module=='gallery' && $item['module']=='gallery')|| 
					($this->module=='articles' && $item['module']=='articles')){
					$cclass['class'].=' open';
				}
				if ($this->module==$item['module']){
					$cclass['class'].=' active';
					$isActive = 1;
				}
			}
			$module="";
			if(isset(Yii::app()->controller->module->id)){
				$module=Yii::app()->controller->module->id;
			}
			if($children!=0 && $module=="catalog"){
				$cclass=array('class'=>''); //open

				if(isset($item['items']) && count($item['items'])){
					foreach ($item['items'] as $url) {
						$tmp1 = $url['url'];
						$tmp2 = '/'.Yii::app()->request->pathInfo;
						if($tmp1[0] == $tmp2){
							$cclass=array('class'=>'open'); //open

						}
					}
				}
			}
			echo CHtml::openTag('li', $cclass);
			
				$menu=$this->renderMenuItem($item, $children, $isActive);
				
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else {
				
				echo $menu;
			}

			if(isset($item['items']) && count($item['items']))
			{
				$this->renderMenuRecursive($item['items'], 1);
			}

			echo CHtml::closeTag('li')."\n";
		} 
		if($children==1){
			echo '</ul>';
		}
	}

	/**
	 * Renders the content of a menu item.
	 * Note that the container and the sub-menus are not rendered here.
	 * @param array $item the menu item to be rendered. Please see {@link items} on what data might be in the item.
	 * @return string
	 * @since 1.1.6
	 */
	protected function renderMenuItem($item, $children, $isActive)
	{
		 $html="";
		if(isset($item['url']))
		{
			if(isset($item['image'])){
				$image=$item['image'];
			} else {
				$image='';
			}
			$class=array();
			if($children==0){
				$class=array('class'=>'l1_a');
			}
			if($children==0 && isset($item['items'])){
				$html.='<span class="openhide"></span>';
			}
			if($children!=0 && isset($item['items']) && count($item['items'])>0){
				$html.='<span class="openhide"></span>';
			}
			$html.=CHtml::openTag('a', $class+array('href'=>Yii::app()->baseUrl.$item['url'][0]));
			if($image!=''){
				$html.='<span class="ico">';
				if($isActive==1){
					$html.='<img src="'.Yii::app()->baseUrl.'/images/active/'.$image.'">';
				}else{
					$html.='<img src="'.Yii::app()->baseUrl.'/images/'.$image.'">';
				}
				$html.='</span>';
			}
			if($children==0){
				$html.='<span class="title">'.$item['label'].'</span>';
			} else {
				$html.=$item['label'];
			}
			$html.=CHtml::closeTag('a');
			return $html;
		}
		else
			return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']); 
	}

	/**
	 * Normalizes the {@link items} property so that the 'active' state is properly identified for every menu item.
	 * @param array $items the items to be normalized.
	 * @param string $route the route of the current request.
	 * @param boolean $active whether there is an active child menu item.
	 * @return array the normalized menu items
	 */
	protected function normalizeItems($items,$route,&$active)
	{
		 foreach($items as $i=>$item)
		{
			if(isset($item['visible']) && !$item['visible'])
			{
				unset($items[$i]);
				continue;
			}
			if(!isset($item['label']))
				$item['label']='';
			if($this->encodeLabel)
				$items[$i]['label']=CHtml::encode($item['label']);
			$hasActiveChild=false;
			if(isset($item['items']))
			{
				$items[$i]['items']=$this->normalizeItems($item['items'],$route,$hasActiveChild);
				if(empty($items[$i]['items']) && $this->hideEmptyItems)
				{
					unset($items[$i]['items']);
					if(!isset($item['url']))
					{
						unset($items[$i]);
						continue;
					}
				}
			}
			if(!isset($item['active']))
			{
				if($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item,$route))
					$active=$items[$i]['active']=true;
				else
					$items[$i]['active']=false;
			}
			else if($item['active'])
				$active=true;
		}
		return array_values($items);
	} 
	

	/**
	 * Checks whether a menu item is active.
	 * This is done by checking if the currently requested URL is generated by the 'url' option
	 * of the menu item. Note that the GET parameters not specified in the 'url' option will be ignored.
	 * @param array $item the menu item to be checked
	 * @param string $route the route of the current request
	 * @return boolean whether the menu item is active
	 */
	protected function isItemActive($item,$route)
	{
	 	if(isset($item['url']) && is_array($item['url']) && !strcasecmp(trim($item['url'][0],'/'),$route))
		{
			unset($item['url']['#']);
			if(count($item['url'])>1)
			{
				foreach(array_splice($item['url'],1) as $name=>$value)
				{
					if(!isset($_GET[$name]) || $_GET[$name]!=$value)
						return false;
				}
			}
			return true;
		}
		return false; 
	}
}