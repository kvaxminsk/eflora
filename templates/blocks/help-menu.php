<? if (!empty($menu)): ?>
    <ul class="help_list">
        <? foreach ($menu as $item): ?>
            <? if (!isset($item['children'])): ?>
                <li class="<?=($_SERVER['REQUEST_URI'] == $item['url']) ? 'visit_help_menu':'';?>">
                    <a href="<?= $item['url'] ?>"><?= $item['name'] ?></a>
                </li>
            <? endif; ?>

        <? endforeach; ?>
    </ul>
<? endif; ?>
<script>
//text_pagwte
</script>
<!--<ul>-->
<!--	<li><a href="#">Способы оплаты</a></li>-->
<!--	<li><a href="#">Оформление свадьбы</a></li>-->
<!--	<li><a href="#">Доставка цветов</a></li>-->
<!--	<li><a href="#">О нас</a></li>-->
<!--	<li><a href="#">Частые вопросы</a></li>-->
<!--	<li><a href="#">Отзывы клиентов</a></li>-->
<!--	<li><a href="#">Гарантия качества</a></li>-->
<!--	<li><a href="#">Юридическим лицам</a></li>-->
<!--	<li><a href="#">Наши друзья</a></li>-->
<!--</ul>-->