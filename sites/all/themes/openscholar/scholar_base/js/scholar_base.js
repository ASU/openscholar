$.fn.vAlign = function(offset) {
	return this.each(function(i){
	var ah = $(this).height();
	var ph = $(this).parents('.wrap').height();
	var mh = Math.ceil((ph-ah) / 2) - offset;
	$(this).css('margin-top', mh);
	});
};

$(document).ready(function() {
  if ($("#header .hg-container").children().length > 1) {
    $('#header .box-os_boxes_modal_sitelogo').vAlign(10);
    $('#header #block-scholar_project-1').vAlign(10);
    $('#header #scholar-shield').vAlign(20);
  }
});