(function() {
    
    tinymce.create('tinymce.plugins.pixudio', {
        
        init : function( ed, url ) {

        ed.addCommand('hb_shortcode_generator', function() {
                
			tb_show("Shortcodes", url + '/../shortcode-generator.php?width=800&height=600');
        });
             
        ed.addButton('hb_shortcode_generator', {title : 'Add Custom Shortcode', cmd : 'hb_shortcode_generator', image : url + '/../img/shortcode-generator.png' });
    },
    
    createControl : function(n, cm) {
              return null;
    },
    
    getInfo : function() {
            return {
                longname : 'pixudio TinyMCE',
                author : 'pixudio',
                authorurl : 'http://pixudio.com',
                infourl : 'http://pixudio.com',
                version : tinymce.majorVersion + "." + tinymce.minorVersion
            };
        }
    });
    
    tinymce.PluginManager.add('hb_shortcode_generator', tinymce.plugins.pixudio);
    
})();