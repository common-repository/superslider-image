tinyMCEPopup.requireLangPack();

var ssImageDialog = {
	init : function() {
		//var f = document.forms[0];
		// Get the selected contents as text and place it in the input
		//f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		//f.somearg.value = tinyMCEPopup.getWindowArg('some_custom_arg');
	},
	
	insert : function() {
		var t = this, f = document.forms[0], ed = tinyMCEPopup.editor, el, b, html, caption;
		tinyMCEPopup.restoreSelection();
		
		var order, orderby, align, size, image_link, link_type, caption, lightbox, limit, image_frame, random, random_cat, image_class, link_class, image_id ;

		if ( f.order.value != '' ) {
			order= ' order="'+f.order.value+'"';			
		}else{order='';}
		if ( f.orderby.value != '' ) {
			orderby= ' orderby="'+f.orderby.value+'"';			
		}else{orderby='';}
		var x = document.getElementsByName('align')
        for(var k=0;k<x.length;k++)
          if(x[k].checked){
            align= ' align="'+x[k].value+'"';
          }
		if ( f.size.value != '' ) {
			size= ' size="'+f.size.value+'"';			
		}else{size='';}
		if ( f.image_link.checked == true ) {
			image_link= ' image_link="on"';			
		}else{image_link='';}
		if ( f.link_type.value != '' ) {
			link_type= ' link_type="'+f.link_type.value+'"';		
		}else{link_type='';}
		if ( f.caption.checked == true ) {
			caption= ' caption="on"';			
		}else{caption='';}
		if ( f.lightbox.checked == true) {
			lightbox= ' lightbox="on"';			
		}else{lightbox='';}
		if ( f.limit.value != '' ) {
			limit= ' limit="'+f.limit.value+'"';			
		}else{limit='';}
		if ( f.image_frame.checked == true ) {
			image_frame= ' image_frame="on"';			
		}else{image_frame='';}
		if ( f.random.checked == true ) {
			random= ' random="on"';			
		}else{random='';}
		if ( f.random_cat.checked == true ) {
			random_cat= ' random_cat="on"';			
		}else{random_cat='';}
		if ( f.image_class.value != '' ) {
			image_class= ' image_class="'+f.image_class.value+'"';			
		}else{image_class='';}
		if ( f.link_class.value != '' ) {
			link_class= ' link_class="'+f.link_class.value+'"';			
		}else{link_class='';}
		if ( f.image_id.value != '' ) {
			image_id= ' image_id="'+f.image_id.value+'"';			
		}else{image_id='';}

		tinyMCEPopup.execCommand("mceBeginUndoLevel");
		
		// [image order="ASC/DSC" orderby="menu_order" align="left/center/right" size="thumbnail/medium/large" image_link="on" link_type="large" caption="on" lightbox="on" limit="@" image_frame="on" random="on" random_cat="on" image_class="yourclass" link_class="yourlinkclass" image_id="100,101,102"]
		html = '[image  '+order+' '+orderby+' '+align+' '+size+' '+image_link+' '+link_type+' '+caption+''+lightbox+''+limit+' '+image_frame+' '+random+' '+random_cat+' '+image_class+' '+link_class+''+image_id+' ]';

		//cap = ed.dom.create('div', {'class': div_cls}, html);
		//P = ed.dom.create('p', {}, html);
		
		//P.parentNode.insertBefore(html, P);
		
		tinyMCE.execCommand('mceInsertContent',false,html);

		tinyMCEPopup.execCommand("mceEndUndoLevel");
		ed.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(ssImageDialog.init, ssImageDialog);