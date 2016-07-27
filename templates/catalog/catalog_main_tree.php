<? $i = 0;
foreach ($categories as $item): ?>

    <!--	--><? // var_dump($item); ?>
    <div>
        <?
        //		var_dump($item['img']);die('fdsaf');
        $image = ($item['img']['path']) ? $item['img']['path'] : '/images/no-photo.gif';
        $image = image($image, 'resize', '1500', '986');
        ?>
        <p style="background: url(<?= $image; ?>) 0 0 no-repeat; background-size:cover"></p>
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

                case  <?=$i++;?>:
                    title = "<?=$item['name']?>";
                    rb_title = '<?= trim($item['title_main'] ? $item['title_main'] : $item['name']) ?>';
                    rb_description = '<?= str_replace('\n', '', trim($item['description_main'] ? $item['description_main'] : $item['name'])); ?>';
                    idCategory = "<?=$item['id']?>";
                    urlCategory = "<?=$item['url']?>";

                    break;
            <? endforeach; ?>
            }
            return '<a class="reason_link_a" href="#" data-url="' + urlCategory + '" data-category="' + idCategory + '" data-title="' + rb_title + '  " data-description  = "' + rb_description + '"><span  class="reason_link"         >' + title + '</span></a>';

        }
    });
</script>
