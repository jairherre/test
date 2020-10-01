(function ( $ ) {
    $('.wp-has-current-submenu').removeClass('wp-has-current-submenu');
	$('.toplevel_page_lms_settings').removeClass('wp-not-current-submenu').addClass('wp-has-current-submenu wp-menu-open');
	$('.toplevel_page_lms_settings ul li:nth-child(5)').addClass('current');
}(jQuery));