(function(tinymce){tinymce.PluginManager.requireLangPack('ss_image');tinymce.create('tinymce.plugins.SSImage',{init:function(ed,url){ed.addCommand('mcessImage',function(){ed.windowManager.open({file:url+'/ss_image_tinymce.php',width:400+parseInt(ed.getLang('ss_image.delta_width',0)),height:450+parseInt(ed.getLang('ss_image.delta_height',0)),inline:1},{plugin_url:url,some_custom_arg:'custom arg'})});ed.addButton('ss_image',{title:'superslider image',cmd:'mcessImage',image:url+'/img/ss-image-icon.png'})},getInfo:function(){return{longname:'SuperSlider Image',author:'Daiv Mowbray',authorurl:'http://superslider.daivmowbray.com',infourl:'http://superslider.daivmowbray.com',version:tinymce.majorVersion+'.'+tinymce.minorVersion}}});tinymce.PluginManager.add('ss_image',tinymce.plugins.SSImage)})(tinymce);