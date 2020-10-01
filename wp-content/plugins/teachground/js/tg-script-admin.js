jQuery(function() {
 jQuery( "#lesson_list" ).sortable({
	items: '> div:not(.unsortable)'
 });
});
jQuery( function() {
	var dialog;
	function assignRule() {
	  var first_course_id = jQuery('#first_course_id').val();
	  var second_course_id = jQuery('#second_course_id').val();
	  jQuery.ajax({
		  method: "POST",
		  dataType:"json",
		  data: { option: 'assignRuleCourse', first_course_id: first_course_id, second_course_id: second_course_id }
	  })
	  .done(function( res ) {
		if( res.status == 'true' ){
			jQuery(res.data).appendTo( jQuery('#rules_list' ) );
			dialog.dialog( "close" );
		} else {
			alert(res.data);
		}
		return true;
	  });
	}
 
	dialog = jQuery( "#rules-assign-form" ).dialog({
	  autoOpen: false,
	  modal: true,
	  width: 500,
	  buttons: {
		"Assign Rule": assignRule,
		Cancel: function() {
		  dialog.dialog( "close" );
		}
	  }
	});
 
	jQuery( "#add_rules" ).on( "click", function() {
	  dialog.dialog( "open" );
	});
	
});

function removeRuleCourse( rm, r_id ){
	jQuery.ajax({
		  method: "POST",
		  data: { option: 'removeRuleCourse', r_id: r_id }
	  })
	  .done(function( data ) {
		if( data == 'removed' ){
			jQuery(rm).parent().remove();
		}
	  });
}

function toggelEmail(ch){
	if( jQuery('input[name="'+ch+'"]').attr('checked') ){
		jQuery('#div_'+ch).show();
	} else {
		jQuery('#div_'+ch).hide();
	}
}

function resourceHT(ch){
	if( jQuery(ch).attr('checked') ){
		jQuery(ch).siblings('input[name="resource_hts[]"]').val('yes');
	} else {
		jQuery(ch).siblings('input[name="resource_hts[]"]').val('no');
	}
}

jQuery(function() {
	var toggler = document.getElementsByClassName("caret");
	var i;
	for (i = 0; i < toggler.length; i++) {
	toggler[i].addEventListener("click", function() {
		this.parentElement.querySelector(".nested").classList.toggle("caret-active");
		this.classList.toggle("caret-down");
	});
	} 
});

function tgToggleView(th, selector){
	if(jQuery(th).is(":checked")){
		jQuery('#' + selector + '_settings').show();
	} else {
		jQuery('#' + selector + '_settings').hide();
	}
}

function forminatorTypeToggle(th){
	if( jQuery(th).val() == 'form'){
		jQuery('#forminator_form_settings').show();
		jQuery('#forminator_quiz_settings').hide();
	} else {
		jQuery('#forminator_form_settings').hide();
		jQuery('#forminator_quiz_settings').show();
	}
}

function toggle_video_percent_display(th, is_default){
	if(jQuery(th).is(":checked")){
		if(is_default=='true'){
			jQuery('#video_percent_by_lesson').hide();
			jQuery('#video_percent_by_course').show();
			jQuery('#video_minimum_percentage_1').attr('name', 'na');
		} else {
			jQuery('#video_percent_by_lesson').show();
			jQuery('#video_percent_by_course').hide();
			jQuery('#video_minimum_percentage_2').attr('name', 'na');
		}
	} else {
		jQuery('#video_percent_by_lesson').hide();
		jQuery('#video_percent_by_course').hide();
	}
}

jQuery(function(){
    jQuery(document).tooltip();
});