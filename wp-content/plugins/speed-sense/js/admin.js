function speedsense_rate_frontend() {
	jQuery(document).ready(function($) {
		var data = {
			'action': 'rate_close',
			'whatever': 1234
		};
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
//			alert('Got this from the server: ' + response);
            jQuery("#ratemessage").hide();
		});
	});
}