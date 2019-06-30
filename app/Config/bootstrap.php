<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

/**
 * Global User-Defined Functions
 */
function fam_list_link($fam = null, $gen = null) {
  if (!$fam) { return null; }
  if (trim(strtolower($fam)) == "salticidae") { return null; }
  if (trim(strtolower($fam)) == "linyphiidae") {
    if (!$gen) { return "Lists of Linyphiidae species"; }
    if (in_array(strtolower(substr(trim($gen), 0, 1)), ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'])) {
      return "List of Linyphiidae species (A–H)";
    }
    if (in_array(strtolower(substr(trim($gen), 0, 1)), ['i', 'j', 'k', 'l', 'm', 'n', 'o', 'p'])) {
      return "List of Linyphiidae species (I–P)";
    }
    return "List of Linyphiidae species (Q–Z)";
  }
  if (trim(strtolower($fam)) == "araneidae") {
    if (!$gen) { return "List of Araneidae species"; }
    if (strtolower(substr(trim($gen), 0, 1)) == 'a') {
      return "List of Araneidae species: A";
    }
    if (in_array(strtolower(substr(trim($gen), 0, 1)), ['b', 'c', 'd', 'e', 'f'])) {
      return "List of Araneidae species: B-F";
    }
    if (in_array(strtolower(substr(trim($gen), 0, 1)), ['g', 'h', 'i', 'j', 'k', 'l', 'm'])) {
      return "List of Araneidae species: G-M";
    }
    return "List of Araneidae species: N-Z";
  }
  return "List of " . ucfirst(trim(strtolower($fam))) . " species";
}

function spellnumber($x,$min=0,$max=100) {
  if (!preg_match('/^-?([0-9]{1,15})(\.[0-9]+)?$/',$x)) { return $x; } //if not a number less than a quadrillion, leave it alone
  elseif (strpos($x,'.') !== false) { list($int,$dec) = explode('.',$x); return number_format($int).'.'.$dec; } //if not an intenger
  elseif (($min !== false) && ($x < $min)) { return number_format($x); } //return numeral if less than minimum
  elseif (($max !== false) && ($x > $max)) { return number_format($x); } //return numeral if greater than maximum
  
  if ($x < 0) { $w = 'negative '; $x = abs($x); } else { $w = ''; } //check to see if it's negative

  if ($x < 20) { return $w.spellnumber_under20($x); } //shortcut for small numbers

  $d = str_split($x); //explode the number into an array of single digits
  $d = array_reverse($d); //reverse so that we can work from the right
  
  //trillions
  if (array_key_exists('12',$d)) {
    $t = floor($x/1000000000000);
    if ($t > 0) { $w .= spellnumber($t,0,999).' trillion '; }
    $x = $x - ($t * 1000000000000);
  }

  //billions
  if (array_key_exists('9',$d)) {
    $t = floor($x/1000000000);
    if ($t > 0) { $w .= spellnumber($t,0,999).' billion '; }
    $x = $x - ($t * 1000000000);
  }
  
  //millions
  if (array_key_exists('6',$d)) {
    $t = floor($x/1000000);
    if ($t > 0) { $w .= spellnumber($t,0,999).' million '; }
    $x = $x - ($t * 1000000);
  }

  //thousands
  if (array_key_exists('3',$d)) {
    $t = floor($x/1000);
    if ($t > 0) { $w .= spellnumber($t,0,999).' thousand '; }
  }

  //third-to-last digit
  if (array_key_exists('2',$d)) {
    if ($d['2'] == 1) { $w .= 'one hundred '; }
    elseif ($d['2'] == 2) { $w .= 'two hundred '; }
    elseif ($d['2'] == 3) { $w .= 'three hundred '; }
    elseif ($d['2'] == 4) { $w .= 'four hundred '; }
    elseif ($d['2'] == 5) { $w .= 'five hundred '; }
    elseif ($d['2'] == 6) { $w .= 'six hundred '; }
    elseif ($d['2'] == 7) { $w .= 'seven hundred '; }
    elseif ($d['2'] == 8) { $w .= 'eight hundred '; }
    elseif ($d['2'] == 9) { $w .= 'nine hundred '; }
  }

  $last2 = round($d['1'].$d['0']); //combine the last 2 digits and handle them together
  if ($last2 < 20) {
    if ($last2 > 0) { $w .= spellnumber_under20($last2); }
  } else {
    //second-to-last digit
    if ($d['1'] == 2) { $w .= 'twenty'; }
    elseif ($d['1'] == 3) { $w .= 'thirty'; }
    elseif ($d['1'] == 4) { $w .= 'forty'; }
    elseif ($d['1'] == 5) { $w .= 'fifty'; }
    elseif ($d['1'] == 6) { $w .= 'sixty'; }
    elseif ($d['1'] == 7) { $w .= 'seventy'; }
    elseif ($d['1'] == 8) { $w .= 'eighty'; }
    elseif ($d['1'] == 9) { $w .= 'ninety'; }

    //last digit
    if ($d['0'] != 0) {
      if ($d['1'] >= 2) { $w .= '-'; } //if 20 or more
      $w .= spellnumber_under20($d['0']);
    }
  }
  return $w;
}

//this next function does not have any input verification. it should only be called from within the main spellnumber function
function spellnumber_under20($x) {
  switch($x) {
    case 0; return 'zero';
    case 1; return 'one';
    case 2; return 'two';
    case 3; return 'three';
    case 4; return 'four';
    case 5; return 'five';
    case 6; return 'six';
    case 7; return 'seven';
    case 8; return 'eight';
    case 9; return 'nine';
    case 10; return 'ten';
    case 11; return 'eleven';
    case 12; return 'twelve';
    case 13; return 'thirteen';
    case 14; return 'fourteen';
    case 15; return 'fifteen';
    case 16; return 'sixteen';
    case 17; return 'seventeen';
    case 18; return 'eighteen';
    case 19; return 'nineteen';
  }
  return $x; //just in case
}

function get_html($url){
  ini_set('max_execution_time', 100);
  $c = curl_init($url);
  curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($c, CURLOPT_AUTOREFERER, true);
  curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
  $html = curl_exec($c);
  if (curl_error($c))
    die(curl_error($c));
  curl_close($c);
  return $html;
}

function build_taxobox($arr = []) {
  $result = "";
  if (array_key_exists('header', $arr)) { $result .= $arr['header']; }
  if (array_key_exists('keys', $arr) && is_array($arr['keys'])) {
    foreach($arr['keys'] as $key=>$val) {
      if ($val) {
        $result .= "\n| " . $key . " = " . $val;
      }
    }
  }
  return ((array_key_exists('footer', $arr)) ? ($result . $arr['footer']) : $result);
}

function remove_tags($str){
  foreach(get_all_matches($str,'/(<[\s\S]*>)/U') as $val) //html markups "<a href=>hi</a>"
    $str = substr($str,0,strpos($str,$val[1])).substr($str,strpos($str,$val[1])+strlen($val[1]));
  foreach(get_all_matches($str,'/(\[[0-9]*\])/U') as $val) //wiki references "[3]"
    $str = substr($str,0,strpos($str,$val[1])).substr($str,strpos($str,$val[1])+strlen($val[1]));
  return $str;
}

function wiki_table_convert($url,$from=null,$to=null){
  $html = get_html($url);
  $results = array();
  if ($from != null)
    $html = substr($html,strpos($html,$from));
  if ($to != null)
    $html = substr($html,0,strpos($html,$to));
  $cols = get_all_matches($html,'/<th[\s\S]*>([\s\S]*)<\/th>/U');
  foreach(get_all_matches($html,'/<tr[\s\S]*>([\s\S]*)<\/tr>/U') as $val){
    $x = array();
    foreach(get_all_matches($val[1],'/<td[\s\S]*>([\s\S]*)<\/td>/U') as $key=>$wal){
      $x[$cols[$key][1]] = remove_tags($wal[1]);
    }
    array_push($results,$x);
  }
  return $results;
}

function get_list($url_list,$regex,$include_html=false,$from=null,$to=null){
  $urls = (is_array($url_list))?$url_list:array(0=>$url_list);
  $results = array('urls'=>$url_list,'regex'=>$regex,'results'=>array());
  foreach($urls as $url){
    $html = get_html($url);
    
    debug($url);
    
    if ($from != null)
      $html = substr($html,strpos($html,$from));
    if ($to != null)
      $html = substr($html,0,strpos($html,$to));
    $results['html'] = ($include_html)?$html:NULL;
    foreach(get_all_matches($html,$regex) as $val){
      array_push($results['results'],$val);
    }
  }
  return $results;
}

function get_list_x($url_list,$regex,$include_html=false,$from=null,$to=null){
  $results = array('urls'=>$url_list,'regex'=>$regex,'results'=>array());
  $html = get_stuff();
  if ($from != null)
    $html = substr($html,strpos($html,$from));
  if ($to != null)
    $html = substr($html,0,strpos($html,$to));
  $results['html'] = ($include_html)?$html:NULL;
  foreach(get_all_matches($html,$regex) as $val){
    array_push($results['results'],$val);
  }
  return $results;
}

// Find first regex match in html source code
function get_first_match($html, $regex){
  if(preg_match($regex, $html, $regs)){
    if(isset($regs[2])) {
      return $regs; // multiple capture groups
    } else {
      return $regs[1];
    }
  }
  return false;
}

// Used to find ALL occurrences, not just the first one
function get_all_matches($html, $regex){
  preg_match_all($regex, $html, $result, PREG_PATTERN_ORDER);
  $matches = array();
  
  for ($i = 0; $i < count($result[0]); $i++) {
    $match = array();
    for ($j = 1; $j < count($result); $j++) {
      $match[$j] = $result[$j][$i];
    } 
    $matches[] = $match;
  }
  
  return $matches;
}

function search_friendly($str){
  return preg_replace("/[^a-zA-Z]+/","",explode(" ",$str)[0]);
}

function parse_ref($ref = "", $return_all = true, $pages = null) {
  $result = [];
  $is_citation = (strpos($ref, 'In:') !== false);
  $is_journal = ((strpos($ref, 'pp.') === false) && (strpos($ref, ":") !== false) && !$is_citation);

  // Simon's Natural History of Spiders
  if (strpos($ref, "Histoire naturelle des araignées") !== false) {
    $s_year = get_first_match($ref, '/(\d{4})/');
    $result = array(
      'name' => "Simo" . $s_year,
      'last' => "Simon", 'first' => "E.", 'year' => $s_year,
      'doi' => "10.5962/bhl.title." . ((intval($s_year) > 1864) ? "51973" : "47654"),
      'publisher' => "Roret", 'publication-place' => "Paris",
      'title' => "Histoire naturelle des araignées" . ((intval($s_year) > 1864) ? "" : " (aranéides)"),
      'ref' => "<ref name=Simo" . $s_year . ">{{cite book| last=Simon| first=E| year=" . $s_year .
        "| title=Histoire naturelle des araignées" . ((intval($s_year) > 1864) ? "" : " (aranéides)") .
        "| publisher=Roret | publication-place=Paris" .
        "| doi=" . "10.5962/bhl.title." . ((intval($s_year) > 1864) ? "51973" : "47654")
    );
    if (intval($s_year) == 1864) {
      $result['url'] = "https://archive.org/stream/histoirenaturell00sim";
      $result['ref'] .= "| ref=" . "https://archive.org/stream/histoirenaturell00sim";
    }
    $result['ref'] .= "}}</ref>";
    return (($return_all) ? $result : $result['ref']);
  }

  // DOI
  $doi = get_first_match($ref, '/doi\:([^\s]+)\s/');

  // Remove anything in brackets
  $url = '';
  while ($tmp_u = get_first_match($ref, '/\[([^\s]+)\s[\s\S]*\]/')) {
    if (strlen($url) == 0 && strpos($tmp_u, "://") !== false) { $url = $tmp_u; }
    $ref = str_replace(get_first_match($ref, '/(\[[^\s]+\s[\s\S]*\])/'), '', $ref);
  }
  $ref = trim($ref);

  // Name and year
  if (!$tmp = get_first_match($ref, '/[\s]*(\S[\s\S]*)\([\S]*(\d{4})[\S]*\)\./U')) {
    $tmp = get_first_match($ref, '/[\s\*]*([^\s\*][\s\S]*)[\S]*(\d{4})[\S]*\./U');
  }
  if (strpos($tmp[1], ',') === false) {
    $tmp[1] = str_replace(" ", ",", trim($tmp[1]));
  }
  $auths = explode(",", str_replace("&", ",", str_replace(",,", ",", str_replace(' and ', ',', $tmp[1]))));
  if (count($auths) == 2 || count($auths) > 6) {
    $result['last'] = trim($auths[0]);
    $result['first'] = trim($auths[1]);
    if (count($auths) > 6) {
      $result['display-authors'] = "etal";
    }
  } else {
    for($x = 0; $x < count($auths); $x += 2) {
      $result['last' . (((($x / 2) + 1) == 1) ? "" : (($x / 2) + 1))] = trim($auths[$x]);
      $result['first' . (((($x / 2) + 1) == 1) ? "" : (($x / 2) + 1))] = trim($auths[($x + 1)]);
    }
  }
  $result['year'] = trim($tmp[2]);
  $ref = trim(str_replace($tmp[0], "", $ref));

  // Citation
  if ($is_citation) {
    $tmp = explode("In:", $ref);
    $result['contribution'] = trim($tmp[0], " .");
    if ($tmp = get_first_match($tmp[1], '/([\s\S]+)\([eds.\s]+\)([\s\S]+)/')) {
      $e_auths = explode(",", str_replace("&", ",", str_replace(",,", ",", str_replace(' and ', ',', $tmp[1]))));
      if (count($e_auths) == 2) {
        $result['editor-last'] = trim($e_auths[0]);
        $result['editor-first'] = trim($e_auths[1]);
      } else if (count($e_auths) > 1){
        for($x = 0; $x < count($e_auths); $x += 2) {
          if (array_key_exists($x + 1, $e_auths)) {
            $result['editor-last' . (($x / 2) + 1)] = trim($e_auths[$x]);
            $result['editor-first' . (($x / 2) + 1)] = trim($e_auths[($x + 1)]);
          }
        }
      }
      $result['title'] = trim(trim(explode('.', $tmp[2])[0], ' "'), " '");
    } else {
      $result['title'] = trim(trim(explode('.', explode("In:", $ref)[1])[0], ' "'), " '");
    }
  }

  if ($is_journal) {
    if (strpos($ref, "<i>") !== false) {
      // NMBE ref
      $tmp = get_first_match($ref, '/[\s]*([\S][\s\S]+)\<i\>([\s\S]+)\<\/i\>([\s\S]*)\s([0-9]+[\s]*\-[\s]*[0-9]+)[^\d]/');
      $result['title'] = trim(trim(str_replace("<i>", "''", str_replace("</i>", "''", str_replace("<b>", "'''", str_replace("</b>", "'''", $tmp[1])))), " .'"), ' "');
      $result['journal'] = trim($tmp[2], ".() ");
      if ($pages == null) {
        $result['pages'] = str_replace("-", "–", trim($tmp[4]));
      }
      if ($tmp_x = get_first_match($tmp[3], '/\<b\>([\s\S]+)\<\/b\>/')) {
        $result['volume'] = $tmp_x;
      }
      if ($tmp_x = get_first_match($tmp[3], '/\(([\d]+)\)/')) {
        $result['issue'] = $tmp_x;
      }
    } else {
      // Other ref
      $tmp = explode(".", trim($ref, " ."));
      $ref = trim(array_pop($tmp));
      $result['title'] = trim(trim(trim(implode(". ", $tmp), " .'"), ' "'), " '");
      $tmp = get_first_match($ref, '/([^\d]+)(\d[\s\S]*)/');
      $result['journal'] = trim(trim(trim($tmp[1], " .'"), ' "'), " '");
      $result['volume'] = get_first_match($ref . ".", '/([\d]+)[^\d]/');
      if (strpos($ref, "(") !== false) {
        $result['issue'] = get_first_match($ref . ".", '/\(([\d]+)\)/');
      }
      if (strpos($ref, ":") !== false && $pages == null) {
        if (strpos($ref, "-") !== false) {
          $result['pages'] = str_replace("-", "–", trim(get_first_match($ref, '/\:\s*(\d+\s*\-\s*\d+)/')));
        } else {
          $result['page'] = str_replace("-", "–", trim(get_first_match($ref, '/\:\s*(\d+)/')));
        }
      }
    }
  }

  // Custom Pages
  if ($pages != null) {
    if (strpos($pages, "-") !== false) {
      $result['pages'] = str_replace("-", "–", trim($pages));
    } else {
      $result['page'] = $pages;
    }
  }

  // DOI
  if (!array_key_exists('doi', $result) && $doi) {
    $result['doi'] = $doi;
  }
  if ($url != '' && $url) { $result['url'] = $url; }

  // Book
  $is_book = false;
  if (!array_key_exists('title', $result) || $result['title'] == '') {
    if (!$result['title'] = get_first_match($ref, '/\<i\>([^\<]+)\</')) {
      $result['title'] = trim(explode(".", $ref)[0], " .");
    } else {
      $tmp_pages = str_replace("-", "–", trim(get_first_match($ref, ((strpos($ref, "-") !== false) ? '/(\d+\s*\-\s*\d+)/' : '/(\d+)/'))));
      $result['publisher'] = trim(str_replace(str_replace("–", "-", $tmp_pages), "", str_replace("<i>" . $result['title'] . "</i>", "", $ref)), " .,");
      $result['pages'] = (($pages == null) ? $tmp_pages : $pages);
    }
    $is_journal = false; $is_book = true;
  }

  $cite = "<ref name=" . str_replace('í', 'i', mb_substr($auths[0], 0, 4)) . $result['year'] .
    ">{{" . (($is_journal) ? "cite journal" : (($is_book) ? "cite book" : "citation"));
  foreach($result as $a => $b) {
    $cite .= "| " . $a . "=" . $b;
  }
  $result['ref'] = $cite . "}}</ref>";
  $result['name'] = str_replace('í', 'i', mb_substr($auths[0], 0, 4)) . $result['year'];
  return ($return_all ? $result : $result['ref']);
}

function as_of($lowercase = false) {
  return "{{as of|" . date('Y|m', strtotime('-1 month')) . ($lowercase ? "|lc=y" : "") . "}}";
}
function asof() {
  return as_of();
}

function get_url($type = 'w', $value = NULL) {
  if ($value == NULL) { return NULL; }
  if (trim(strtolower($type)) == 'w') {
    // Wikipedia
    return "https://en.wikipedia.org/wiki/" . $value;
  }
  if (trim(strtolower($type)) == 'b') {
    //BugGuide
    return "https://bugguide.net/node/view/" . $value;
  }
  if (trim(strtolower($type)) == 'e') {
    //EOL
    return "https://eol.org/pages/" . $value;
  }
  if (trim(strtolower($type)) == 'q') {
    //Wikidata
    return "https://www.wikidata.org/wiki/Q" . $value;
  }
  return NULL;
}

function bugguide_info($id) {
  $html = get_html('https://bugguide.net/node/view/' . $id);
  $i = get_first_match($html, '/div\sclass\s*\=\s*\"bgpage\-roots\"[\s\S]+\<h1\>([^\s]+)\s*\<i\>([^\<]+)\<\/i\>[\s\-]*([^\s\-][^\<]+[^\s])\s*\<[^\=]+\=\"node\-links\"\>([\s\S]*)\<div\sclass\=\"bgseparator/U');
  $result = array('rank' => $i[1], 'name' => $i[2], 'common_name' => $i[3], 'tax' => array(),
    'topics' => get_all_matches($i[4], '/\&middot\;\s\<a\shref\s*\=\s*\"(https\:\/\/bugguide\.net\/[^\"]+)\"[^>]+>([^<]+)</U'));
  foreach(explode('&raquo;', get_first_match($html, '/\>\s*Home\s*<\/a>\s*\&raquo\;\s*Guide\s*\&raquo\;([\s\S]+)\<h1\>/U')) as $val) {
    if ($x = get_first_match($val, '/title\s*\=\s*\"([^\"]+)\"\>\s*([^\s][^\(]+[^\s])\s*\(([^\)]+)\)\<\/a/') ) {
      $result['tax'][strtolower($x[1])] = strtolower($x[3]);
    }
  }
}

function spider_info($id, $gen_data = []){
  $africa = ['Algeria', 'Angola', 'Benin', 'Botswana', 'Burkina Faso', 'Burundi', 'Cameroon', 'Cape Verde', 'Central African Republic', 'Chad', 'Comoros', 'Congo', 'Republic of the Congo', 'Djibouti', 'Egypt', 'Equatorial Guinea', 'Eritrea', 'Eswatini', 'Swaziland', 'Ethiopia', 'Gabon', 'Gambia', 'Ghana', 'Guinea', 'Guinea Bissau', 'Guinea-Bissau', 'Ivory Coast', 'Kenya', 'Lesotho', 'Liberia', 'Libya', 'Madagascar', 'Malawi', 'Mali', 'Mauritania', 'Mauritius', 'Morocco', 'Mozambique', 'Namibia', 'Niger', 'Nigeria', 'Rwanda', 'Sao Tome', 'Sao Tome and Principe', 'Senegal', 'Seychelles', 'Sierra Leone', 'Somalia', 'South Africa', 'Sudan', 'South Sudan', 'Tanzania', 'Togo', 'Tunisia', 'Uganda', 'Zambia', 'Zimbabwe'];
  $europe = ['Albania', 'Andorra', 'Armenia', 'Austria', 'Azerbaijan', 'Belarus', 'Belgium', 'Bosnia and Herzegovina', 'Bulgaria', 'Croatia', 'Cyprus', 'Czech Republic', 'Denmark', 'Estonia', 'Finland', 'France', 'Germany', 'Greece', 'Hungary', 'Iceland', 'Ireland', 'Italy', 'Kazakhstan', 'Latvia', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Malta', 'Moldova', 'Monaco', 'Montenegro', 'Netherlands', 'Macedonia', 'Norway', 'Poland', 'Portugal', 'Romania', 'Russia', 'San Marino', 'Serbia', 'Slovakia', 'Slovenia', 'Spain', 'Sweden', 'Switzerland', 'Turkey', 'Ukraine', 'United Kingdom', 'Vatican City', 'Kosovo'];
  $n_america = ['Antigua and Barbuda', 'Bahamas', 'Barbados', 'Canada', 'Costa Rica', 'Cuba', 'Dominica', 'Dominican Republic', 'Grenada', 'Guatemala', 'Haiti', 'Mexico', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Vincent and the Grenadines', 'Trinidad and Tobago', 'USA', 'Bermuda'];
  $s_america = ['Argentina', 'Bolivia', 'Brazil', 'Chile', 'Colombia', 'Ecuador', 'Guyana', 'Paraguay', 'Peru', 'Suriname', 'Uruguay', 'Venezuela'];
  $c_america = ['Belize', 'El Salvador', 'Honduras', 'Nicaragua', 'Panama'];
  $asia = ['Afghanistan', 'Armenia', 'Azerbaijan', 'Bahrain', 'Bangladesh', 'Bhutan', 'Brunei', 'Cambodia', 'China', 'Cyprus', 'Egypt', 'Georgia', 'India', 'Indonesia', 'Iran', 'Iraq', 'Israel', 'Japan', 'Jordan', 'Kazakhstan', 'North Korea', 'South Korea', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Lebanon', 'Malaysia', 'Maldives', 'Mongolia', 'Myanmar', 'Nepal', 'Oman', 'Pakistan', 'Philippines', 'Qatar', 'Russia', 'Saudi Arabia', 'Singapore', 'Sri Lanka', 'Syria', 'Tajikistan', 'Thailand', 'Turkey', 'Turkmenistan', 'United Arab Emirates', 'Uzbekistan', 'Vietnam', 'Yemen', 'Palestine'];
  $oceania = ['Australia', 'Micronesia', 'Fiji', 'Kiribati', 'Marshall Islands', 'Nauru', 'New Zealand', 'Palau', 'Papua New Guinea', 'Samoa', 'Solomon Islands', 'Tonga', 'Tuvalu', 'Vanuatu'];

  $gen_data = ((array_key_exists('Spidergen', $gen_data)) ? $gen_data['Spidergen'] : []);
  $url = "https://wsc.nmbe.ch/genus/" . $id;
  $result = array('nmbe_id' => $id);
  $loc_syns = [
    "USA" => "the United States",
    "US" => "the United States"
  ];
  $html = get_html($url);
  if (strpos($html, "A 404 error occurred") !== false) { return null; }

  // Notes
  if (strpos($html, "N.B.:") !== false) {
    $result['notes'] = "";
    foreach(get_all_matches($html, '/N\.B\.\:([\s\S]+)<\/div>/U') as $val) {
      $result['notes'] .= $val[1] ."|";
    }
    debug("NOTES: " . $result['notes']);
  }

  // 1 - genus
  // 2 - species
  // 3 - auth
  // 4 - year
  // 5 - m / f
  $result['described'] = ['f' => null, 'm' => null, 'gen' => [], 'years' => []];
  
  // TODO: (f, Dm); (Dmf)
  foreach(get_all_matches($html, '/<i\>([^\s]+)\s([^\>]+)<\/i>\s*<strong>\s*<a\s*href\s*\=\s*\"\/reference\/[\d]+\"\>([^\,]+)\,\s*([\d]{4})[^<0-9]+<\/a><\/strong>[\:\s0-9]+\(D<u>([mf])<\/u>\)/') as $val) {
    if ($result['described'][$val[5]] == null) {
      $result['described'][$val[5]] = $val;
    } else {
      if (intval($result['described'][$val[5]][4]) > intval($val[4])) {
        $result['described'][$val[5]] = $val;
      }
    }
    // Gens by year described
    if (!array_key_exists($val[1], $result['described']['gen'])) {
      $result['described']['gen'][$val[1]] = [];
    }
    array_push($result['described']['gen'][$val[1]], $val);
  }
  
  //if ($result['described']['m'][4] != $result['described']['f'][4]) {
    //debug("M desc " . (($result['described']['m'] == null) ? "XX" : $result['described']['m'][4]) .
      //"; F desc " . (($result['described']['f'] == null) ? "XX" : $result['described']['f'][4])); }
  // TODO
  //debug($result['described']);

  //Family info
  $result['family'] = get_first_match($html, '/\<strong\>\s*Family\s*\:\s*[^\S]*([^\<]+)\<\/strong\>/');

  // Genus info
  $tmp = get_first_match($html, '/class\=\"genusTitle\"\>Gen\. \<strong\>\<i\>([^\s]+)\<\/i\>\<\/strong\>[\s]*([^\s][^\<]*, \d{4})\s[\s\S]*\"(\/genusdetail\/[0-9]*)\"\>\<b\>Detail/');
  $result['genus'] = trim($tmp[1]);
  $result['auth'] = trim($tmp[2]);
  if (count($gen_data)) {
    if ($gen_data['name'] != $result['genus']) { debug('WARNING: Gen name "' . $gen_data['name'] . '" != "' . $result['genus'] . '"'); }
    if ($gen_data['auth'] != $result['auth']) { debug('WARNING: Auth name "' . $gen_data['auth'] . '" != "' . $result['auth'] . '"'); }
  }

  $result['gen_ref'] = parse_ref(trim(get_first_match(get_html('https://wsc.nmbe.ch' . $tmp[3]), '/\<div class\=\"reference\"\>\<p\>([\s\S]+)\<a title\=\"Log in/')));

  // Placeholders
  $result['image'] = [];
  $result['wikidata_id'] = "";
  $result['categories'] = [];
  $result['taxobox'] = [];
  $result['locations'] = [];
  $result['type_species'] = [];
  $result['species'] = [];

  // Species
  $tmp = get_first_match($html, '/class\s*\=\s*\"speciesTitle\">\s*<a\s*href\s*\=\s*\"[^\"]+\">\s*<strong>\s*<i>\s*([^\<]+)\s*\<\/i>\s*<\/strong>\s*<\/a>\s*([^\s][^<]+[^\s])\s*<strong>\s*\*/');
  $result['type_species'] = array('name' => $tmp[1], 'auth' => $tmp[2]);
  $tmp = get_all_matches($html, '/class\=\"speciesTitle\"\>\<a[\s]*href\=\"\/species\/\d+\/[^\s]+\"\>[\s]*\<strong\>\<i\>([^\<]+)\<\/i\>\<\/strong\>\<\/a\>[\s]*([^\<]+)[^\=]+\=\"specInfo\"\>[\s]+\|[^\|]*\|\s*([^\[]+)\[/');
  $num_species = 0;
  foreach($tmp as $val) {
    $num_species += ((count(explode(" ", trim($val[1]))) == 2) ? 1 : 0);
    array_push($result['species'], array(
      'name' => trim($val[1]),
      'auth' => trim($val[2]),
      'location' => trim(str_replace("&nbsp;", "", $val[3]))
    ));
  }
  
  // Taxobox images & image captions
  $html = get_html('https://en.wikipedia.org/wiki/' . ((count($gen_data)) ? $gen_data['wp_url'] : $result['genus']));
  if (strpos($html, "Temporal range") !== false) {
    $tmp_fossil = get_first_match($html, '/Temporal\srange\:[\s\S]*display\:inline\-block;\"\>\s*([a-zA-Z]*)\s*–\s*([^\<]*)\s*\<\/span/U');
    $result['taxobox']['keys']['fossil_range'] = "{{Fossil range| " . ucfirst(trim(strtolower($tmp_fossil[1]))) . "| " . ucfirst(trim(strtolower($tmp_fossil[2]))) . "}}";
  }

  // External links
  $result['external_links'] = "";
  if ($ext_html = get_first_match($html, '/\<span\s*class\s*\=\s*\"mw\-headline\"\s*id\s*\=\s*\"External\_links\"\>[\s\S]*<\/h2>([\s\S]*)Taxon_identifiers/U')) {
    if (strpos($ext_html, '/wiki/Wikispecies') !== false || strpos($ext_html, 'Wikimedia Commons has media related to') !== false) {
      $result['external_links'] = "\n==External links==\n";
      if (strpos($ext_html, '/wiki/Wikispecies') !== false) {
        // wikispecies
        $result['external_links'] .= "{{Wikispecies-inline}}\n";
      }
      if (strpos($ext_html, 'Wikimedia Commons has media related to') !== false) {
        // wikimedia commons
        $result['external_links'] .= "{{Commons-inline}}\n";
      }
    }
  }

  if ($pics = get_first_match($html, '/<tbody>\s*<tr>\s*<th\s*colspan\s*\=\s*\"\d+\"\s*style\s*\=\s*\"text\-align\s*\:\s*center\;\s*background\-color\s*\:\s*rgb\(\d+\,\d+\,\d+\)\">\s*<i>[^\<]+<\/i>([\s\S]*)<th\s*colspan\s*\=\s*\"\d*\"\s*style\s*\=\s*\"min\-width\s*\:\s*\d*em\;\s*text\-align\s*\:\s*center\;\s*background\-color\s*\:\s*rgb\(\d*\,\d*\,\d*\)\">\s*<a\s*href\s*\=\s*\"\/wiki\/Taxonomy_\(biology\)"/U')) {
    $piclist = get_all_matches($pics, '/<td\s*colspan\s*\=\s*\"\d*\"\s*style\s*\=\s*\"text\-align\s*\:[^>]+\>([\s\S]+)\<\/td>/U');
    $z = 0;
    foreach($piclist as $x) {
      if (strpos($x[1], 'class="image"') === false) {
        // Image Caption
        $tmp_c = str_replace("<i>", "&#39;&#39;", str_replace("</i>", "&#39;&#39;", $x[1]));
        foreach(get_all_matches($tmp_c, '/(<[\s\S]*>)/U') as $y) {
          $tmp_c = str_replace($y, "", trim($tmp_c));
        }
        $result['image']['image' . (($z == 1) ? "" : $z) . "_caption"] = trim(str_replace("&#39;", "'", $tmp_c));
      } else {
        // Image
        $tmp_c = get_first_match($x[1], '/href\s*\=\s*\"\/wiki\/File\:([^\"]+)\"\s*class\s*\=\s*\"image/');
        $z++;
        $result['image']['image' . (($z == 1) ? "" : $z)] = trim(str_replace("&#39;", "'", $tmp_c));
      }
    }
  }

  // Wikidata & Categories
  $result['wikidata_id'] = str_replace("|from", "| from", get_first_match($html, '/https:\/\/www\.wikidata\.org\/wiki\/Special\:EntityPage\/([^\#\"]+)[\#\"]/U'));
  foreach(get_all_matches(get_first_match($html, '/<div id="mw-normal-catlinks"[^\>]*\>([\s\S]*)<\/div>/U'), '/wiki\/(Category:[^\"]+)[\"]/') as $x) {
    $tmp_ignore_cats = ["Category:Araneomorphae", "Category:Mygalomorphae"];
    if (strpos($x[1], "taxa named by") === false && strpos($x[1], "stubs") === false && !in_array($x[1], $tmp_ignore_cats)) {
      array_push($result['categories'], str_replace("_", " ", $x[1]));
    }
  }
  $result['categories'] = array_unique($result['categories']);
  if (count($result['species']) == 1) {
    // Monotypic Genera
    $qid_html = get_html('https://www.wikidata.org/w/index.php?search=' . $result['genus']);
    $qid_g = get_first_match($qid_html, "/\<span\s*class\s*\=\s*\"wb\-itemlink\-id\"\>\((Q[^\)]+)\)\s*\<\/span\>\s*\<\/span\>\s*\<\/a\>\s*\<\/div\>\s*\<div\s*class\s*\=\s*\"searchresult\"\>\s*\<span\s*class\s*\=\s*\"wb\-itemlink\-description\"\>\s*genus\sof/");
    $qid_s = get_first_match($qid_html, "/\<span\s*class\s*\=\s*\"wb\-itemlink\-id\"\>\((Q[^\)]+)\)\s*\<\/span\>\s*\<\/span\>\s*\<\/a\>\s*\<\/div\>\s*\<div\s*class\s*\=\s*\"searchresult\"\>\s*\<span\s*class\s*\=\s*\"wb\-itemlink\-description\"\>\s*species\sof/");
    if (!$qid_s) {
      $qid_s = get_first_match($qid_html, '/' . trim(str_replace(" ", "_", explode(" ", $result['species'][0]['name'])[1])) . '\s*\<\/span\>\s*\<span\s*class\s*\=\s*\"wb\-itemlink\-id\"\s*\>\((Q[^\)]+)\)\s*\<\/span/');
    }
    if ($qid_g != $result['wikidata_id'] && $qid_s != $result['wikidata_id']) {
      debug ("CHECK TAXON ID: " . $result['wikidata_id']);
    }
    $result['wikidata_id'] = (($qid_g && $qid_s) ? ($result['wikidata_id'] . "| from2=" . (($result['wikidata_id'] == $qid_s) ? $qid_g : $qid_s)) : $result['wikidata_id']);
  }

  // Taxobox wiki prose
  $result['taxobox']['header'] = "{{Short description| Genus of spiders}}\n" .
    (($num_species == 1) ? "{{Speciesbox" : "{{Automatic taxobox");
  $result['taxobox']['keys']['taxon'] = (($num_species == 1) ? $result['species'][0]['name'] : $result['genus']);  
  $result['taxobox']['keys'] = array_merge($result['taxobox']['keys'], $result['image']);
  if (count($result['image']) == 0) {
    $result['taxobox']['keys']['image'] = '';
    $result['taxobox']['keys']['image_caption'] = '';
  }
  $result['taxobox']['keys']['authority'] = $result['auth'] . "<ref name=NMBE />"; //auth_ref = ??TODO
  if ($num_species > 1) {
    if ($result['type_species']['name'] !== null) {
      $result['taxobox']['keys']['type_species'] = "''[[" . $result['type_species']['name'] . "|" .
        substr($result['type_species']['name'], 0, 1) . ". " .
        trim(explode(" ", $result['type_species']['name'])[1]) . "]]''";
      $result['taxobox']['keys']['type_species_authority'] = $result['type_species']['auth'];
    }
    $result['taxobox']['keys']['subdivision_ranks'] = 'Species';
    $result['taxobox']['keys']['subdivision'] = '' . $num_species . ", [[#Species|see text]]";
    if ($num_species < 4) {
      $result['taxobox']['keys']['subdivision'] = "{{Specieslist";
      foreach($result['species'] as $val) {
        // Place species in taxobox
        $tmp = explode(" ", $val['name']);
        $result['taxobox']['keys']['subdivision'] .= "\n| ";
        if (count(explode(" ", $val['name'])) == 2) {
          $result['taxobox']['keys']['subdivision'] .= "[[" . $val['name'] . "|" .
            substr($tmp[0], 0, 1) . ". " . $tmp[1] . "]]";
        } else {
          $result['taxobox']['keys']['subdivision'] .= "&nbsp;&nbsp;&nbsp;";
          $tmp_namearr = explode(" ", $val['name']);
          for ($i = 0; $i < count($tmp_namearr); $i++) {
            if ($i == count($tmp_namearr) - 1) {
              $result['taxobox']['keys']['subdivision'] .= strtolower($tmp_namearr[$i]);
            } else {
              $result['taxobox']['keys']['subdivision'] .= (($i == 0) ? strtoupper(substr($tmp_namearr[$i], 0, 1)) : strtolower(substr($tmp_namearr[$i], 0, 1))) . ". ";
            }
          }
        }
        $result['taxobox']['keys']['subdivision'] .= "|<small>" .
          $val['auth'] . "</small> – " . $val['location'];
      }
      $result['taxobox']['keys']['subdivision'] .= "}}";
    }
  } else { // Single species; Speciesbox
    $result['taxobox']['keys']['parent_authority'] = $result['taxobox']['keys']['authority'];
    $result['taxobox']['keys']['authority'] = (($result['type_species']['name'] !== null) ? $result['type_species']['auth'] : "");
  }
  $result['taxobox']['footer'] = "\n}}";
  return $result;
}

/**
 * Application CONSTANTS
 */

Configure::write('debug', 2);        // 0,1,2(max)  => amount of debug/warning messages
Configure::write('App.test_mode', true); // use sandbox systems?
 
// ---- Xbox Achievements ----
Configure::write('App.xbox_xuid', '2533274972074496');
Configure::write('App.xbox_xuid_auth', 'e9ac30dbc18f45784c45f9330aa457b056e0ebda');


