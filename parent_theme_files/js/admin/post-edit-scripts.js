jQuery(document).ready(function($) {

	if ($.isFunction($.fn.datepicker)) {
		$( "#ci_cpt_gallery_date" ).datepicker({
			dateFormat: 'yy-mm-dd'
		});

		$( "#ci_cpt_video_date" ).datepicker({
			dateFormat: 'yy-mm-dd'
		});

	}


	// Repeating fields
	_sortable();

	var repeating_fields = $('.ci-repeating-fields');
	repeating_fields.each(function(){
		var add_field = $(this).find('.ci-repeating-add-field');
		add_field.click(function(){
			var repeatable_area = $(this).siblings('.inner');
			var fields = repeatable_area.children('.field-prototype').clone(true).removeClass('field-prototype').removeAttr('style').appendTo(repeatable_area);
			return false;
		});
	});

	$('body').on('click', '.ci-repeating-remove-field', function() {
		var field = $(this).parents('.post-field');
		field.remove();
		return false;
	});

});

_sortable = function() {
	jQuery('.ci-repeating-fields .inner').sortable({ placeholder: 'ui-state-highlight' });
};