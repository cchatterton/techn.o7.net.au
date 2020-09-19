<?php

function show($value,$next=''){
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
  if ($next != 'live') die();
}

function div($class='',$style='',$args='') {
  if (is_array($args)) extract($args);
  $api = '<div ';
  $api.= ($id!= '') ? 'id="'.$id.'" ' : '';
  $api.= ($class!= '') ? 'class="'.$class.'" ' : '';
  $api.= ($style != '') ? 'style="'.$style.'" ' : '';
  $location = "location.href='$onclick';";
  $api.= ($onclick!= '') ? 'onclick="'.$location.'"' : '';
  $api.= '>'."\n";
  return $api;
}

function xdiv($repeat=1){
  for ($i = 1; $i <= $repeat; $i++) $api .= '</div>'."\n";
  return $api;
}

function lov($string,$delimiter=',',$before='<li>',$after='</li>'){
  $lov = explode($delimiter, $string);
  foreach($lov as $v) {
    $api.=$before.$v.$after;
  }
  return $api;
}

function row($class='',$style='',$args='') {
  $class = ($class!='') ? 'row '.$class : 'row';
  $api = div($class,$style,$args);
  return $api;
}

function col($class='',$style='',$args='') {
  $class = ($class!='') ? 'columns '.$class : 'columns';
  $api = div($class,$style,$args);
  return $api;
}

?>