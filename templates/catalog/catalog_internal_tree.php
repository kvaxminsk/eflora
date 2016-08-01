<div class="catalog_list_wrapper">
    <div class="catalog_list">
        <ul>
            <? $i = 0;
            foreach ($categories as $item): ?>
                <li  data-url="<?= $item['url']; ?>"><a href="<?= $item['url']; ?>" data-url="<?= $item['url']; ?>" data-category="<?= $item['id'] ?>"><?= $item['name'] ?></a></li>
            <? endforeach; ?>
        </ul>
    </div>
</div>


