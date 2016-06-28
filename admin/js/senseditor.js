var rows_last = 10,
	row_height = 16;


$('.senstextarea textarea').keypress(function() {
	if(rows_last != (this.scrollHeight/row_height)){
		$(this).attr('rows',(this.scrollHeight/row_height));
		rows_last = this.scrollHeight/row_height;
	}
});

$('.senspanel2 .sensbuttons #showhide').click(function() {
	var sensarea = $(this).parent().parent().prev().children(0);


	if(rows_last < (sensarea[0].scrollHeight/row_height)){
		$(sensarea[0]).attr('rows',(sensarea[0].scrollHeight/row_height));
		rows_last = sensarea[0].scrollHeight/row_height;
	}else{
		$(sensarea[0]).attr('rows',10);
		rows_last = 10;
	}

});


$('.senspanel select#h').change(function() {
	sensEditor.insertTagFromDropBox(this);
});


$('.senspanel .sensbuttons #ol').click(function() {
	sensEditor.insertList(this);
});
$('.senspanel .sensbuttons #ul').click(function() {
	sensEditor.insertList(this);
});


$('.senspanel .sensbuttons #b').click(function() {
	sensEditor.insertTagWithText(this, 'strong');
});

$('.senspanel .sensbuttons #i').click(function() {
	sensEditor.insertTagWithText(this, 'i');
});

$('.senspanel .sensbuttons #u').click(function() {
	sensEditor.insertTagWithText(this, 'u');
});

$('.senspanel .sensbuttons #s').click(function() {
	sensEditor.insertTagWithText(this, 's');
});


$('.senspanel .sensbuttons #link').click(function() {
	sensEditor.insertLink(this);
});

$('.senspanel .sensbuttons #img').click(function() {
	sensEditor.insertImage(this);
});





//onchange="sensEditor.insertTagFromDropBox(this);"

sensEditor = {

	insertTagWithText: function (link, tagName){
		var startTag = '<' + tagName + '>';
		var endTag = '</' + tagName + '>';
		sensEditor.insertTag(link, startTag, endTag);
		return false;
	},

	insertImage: function(link){
		var src = prompt('Введите src картинки', 'http://');
		if(src){
			sensEditor.insertTag(link, '<img src="' + src + '" alt="image"/>', '');
		}
		return false;
	},

	insertLink: function(link){
		var href = prompt('Введите URL ссылки', 'http://');
		if(href){
			sensEditor.insertTag(link, '<a href="' + href + '">', '</a>');
		}
		return false;
	},

	insertTag: function(link, startTag, endTag, repObj){
			var textareaParent = $(link).parents('.senseditor');

			var textarea = $('textarea',textareaParent).get(0);
			textarea.focus();

			var scrtop = textarea.scrollTop;

			var cursorPos = sensEditor.getCursor(textarea);
			var txt_pre = textarea.value.substring(0, cursorPos.start);
			var txt_sel = textarea.value.substring(cursorPos.start, cursorPos.end);
			var txt_aft = textarea.value.substring(cursorPos.end);

			if(repObj){
				txt_sel = txt_sel.replace(/\r/g, '');
				txt_sel = txt_sel != '' ? txt_sel : ' ';
				txt_sel = txt_sel.replace(new RegExp(repObj.findStr, 'gm'), repObj.repStr);
			}

			if (cursorPos.start == cursorPos.end){
				var nuCursorPos = cursorPos.start + startTag.length;
			}else{
				var nuCursorPos=String(txt_pre + startTag + txt_sel + endTag).length;
			}

			textarea.value = txt_pre + startTag + txt_sel + endTag + txt_aft;

			sensEditor.setCursor(textarea, nuCursorPos, nuCursorPos);

			if (scrtop) textarea.scrollTop = scrtop;

			return false;
	},

	insertTagFromDropBox: function(link){
			sensEditor.insertTagWithText(link, link.value);
			link.selectedIndex = 0;
	},


	insertList: function(link){

			var startTag = '<' + $(link).attr('id') + '>\n';
			var endTag = '\n</' + $(link).attr('id') + '>';

			var repObj = {
				findStr: '^(.+)',
				repStr: '\t<li>$1</li>'
			};

			sensEditor.insertTag(link, startTag, endTag, repObj);

			link.selectedIndex = 0;
	},

	insertTab: function(e, textarea){
			if(!e) e = window.event;
			if (e.keyCode) var keyCode = e.keyCode;
			else if (e.which) var keyCode = e.which;

			//alert(keyCode);
			switch(e.type){
				case 'keydown':
					if(keyCode == 16){
						sensEditor.shift = true;
						//alert('1');
					}
					break;

				case 'keyup':
					if(keyCode == 16) {
						sensEditor.shift = false;
						//alert('2');
					}

					break;
			}

			textarea.focus();
			var cursorPos = sensEditor.getCursor(textarea);

			if (cursorPos.start == cursorPos.end){
				return true;


			} else if(keyCode == 9 && !sensEditor.shift){
				var repObj = {
					findStr: '^(.+)',
					repStr: '\t$1'
				};
				sensEditor.insertTag(textarea, '', '', repObj);
				return false;

			} else if(keyCode == 9 && sensEditor.shift){
				var repObj = {
					findStr: '^\t(.+)',
					repStr: '$1'
				};
				sensEditor.insertTag(textarea, '', '', repObj);
				return false;
			}
	},

	getCursor: function(input){
			var result = {start: 0, end: 0};
			if (input.setSelectionRange){
				result.start= input.selectionStart;
				result.end = input.selectionEnd;
			} else if (!document.selection) {
				return false;
			} else if (document.selection && document.selection.createRange) {
				var range = document.selection.createRange();
				var stored_range = range.duplicate();
				stored_range.moveToElementText(input);
				stored_range.setEndPoint('EndToEnd', range);
				result.start = stored_range.text.length - range.text.length;
				result.end = result.start + range.text.length;
			}
			return result;
	},

	setCursor: function(textarea, start, end){
			if(textarea.createTextRange) {
				var range = textarea.createTextRange();
				range.move("character", start);
				range.select();
			} else if(textarea.selectionStart) {
				textarea.setSelectionRange(start, end);
			}
	}

};

