<?php
//Dynamically add js and css files to footer page

$all_js = array('custom.js');

function add_js($file = '')
{
  $str = '';

  if (empty($file)) {
    return;
  }

  if (is_array($file)) {
    if (!is_array($file) && count($file) <= 0) {
      return;
    }
    foreach ($file as $item) {
      $header_js[] = $item;
    }
    $all_js = ;
  } else {
    $str = $file;
    $header_js[] = $str;
    $ci->config->set_item('header_js', $header_js);
  }
}

//Dynamically add CSS files to header page
function add_css($file = '')
{
  $str = '';
  $ci = &get_instance();
  $header_css = $ci->config->item('header_css');

  if (empty($file)) {
    return;
  }

  if (is_array($file)) {
    if (!is_array($file) && count($file) <= 0) {
      return;
    }
    foreach ($file as $item) {
      $header_css[] = $item;
    }
    $ci->config->set_item('header_css', $header_css);
  } else {
    $str = $file;
    $header_css[] = $str;
    $ci->config->set_item('header_css', $header_css);
  }
}


function put_dynamic_js()
{
  $str = '';
  $all_js  = array('custom.js');

  foreach ($all_js as $single_js) {
    $str .= '<script type="text/javascript" src="' . base_url() . 'assets/js/' . $single_js . '"></script>' . "\n";
  }

  return $str;
}

function put_dynamic_css()
{
  $str = '';
  $all_css = array('main.css');

  foreach ($header_css as $item) {
    $str .= '<link rel="stylesheet" href="' . base_url() . 'assets/css/' . $item . '" type="text/css" />' . "\n";
  }
  return $str;
}
