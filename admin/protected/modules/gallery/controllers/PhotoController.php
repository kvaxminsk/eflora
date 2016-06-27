<?php


class PhotoController extends BackController
{

    public $modulerun = 'GalleryPhoto';

    #выставляем активность объекта
    public function actionPublic($id)
    {
        $model = GalleryPhoto::model()->findByPk($_GET['id']);
        if ($model->active == 1) {
            $model->active = 0;
        } else {
            $model->active = 1;
        }
        $model->save();

    }

    #удаляем объект
    public function actionDelete($id)
    {
        $model = GalleryPhoto::model()->findByPk($_GET['id']);
        $model->delete();
    }

    #действие с несколькими объектами
    function actionAll()
    {
        if (isset($_POST['values']) && isset($_POST['action'])) {
            $values = explode(';', $_POST['values']);
            switch ($_POST['action']) {
                case 'save':
                    $inputs = json_decode($_POST['values']);
                    foreach ($inputs as $k => $v) {
                        $model = GalleryPhoto::model()->findByPk($v->id);
                        foreach ($v as $k1 => $v1) {
                            if ($k1 != 'id') {
                                $model->$k1 = $v1;
                            }
                        }
                        $model->save();
                    }
                    break;
                case 'on':
                    for ($i = 0; $i < count($values); $i++) {
                        $model = GalleryPhoto::model()->findByPk($values[$i]);
                        $model->active = 1;
                        $model->save();
                    }
                    break;
                case 'off':
                    for ($i = 0; $i < count($values); $i++) {
                        $model = GalleryPhoto::model()->findByPk($values[$i]);
                        $model->active = 0;
                        $model->save();
                    }
                    break;
                case 'del':
                    for ($i = 0; $i < count($values); $i++) {
                        $model = GalleryPhoto::model()->findByPk($values[$i]);
                        $model->delete();
                    }
                    break;
            }
        }
    }

}
