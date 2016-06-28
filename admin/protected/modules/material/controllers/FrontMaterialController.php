<?php

class FrontMaterialController extends FrontController
{


    public function __construct()
    {
        parent::__construct();
    }

    public function start($meta)
    {
        parent::start($meta);
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('home, alias, error, index, document, contacts, folder'),
                'users' => array('*'),
            ),
        );
    }

    #главная
    public function actionHome()
    {
        $meta = MetaTag::model()->find('alias=:alias', array('alias' => '/'));

        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $this->render('home', array(
            'model' => $model,
        ));
    }

    #тип страница
    public function actionDocument($alias, $meta)
    {
        $this->layout = 'webroot.templates.layout-internal';
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $this->render('document', array(
            'model' => $model,
        ));
    }

    #тип страница
    public function actionSertificat($alias, $meta)
    {
        $this->layout = 'webroot.templates.layout-internal';
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $this->render('sertificat', array(
            'model' => $model,
        ));
    }

    #тип папка
    public function actionFolder($alias, $meta)
    {
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        parent::meta($model, $meta);

        $this->render('folder', array(
            'model' => $model,
        ));
    }

    #тип контакты
    public function actionContacts($alias, $meta)
    {
        $this->layout = 'webroot.templates.layout-contacts';
        $redirect = str_replace('?result=yes', '', getEnv('HTTP_REFERER'));
        $redirect = str_replace('?result=no', '', $redirect);

        if (!empty($_POST)) {
            $host = str_replace('www.', '', getEnv('HTTP_HOST'));
            $subject = 'Сообщение через форму обратной связи на сайте www.' . $host;

            $email = $this->variables['email'];
            $email = explode(',', $email);
            $from = $_POST['email'];
            $to = $this->variables['email'];

            $message = '<p>Новое сообщение на сайте www.' . $host . '</p>';
            $message .= 'Имя: <b>' . $_POST['name'] . '</b>';
            //$message .= '<br>Телефон: <b>' . (!empty($_POST['phone']) ? $_POST['phone'] : 'не указан') . '</b>';
            $message .= '<br>E-mail: <b>' . (!empty($_POST['email']) ? $_POST['email'] : 'не указан') . '</b>';
            $message .= '<br>Сообщение: <br>' . $_POST['message'] . '<hr>';

            if (sendEmail($message, $subject, $from, $to)) {
                $this->redirect($redirect . '?result=yes');
            } else {
                $this->redirect($redirect . '?result=no');
            }
        } elseif (!empty($_POST)) {
            $this->redirect($redirect . '?result=no');
        }

        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));
        parent::meta($model, $meta);

        $this->render('contacts', array(
            'model' => $model,
        ));
    }

    #страница не найдена
    public function actionError($alias, $meta)
    {
        $this->layout = 'webroot.templates.layout-error';
        $model = Material::model()->find('meta_id=:meta_id', array('meta_id' => $meta->id));

        if (empty($model)) {
            $this->redirect('/');
        }

        header('HTTP/1.0 404 Not Found');

        parent::meta($model, $meta);

        $this->render('error', array(
            'model' => $model,
            'meta' => $meta
        ));
    }


    public function getViewPath()
    {
        $controllername = $this->getId();
        $newPath = "webroot.templates.material";
        $newPath = YiiBase::getPathOfAlias($newPath);
        return $newPath;
    }
}
