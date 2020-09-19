(function($) {
	$(function() {
		let configs = wfc_sticky; console.log(configs);

		let adminBar = $('body').find('#wpadminbar');
		let enableMobile = configs.enableMobile == 1 ? true : false;
		let enableDesktop = configs.enableDesktop == 1 ? true : false;
		let enableTablet = configs.enableTablet == 1 ? true : false;
		let targetElem = configs.targetElem; console.log(targetElem);
		let targetElemArr = targetElem.split(","); 
		
		function initialize_sticky() {
			
			let marginTop = adminBar.length > 0 ? adminBar.height() : 0;
			let stickyOffset = marginTop;
			let screenWidth = window.innerWidth;
			let mobile = ( enableMobile && screenWidth < 768 );
			let tablet = ( enableTablet && ( screenWidth >= 768 && screenWidth < 992 ) );
			let desktop = ( enableDesktop && screenWidth >= 992 );
			
			console.log({mobile, tablet, desktop});
			
			if ( mobile || tablet || desktop  ) {
				
				if ( screenWidth <= 600 ) {
					stickyOffset = 0;
				}
				
				for (var s of targetElemArr) {
					$(s).sticky({ topSpacing: stickyOffset });
					$(s).css('overflow', 'auto');
					stickyOffset += $(s).outerHeight(true);
				}
			
			} else {
				
				for (var s of targetElemArr) {
					$(s).unstick();
				}
				
			}
			
		}
		
		$(window).on('resize', function() {
			initialize_sticky();
		});

		initialize_sticky();
		
	});
	
})(jQuery);