<?php

class GalleryBlock extends CWidget
{

    public $file;

    public $uri;

    public function run()
    {
        Yii::import('application.modules.gallery.models.Category');

        $uri = $_SERVER['REQUEST_URI'];
        $uri = preg_replace('#\?(.*)#si', '', $uri);
        $this->uri = $uri;

        $categories = Gallery::model()->getTreeData();
        $categories = $this->getCategoryTree($categories);

        $this->render('webroot.templates.gallery.' . $this->file, array('categories' => $categories));
    }

    public function getCategoryTree($categories, $result = array())
    {
        foreach ($categories as $k => $v) {
            if ($v['active']) {
                $v = $this->getActive($v);
                $result[$k] = $v;
                unset($result[$k]['children']);
                unset($result[$k]['parent']);
                if (!empty($v['children'])) {
                    $result[$k]['children'] = array();
                    $result[$k]['children'] = $this->getCategoryTree($v['children'], $result[$k]['children']);
                }
            }
        }
        return $result;
    }

    public function getActive($v)
    {
        $urls = explode('/', $this->uri);
        if ($this->uri == '/') {
            $alias = '/';
        } else {
            $alias = end($urls);
        }
        unset($urls[count($urls) - 1]);
        if ($v['metatag']['alias'] == $alias) {
            $v['url_active'] = 1;
            $v['url_current'] = 0;
        } elseif (in_array($v['metatag']['alias'], $urls)) {
            $v['url_active'] = 0;
            $v['url_current'] = 1;
        } else {
            $v['url_active'] = 0;
            $v['url_current'] = 0;
        }
        return $v;
    }

}