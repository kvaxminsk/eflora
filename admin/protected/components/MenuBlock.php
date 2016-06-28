<?php

class MenuBlock extends CWidget
{

    public $type;

    public $file;

    public $tree = false;

    public $uri;

    public function run()
    {
        Yii::import('application.modules.menu.models.*');
        Yii::import('application.modules.material.models.*');

        $uri = $_SERVER['REQUEST_URI'];
        $uri = preg_replace('#\?(.*)#si', '', $uri);
        $this->uri = $uri;

        $model = Menu::model()->with('material')->find('alias=:alias', array('alias' => $this->type));
        $material_id = array();
        $menu = array();

        if (!empty($model->material)) {
            foreach ($model->material as $k => $v) {
                $material_id[] = $v->id;
            }

            if ($this->tree) {
                $materials = Material::model()->TreeBehavior->getTreeData();
                $menu = $this->getMenuTree($materials, $material_id);
            } else {
                $materials = Material::model()->findAllData();
                $menu = $this->getMenu($materials, $material_id);
            }
        }
//         var_dump($menu);
        $this->render('webroot.templates.blocks.' . $this->file, array('menu' => $menu));

    }

    public function getMenuTree($materials, $ids, $result = array())
    {
        foreach ($materials as $k => $v) {
            if ((in_array($v['id'], $ids)) && ($v['active'])) {
                $v = $this->getActive($v);
                $result[$k] = $v;
                unset($result[$k]['children']);
                unset($result[$k]['parent']);
            }
            if (!empty($v['children'])) {
                $result[$k]['children'] = $this->getMenuTree($v['children'], $ids);
            }
        }
        return $result;
    }

    public function getMenu($materials, $ids)
    {
        $result = array();
        foreach ($materials as $k => $v) {
            if ((in_array($v['id'], $ids)) && ($v['active'])) {
                $v = $this->getActive($v);
                $result[$k] = $v;
                unset($result[$k]['children']);
                unset($result[$k]['parent']);
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