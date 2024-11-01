(function() {
    tinymce.create('tinymce.plugins.WPtopc', {
        init : function(ed, url) {
            ed.addButton('WPtopc', {
                title : 'Insert Titled Page Separator',
                image : url+'/images/WPtopc.png',
                onclick : function() {
					var first =  ed.getContent().search("<!--nextpage-->");
					if(first<0)
						var first_title = prompt("Section Title", "First page title");
						
					var section_title = prompt("Section Title", "New page title");
					if (section_title != null && section_title != 'undefined'){
                        ed.execCommand('mceInsertContent', 0, '<!--nextpage-->');
						ed.execCommand('mceInsertContent', false, "[section_title title="+section_title+"]<br/>");
						//ed.execCommand("mceRepaint");
						}
						
					if (first<0 && first_title != null && first_title != 'undefined')
						ed.setContent('[section_title title='+first_title+']'+ed.getContent());
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "WordPress Table of Paginated Contents Shortcode",
                author : 'Antonio Andrade',
                authorurl : 'http://AntonioAndra.de/',
                infourl : 'http://AntonioAndra.de/',
                version : "1.0"
            };
        }
    });
    tinymce.PluginManager.add('WPtopc', tinymce.plugins.WPtopc);
})();