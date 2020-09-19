<?php if ( current_user_can('manage_options') || array_key_exists('debug', $_GET) ) : ?>
	<div class="simplesitespeedcon">
		<a class="totalsimplesitespeed" href="#">Total load time: <span class="pageloadtime">Calculating...</span></a>
		<div class="advancedsimplesitespeed">
			<p>Redirections: <span class="redirections">Unknown</span></p>
			<p>App Cache: <span class="appcachetime">Unknown</span></p>
			<p>Domain Lookup: <span class="dnstime">Unknown</span></p>
			<p>TCP: <span class="tcptime">Unknown</span></p>
			<p>Server Request: <span class="requesttime">Unknown</span></p>
			<p>Server Response: <span class="responsetime">Unknown</span></p>
			<p>DOM Load: <span class="domtime">Unknown</span></p>
			<p>onLoad: <span class="onloadtime">Unknown</span></p>
			<a class="simplesitespeedmoreinfo" href="http://gearsidecreative.com/simple-site-speed/?utm_source=wordpress&utm_medium=plugin&utm_campaign=simple%20site%20speed%20" target="_blank"><em>More Information &raquo;</em></a>
		</div>
	</div>
<?php endif; ?>