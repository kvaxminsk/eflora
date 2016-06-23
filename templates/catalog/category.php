<?
$this->widget('SMListView',
	array(
		'dataProvider'      => $products,
		'itemView'          => '_article',
		'ajaxUpdate'        => true,
		'template'          => "{items}\n{pager}",
		'enablePagination'  => false
	)
);
?>
<li class = "product" id="show_more_item">
	<div class="download_more">
		<div class="download_icon">
			+
		</div>
                            <span >
								ПОКАЗАТЬ ЕЩЕ
							</span>
	</div>
</li>
<?// $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
<script>

	$("#show_more_item").click(function(){

		var page = <?= ($pagevar+1) ?>;
		var category1 =  $('.slick-active span').attr('data-category');
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
//            alert(category1);
//            alert(category2);
//            alert(category3);
		$.ajax({
			type: 'get',
			data:'page=' + page +'&category=' + category3,
			url: '/ajax-products',
			success: function(data){
				//document.write();
				$('#show_more_item').remove();
				$('.flower_products').append(data);

			}
		});
	});
</script>

