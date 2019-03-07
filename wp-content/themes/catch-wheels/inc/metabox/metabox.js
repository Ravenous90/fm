jQuery(document).ready(function(){
	jQuery("#catch-wheels-ui-tabs").tabs();

	jQuery('#catch-wheels-options_vid_gallery').insertAfter('#pageparentdiv');

	jQuery( function () {
		page_template_change(); //this calls it on load
		jQuery("select#page_template").change( page_template_change );
	});

	function page_template_change() {
		var template;

		template = jQuery('select#page_template').find(":selected").val();

		if ( 'templates/video-gallery.php' == template ) {
			jQuery('#catch-wheels-options_vid_gallery').slideDown();
		} else {
			jQuery('#catch-wheels-options_vid_gallery').slideUp();
		}
	}
});
