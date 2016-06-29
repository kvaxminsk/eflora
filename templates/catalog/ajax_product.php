<?//=$price?>
<?//=$type?>

<?
$this->widget('SMListView',
    array(
        'dataProvider' => $products,
        'itemView' => '_products',
        'ajaxUpdate' => true,
        'template' => "{items}\n{pager}",
        'enablePagination' => false
    )
);
?>
<li class="product" id="show_more_item">
    <div class="download_more">
        <div class="download_icon">
            +
        </div>
                            <span>
								ПОКАЗАТЬ ЕЩЕ
							</span>
    </div>
</li>
<? // $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
<script>

    $("#show_more_item").click(function () {
        var page = <?= ($pagevar + 1) ?>;
        if ($('.slick-active span').attr('data-category')) {
            var category1 = $('.slick-active span').attr('data-category');
        }
        else {
            var category1 = $('.slick-active-catalog a').attr('data-category');
        }

        var category2 = $('#theme_text').attr('data-category');

        var category3 = 17;
        if (category1 != 17) {
            category3 = category1;
        }
        else if ((category2 != 17) && (category2 != undefined)) {
            category3 = category2;
        }
        else {
            category3 = 17;
        }
        $.ajax({
            type: 'get',
            data: 'page=' + page + '&category=' + category3+ "&popular=" + "<?=$popular?>"+ "&price=" + "<?=$price?>" + "&type="+ "<?=$type?>"+ "&summa="+ "<?=$summa?>",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('#show_more_item').remove();
                $('.flower_products').append(data);
                changeCurrency();
                if (localStorage['currency']) {
                    var currency = JSON.parse(localStorage['currency']);
                    if (currency == 'us') {
                        $('.header_price_icon>.backet_circle>p').text("$");
                        $('#points').css('margin-left', '36px');
                        $('#header_price_text_us').show();
                        $('#header_price_text_br').hide();
                        $('.old_price').hide();
                        $('.new_price').hide();
                        $('.dollar_price').show();
                    }
                    else {
                        currency = 'br';
                        localStorage['currency'] = JSON.stringify(currency);
                        $('.header_price_icon>.backet_circle>p').text("Br");
                        $('#points').css('margin-left', '100px');
                        $('#header_price_text_us').hide();
                        $('#header_price_text_br').show();
                        $('.old_price').show();
                        $('.new_price').show();
                        $('.dollar_price').hide();
                    }
                }
                else {
                    currency = 'br';
                    localStorage['currency'] = JSON.stringify(currency);
                    $('#points').css('margin-left', '100px');
                    $('#header_price_text_us').hide();
                    $('#header_price_text_br').show();
                }
            }
        });
    });
</script>

