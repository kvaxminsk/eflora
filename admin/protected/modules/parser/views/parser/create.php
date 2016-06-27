<? $this->breadcrumbs = array('Выгрузка', 'Парсинг'); ?>

<? if ($redirect): ?>
    <div style="color: red; font-size: 16px; padding-top: 150px;">Пожалуйста не перезагружайте страничку до окончания
        выгрузки...
    </div>
<? endif ?>

    <div style="color: #00B575; font-size: 20px; margin-top: 10px;"><?= $info ?></div>

<? if ($redirect): ?>
    <script>location.href = "<?=$redirect?>"</script>
<? endif ?>