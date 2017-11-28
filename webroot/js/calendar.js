(function ($) {
    $(window).on('load', function () {
		setCalendarHeight();
    });

	$(window).on('resize', function(){
		setCalendarHeight();
			
	});

	function setCalendarHeight() {
        $('.calendar .container').each(function () {
            var heights = $(this).find('.day').map(function ()
            {
                return $(this).height();
            }).get(),
            maxHeight = Math.max.apply(null, heights);
            $(this).find('.day').height(maxHeight);
        })
	}
})(jQuery)
