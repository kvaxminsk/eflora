<div class="cp_right_main_content">
    <div class="text_wrapper">
        <h1><?= $this->h1 ?></h1>
        <?
        $image = (isset($model->img['path'])) ? $model->img['path'] : '/images/no-photo.gif';
        $image = image($image, 'resize', '260', false);
        ?>

        <img src="<?= $image ?>" alt="<?= $data->name ?>" title="<?= $data->name ?>"/>
        <h5><?= $model->date ?></h5>
        <?= $model->content ?>

    </div>
</div>