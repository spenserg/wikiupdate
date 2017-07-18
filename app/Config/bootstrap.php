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

function get_html($url){
  ini_set('max_execution_time', 300);
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

function remove_tags($str){
  foreach(get_all_matches($str,'/(<[\s\S]*>)/U') as $val) //html markups "<a href=>hi</a>"
    $str = substr($str,0,strpos($str,$val[1])).substr($str,strpos($str,$val[1])+strlen($val[1]));
  foreach(get_all_matches($str,'/(\[[0-9]*\])/U') as $val) //wiki references "[3]"
    $str = substr($str,0,strpos($str,$val[1])).substr($str,strpos($str,$val[1])+strlen($val[1]));
  return $str;
}

function get_wiki_info($item,$remove_tags = false){
  $result = array();
  if (strpos($item,'en.wikipedia.org')===false)
    $item = 'https://en.wikipedia.org/wiki/'.$item;
  foreach(get_list($item,'/<th scope="row">([\s\S]*)<\/th>[\s\S]*<td>([\s\S]*)<\/td>/U',false,'<table class="infobox')['results'] as $val)
    $result[remove_tags($val[1])] = ($remove_tags)?remove_tags($val[2]):$val[2];
  return $result;
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
  //$urls = array(0=>get_stuff());
  //$urls = (is_array($url_list))?$url_list:array(0=>$url_list);
  $results = array('urls'=>$url_list,'regex'=>$regex,'results'=>array());
  //foreach($urls as $url){
    //$html = get_html($url);
    $html = get_stuff();
    if ($from != null)
      $html = substr($html,strpos($html,$from));
    if ($to != null)
      $html = substr($html,0,strpos($html,$to));
    $results['html'] = ($include_html)?$html:NULL;
    
    //debug($html);
    
    foreach(get_all_matches($html,$regex) as $val){
      array_push($results['results'],$val);
    }
  //}
  return $results;
}

// Find first regex match in html source code
function get_first_match($html, $regex){
  if(preg_match($regex, $html, $regs)){
    if(isset($regs[2]))
      return $regs; // multiple capture groups
    else
      return $regs[1];
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

function spider_taxobox($url){
  $fam_stub_list = array("Agelenidae","Araneidae","Linyphiidae","Lycosidae","Salticidae","Theraphosidae","Theridiidae","Zodariidae");
  $html = get_html($url);
  $family = get_first_match($html,'/<strong>Family: ([\s\S]*)<\/strong>/U');
  $genus = get_first_match($html,'/<div class="genusTitle">Gen\. <strong><i>([a-zA-Z]*)<\/i><\/strong> ([\s\S]*), ([0-9][0-9][0-9][0-9])/U');
  $species_list = get_all_matches($html,'/<div class="speciesTitle">[\s\S]*<strong><i>([a-zA-Z ]*)<\/i><\/strong><\/a>[\s]*([^\s][\s\S]*)<span class="specInfo">/U');
  $gen1 = $genus[1];
  $gen2 = $genus[2];
  $gen3 = $genus[3];
  
  $type_id = -1;
  foreach($species_list as $key=>$val){
    if (strpos($val[2],"<strong> * </strong>") !== false)
      $type_id = $key;
  }
  
  $xyz = explode(" ",$gen2);
  $tmp_auth = array_pop($xyz);
  
//  $str = '{{italic title}}
//';
$str = '';
  if (count($species_list) == 1){
    $str .= '{{Speciesbox
| taxon='.$species_list[0][1].'
| authority='.trim(str_replace("<strong> * </strong>","",$val[2])).'<ref name=NMBE />
}}
';
  }else{
    $str .= '{{Automatic taxobox
| taxon='.$gen1.'
| authority='.$tmp_auth.'<ref name=NMBE />
';
if ($type_id != -1){
  $str .="| type_species = ''".$species_list[$type_id][1]."''";
}
$str .= '
| subdivision_ranks = Species
| subdivision = ';
if (count($species_list) > 5){
  $str .= count($species_list).', see text';
}else{
  $str .= '
{{Specieslist';
  foreach($species_list as $val){
    $str .= '
  |[['.$val[1].']]|<small>'.trim(str_replace("<strong> * </strong>","",$val[2])).'</small>';
  }
  $str .="}}";
}
  $str .= "
}}
";
}
  
$str .= "'''''".$gen1."''''' is a genus of spiders in the [[".$family."]] family. It was first described in ".
$gen3." by ".$gen2.". {{As of|".date('Y')."}}, it contains ".
(count($species_list)==1?"only one species, '''''".$species_list[0][1]."'''''":count($species_list)." species").
".<ref name=NMBE>{{cite web|title=".$family.'| website=World Spider Catalog| publisher=Natural History Museum Bern| accessdate='.date('Y-m-d').'| url='.$url.'}}</ref>';

if (count($species_list) > 5){
  $str .="

==Species==
''".$gen1."'' comprises the following species:<ref name=NMBE /><!--When updating this list, please also update the list at [[List of ".$family." species#".$gen1."]]-->
";
  foreach($species_list as $val){
    $str .= "*''[[".$val[1]."]]'' <small>".trim(str_replace("<strong> * </strong>","",$val[2]))."</small>
";
  }
}else{
  $str .="
";
}

$str .="
==References==
{{reflist}}

[[Category:".$family."]]
";
  if (count($species_list) == 1){
    $str .= "[[Category:Monotypic spider genera]]";
  }else{
    $str .= "[[Category:Spider genera]]";
  }
  
$str .= "

{{".(in_array($family,$fam_stub_list)?$family:"spider")."-stub}}";
return array(
    'family'=>$family,
    'genus'=>$genus,
    'species'=>$species_list,
    'talk_page'=>'{{WPSpiders|class=stub|importance=low|image-requested=yes}}',
    'auto_taxobox_url'=>'https://en.wikipedia.org/w/index.php?title=Template:Taxonomy/'.$gen1.'&action=edit',
    'auto_taxobox'=>"{{Don't edit this line {{{machine code|}}}
|rank=genus
|link=".$gen1."
|parent=".$family."
|refs=<!--Shown on this page only; dont include <ref> tags -->}}",
    'new_page'=>$str);
}

/**
 * Application CONSTANTS
 */

Configure::write('debug', 2);        // 0,1,2(max)  => amount of debug/warning messages
Configure::write('App.test_mode', true); // use sandbox systems?
 
// ---- Xbox Achievements ----
Configure::write('App.xbox_xuid', '2533274972074496');
Configure::write('App.xbox_xuid_auth', 'e9ac30dbc18f45784c45f9330aa457b056e0ebda');


