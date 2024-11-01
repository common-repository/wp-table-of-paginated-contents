jQuery(document).ready(function(){
	collapseSections();
	function collapseSections(){
		jQuery("#wptopc-main .wptopc-inputs,.wptopc-section-title a").not(".wptopc-inputs:first").hide();
		jQuery(".handlediv").fadeOut(0);
		jQuery("#wptopc-main .wptopc-section").hover(
			function(){
				jQuery(this).find(".handlediv").fadeIn(150);
				},
			function(){
				jQuery(this).find(".handlediv").fadeOut(150);
				}
			)
		jQuery("#wptopc-main .wptopc-section:not(.permanently-open) .wptopc-section-title h3").click(
			function(){
				if(jQuery(this).parent().find("a")){
					jQuery(this).parent().find("a").toggle();
					}
				jQuery(this).parent().next(".wptopc-inputs").toggle();
				}
			);
		}
	});