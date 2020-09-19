jQuery.noConflict();

jQuery(document).ready(function() {

	//Hide/Show Admin Timing
	jQuery('.totalsimplesitespeed').on('click', function(){
		jQuery('.advancedsimplesitespeed').slideToggle();
		return false;
	});

}); //End Document Ready

jQuery(window).on('load', function() {	

	//Admin Timing
	setTimeout(function(){
		var pageLoadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
		var redirectionTime = performance.timing.redirectEnd - performance.timing.redirectStart;
		var appCacheTime = performance.timing.domainLookupStart - performance.timing.fetchStart;
		var dnsTime = performance.timing.domainLookupEnd - performance.timing.domainLookupStart;
		var tcpTime = performance.timing.connectEnd - performance.timing.connectStart;
		var requestTime = performance.timing.responseStart - performance.timing.requestStart;
		var responseTime = performance.timing.responseEnd - performance.timing.responseStart;
		var domTime = performance.timing.domComplete - performance.timing.domLoading;
		var onLoadTime = performance.timing.loadEventEnd - performance.timing.loadEventStart;
		
		jQuery('.pageloadtime').text(pageLoadTime/1000 + 's');
		if ( performance.navigation.redirectCount == 0 ) {
			jQuery('.redirections').text('0');
		} else {
			jQuery('.redirections').text(performance.navigation.redirectCount + ' @ ' + redirectionTime/1000 + 's');
		}
		jQuery('.appcachetime').text(appCacheTime/1000 + 's');
		jQuery('.dnstime').text(dnsTime/1000 + 's');
		jQuery('.tcptime').text(tcpTime/1000 + 's');
		jQuery('.requesttime').text(requestTime/1000 + 's');
		jQuery('.responsetime').text(responseTime/1000 + 's');
		jQuery('.domtime').text(domTime/1000 + 's');
		jQuery('.onloadtime').text(onLoadTime/1000 + 's');
		
		if ( pageLoadTime > 8000 ) {
			jQuery('.pageloadtime').css('color', 'red');
		} else if ( pageLoadTime < 4000 ) {
			jQuery('.pageloadtime').css('color', 'green');
		}
		if ( requestTime > 1000 ) {
			jQuery('.requesttime').css('color', 'red');
		} else if ( requestTime < 400 ) {
			jQuery('.requesttime').css('color', 'green');
		}		
	}, 0);

});