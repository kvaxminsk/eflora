<?php

class SMLinkPager extends CBasePager
{
    public $maxButtonCount=10;
    
    public $file = 'pager';
    
	public function run()
	{
		$buttons = $this->createPageButtons();
        $pages = $this->pages; 
        $this->render('webroot.templates.blocks.'.$this->file , array('buttons' => $buttons, 'pages' => $pages));    
	}

	
	protected function createPageButtons()
	{
		if(($pageCount = $this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage) = $this->getPageRange();
        
		$currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons = array();

		// first page
		$buttons['first'] = $this->createPageButton(0, $currentPage <= 0, false);

		// prev page
		if(($page = $currentPage-1)<0)
			$page = 0;
		$buttons['prev'] = $this->createPageButton($page, $currentPage <= 0, false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons['pages'][$i+1] = $this->createPageButton($i, false, $i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons['next'] = $this->createPageButton($page, $currentPage >= $pageCount-1, false);

		// last page
		$buttons['last'] = $this->createPageButton($pageCount-1, $currentPage >= $pageCount-1 , false);
  
		return $buttons;
	}


	protected function createPageButton($page, $hidden, $selected)
	{
        $result = array();
        
        if($hidden){
            $result['hidden'] = 1;
        }else{
            $result['hidden'] = 0;
        }
        
        if($selected){
            $result['selected'] = 1;
        }else{
            $result['selected'] = 0;
        }
        
        $result['url'] = $this->createPageUrl($page);
       
		return $result;
	}


	protected function getPageRange()
	{
		$currentPage=$this->getCurrentPage();
		$pageCount=$this->getPageCount();

		$beginPage=max(0, $currentPage-(int)($this->maxButtonCount/2));
		if(($endPage=$beginPage+$this->maxButtonCount-1)>=$pageCount)
		{
			$endPage=$pageCount-1;
			$beginPage=max(0,$endPage-$this->maxButtonCount+1);
		}
		return array($beginPage,$endPage);
	}

	

}
