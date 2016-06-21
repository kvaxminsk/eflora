$(window).load(function() {

	$('.edit').click(function() {


		id=$(this).attr('id').split("_");
		$('#elem_'+id[2]).show('slow');
		$('#text_'+id[2]).hide();
		if(id[2]==205){
			$('#dates').show('slow');
		}
		$(this).hide();
		$('#button_ok_'+id[2]).show();
		$('#button_cancel_'+id[2]).show();
	})



	$('.cancel').click(function() {
		id=$(this).attr('id').split("_");
		$('#text_'+id[2]).show('slow');
		$('#elem_'+id[2]).hide();
		$('#elem_'+id[2]).val($('#text_'+id[2]).html().trim());
		if(id[2]==205){
			$('#dates').hide('slow');
		}
		$('#button_ok_'+id[2]).hide();
		$('#button_edit_'+id[2]).show();
		$(this).hide();
	})

// значения характеристик ид от 101 и дальше
// значения продукта от 201 и дальше
	
	
	
	
	
	$('.ok').click(function() {
		id=$(this).attr('id').split('_');
		if($('#elem_'+id[2]).attr('type')=='checkbox'){
			value=$('#elem_'+id[2]).attr('checked')=='checked';

		} else {
			value=$('#elem_'+id[2]).val();
		}
		if(id[2]>100 && id[2]<200){
			// url='http://cms.asimple.by/admin/catalog/ProdElement/AjaxUpdate';
			url='http://'+ window.location.hostname +'/admin/catalog/ProdElement/AjaxUpdate';
		} else {
			// url='http://cms.asimple.by/admin/catalog/product/AjaxUpdate';
			url='http://'+ window.location.hostname +'/admin/catalog/product/AjaxUpdate';
		}
		jQuery.ajax({'type':'POST',
			'dataType':'json',
			'data':{
			'name': $('#elem_'+id[2]).attr('name'),
			'value': value,
			'elemid': id[2],
			},
			'url':url,
			'success':function(data) {
	     	try{
	         		if(data.status=='ok'){
	         			$('#text_'+data.id).html(data.newvalue);
	         			if(data.selectid){
	         				$('#elem_'+data.id).change(data.selectid);
	         			} else {
	         				$('#elem_'+data.id).val(data.newvalue);
	         			}
	         			$('#button_ok_'+data.id).hide();
	         			$('#button_cancel_'+data.id).hide();
	         			$('#button_edit_'+data.id).show();
	         		} 
	         		$('#text_'+data.id).show();
	         		$('#elem_'+data.id).hide();
	         	}catch(ex){
	         		alert('error'+ex.description);
	         	}
	     	},
	     	'cache':false
	     });
	return false;
	})



	$('#close').click(function() {
		$("#ajax_box").slideUp('fast');
	})


	$('#open_file_change').click(function() {
		$("#ajax_box").slideDown('fast');
});
})