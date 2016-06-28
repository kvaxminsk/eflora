<? if (!empty($this->breadcrumbs)): ?>
    <div class="bread_way">
        <a href="/">Главная</a> <span>&#9002;</span>
        <? $last = end($this->breadcrumbs); ?>
        <? foreach ($this->breadcrumbs as $i => $br): ?>
            <? if ($br['meta_id'] == $last['meta_id']): ?>
                <a class="bread_way_active" href="#"><?= $br['name'] ?></a>
            <? else: ?>
                <a href="<?= $br['url'] ?>"><?= $br['name'] ?></a> <span>&#9002;</span>
            <? endif; ?>
        <? endforeach; ?>
    </div>
<? endif; ?>