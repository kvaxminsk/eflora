<? $i = 0;
foreach ($categories as $item): ?>
    <div>
        <?
        //		var_dump($item['img']);die('fdsaf');
        $image = ($item['img']['path']) ? $item['img']['path'] : '/images/no-photo.gif';
        $image = image($image, 'resize', '1500', '986');
        ?>
        <p style="background: url(<?= $image; ?>) 0 0 no-repeat; "></p>
    </div>
<? endforeach; ?>
<script>
    $('.fade').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        arrows: false,
        cssEase: 'linear',
        customPaging: function (slick, index) {
            var title = "";
            var rb_title = "";
            var rb_description = "";
            switch (index) {
            <? $i = 0;
                foreach($categories as $item): ?>

                case  <?=$i++;?>: //alert("<?=$item['name']?>");
                    title = "<?=$item['name']?>";
                    rb_title = '<?= trim($item['title_main'] ? $item['title_main'] : $item['name']) ?>';
                    rb_description = '<?= str_replace('\n', '', trim($item['description_main'] ? $item['description_main'] : $item['name'])); ?>';
                    idCategory = "<?=$item['id']?>";
                    break;
            <? endforeach; ?>
            }
            return '<span data-category="' + idCategory + '"class="reason_link"     data-title="' + rb_title + '  "  data-description  = "' + rb_description + '"  >' + title + '</span>';
        }
    });
</script>

