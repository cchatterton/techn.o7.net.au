<?php

function tnbench_global_callback($field){
	$selected = get_option('tnbench_forced', true);
	$selText = ($selected) ? ' checked="checked" ' : ' ';
	echo '<input type="checkbox" name="'.$field["id"].'" id="'.$field["id"].'" '.$selText.'>'."\n";
}
add_action('admin_init', 'tnbench_thumbnails_init');

function tnbench_thumbnails_init(){
	add_settings_section('tnbench_setting','','tnbench_setting_callback_function','reading');
	add_settings_field('tnbench_forced','Force TN Bench Stats','tnbench_global_callback','reading','tnbench_setting', array("id" => 'tnbench_forced',"desc" => 'Force TN Bench',"type" => 'checkbox'));
	register_setting('tnbench_settings_group', 'tnbench_forced');
}

function tnbench_setting_callback_function(){
	settings_fields("tnbench_settings_group");
}

function tnbench_start(){
	$GLOBALS['bench'] = new Ubench;
	$GLOBALS['bench']->start();
}

function tnbench_end(){

	$GLOBALS['bench']->end();
	$browser = explode('/', $_SERVER['HTTP_USER_AGENT']);

	echo '		<div data-alert class="tndata-wrapper">'."\n";
	echo '			<div>'."\n";
	echo '				<i class="fi-clock"></i>'."\n";
	echo '				<div>'.$GLOBALS['bench']->getTime().'</div>'."\n";
	echo '				<div>'.$GLOBALS['bench']->getTime(true).'</div>'."\n";
	echo '			</div>'."\n";
	echo '			<div>'."\n";
	echo '				<i class="fi-graph-bar"></i>'."\n";
	echo '				<div>Peak: '.$GLOBALS['bench']->getMemoryPeak().'</div>'."\n";
	echo '				<div>Usage: '.$GLOBALS['bench']->getMemoryUsage().'</div>'."\n";
	echo '			</div>'."\n";
	echo '			<div>'."\n";
	echo '				<i class="fi-monitor"></i>'."\n";
	echo '				<div>Width: <span id="verge-width"></span>px</div>'."\n";
	echo '				<div>Height: <span id="verge-height"></span>px</div>'."\n";
	echo '			</div>'."\n";
	echo '			<div id="browser">'."\n";
	echo '				<i class="fi-web"></i>'."\n";
	echo '				<div style="float: left;margin-top: 6px;">'.$browser[count($browser)-2].'/'.$browser[count($browser)-1].'</div>'."\n";
	echo '				<br><div style="white-space: nowrap;">'.$_SERVER['SCRIPT_FILENAME'].'</div>'."\n";
	echo '			</div>'."\n";
	echo '			<a href="#" class="close">&times;</a>'."\n";
	echo '		</div>'."\n\n";
	echo '		<script>'."\n";
	echo '		window.onresize=function(){'."\n";
	echo '		document.getElementById("verge-width").innerHTML = verge.viewportW();'."\n";
	echo '		document.getElementById("verge-height").innerHTML = verge.viewportH();'."\n";
	echo '		};'."\n";
	echo '		window.onload=function(){'."\n";
	echo '		document.getElementById("verge-width").innerHTML = verge.viewportW();'."\n";
	echo '		document.getElementById("verge-height").innerHTML = verge.viewportH();'."\n";
	echo '		};'."\n";
	echo '		</script>'."\n";

}

?>