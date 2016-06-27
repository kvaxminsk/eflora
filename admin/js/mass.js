$(window).load(function() {
	$('#massbutton').click(function(){
		boxes = $('.chboxes');
        url = $('.grid-view').attr('jqurl');
        action = $('#massselect');
		action = action[0].value;
		out = '';

        if (action == 'save'){
            var rows_count = boxes.size();
            var inputArr = new Array();
            for(num = 0; num < rows_count; num++)
            {
                var inputObj = new Object();
                if(boxes.eq(num).val() > 0){
                    inputObj.id = boxes.eq(num).val();

                    inputs = boxes.eq(num).parent().parent().find('input');
                    var inputs_count = inputs.size();
                    //alert(inputs_count);
                    for(i = 0; i < inputs_count; i++){
                        if(!inputs.eq(i).hasClass('chboxes'))
                            inputObj[inputs.eq(i).attr('name')] = inputs.eq(i).val();
                    }
                    inputArr[num] = inputObj;
                }
            }
            var out = JSON.stringify(inputArr);
        }else{
            for(i = 0; i < boxes.length; i++){
    			if(boxes[i].checked == true){
    				if(out != ''){
    					out = out + ';';
    				}
    				out = out + boxes[i].value;
    			}
    		}
        }

		res   =   {
		      'values': out,
		      'action': action
        };
		jQuery.ajax({
			'type':      'POST',
			'dataType':  'json',
			'data':      res,
			'url':       url,
			'success':function(data) {
				id = $('.grid-view').attr('id');
				$.fn.yiiGridView.update(id);
			}
		});
        return false;
	})
})