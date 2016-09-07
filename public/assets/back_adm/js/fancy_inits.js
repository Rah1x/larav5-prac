$(document).ready(function() {

    $(".fbox").fancybox({
	    minWidth    : 550,
	    minHeight   : 50,
		maxWidth	: 950,
		maxHeight	: 600,
		autoSize	: true,
        fitToView	: false,
        openEffect	: 'elastic',
		closeEffect	: 'elastic',

        prevEffect	: 'none',
		nextEffect	: 'none',
        helpers	: {
			buttons	: {}
		}
	});

    $(".fbox2").fancybox({
	    minWidth    : 550,
	    minHeight   : 5,
		maxWidth	: 550,
		maxHeight	: 650,
		autoSize	: true,
        fitToView	: true,
        openEffect	: 'elastic',
		closeEffect	: 'elastic',

        afterClose: function(){
            $.specialClick=0;
        },
	});

    $(".fbox_img").fancybox({
		minHeight   : 5,
		minWidth    : 5,
        maxWidth	: 950,
		maxHeight	: 600,
		autoSize	: true,
        fitToView	: false,
        openEffect	: 'elastic',
		closeEffect	: 'elastic',
	});


});