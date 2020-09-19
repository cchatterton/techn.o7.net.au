jQuery( document ).ready( function( $ ) { 

	//custom script goes here

	/*
	 * Toggle full screen popup search.
	 */

	$( '.menu-search-popup > a, .search-popup-close, .btn-menu-search' ).on( 'click', function( e ) {
		e.preventDefault();
		$('body').toggleClass('search-popup-open');
		var search_popup = $( '.search-popup' );
		search_popup.fadeToggle( function() {
			search_popup.find( 'input' ).focus();
		} );
	} );

	/* Toggle menu */
	$( '.nav-toggle' ).on('click', function(){
		$('body').toggleClass('offcanvas-menu-open');
		setToggleMenuState();
	});

	$('.site-offcanvas .sub-menu').collapse({
		toggle: true
	});
	
	function setToggleMenuState(){
		if( $(window).width() <= 767.98 ) {
			$('.site-offcanvas .sub-menu').collapse('hide');
			$('.menu-item-has-children').removeClass('expanded');
		} else {
			$('.site-offcanvas .sub-menu').collapse('show');
		}
	}
	
	$( window ).resize(function(){        
		setToggleMenuState();
	});

	var menuPointer = "<i class='sub-menu-pointer far fa-angle-down'></i>";
	$('.site-offcanvas .menu > .menu-item').each(function(i, e){
		if ( $(this).find('ul').length ) {
			$(this).prepend(menuPointer);
		}
	})
	
	$('.site-offcanvas .sub-menu-pointer').on('click', function(){
		$(this).parent().toggleClass('expanded');
		$(this).parent().find('.sub-menu').collapse('toggle');
	})

	let linkIcon = tags_links_icon.links_icon,
		tagIcon = tags_links_icon.tags_icon,
		iconTargets = [ '.tags', '.tag', '.links', '.link' ];

	iconTargets.forEach(iconTarget => {
		let target = $('.site-container').find(iconTarget);

		if(target.length > 0) {
			if(iconTarget == '.tag')
				$(target.selector).prepend(tagIcon);
			if(iconTarget == '.link')
				$(target.selector).prepend(linkIcon);
			if(iconTarget == '.tags')
				$(`${target.selector} a`).prepend(tagIcon);
			if(iconTarget == '.links')
				$(`${target.selector} a`).prepend(linkIcon);
		}
	});

});