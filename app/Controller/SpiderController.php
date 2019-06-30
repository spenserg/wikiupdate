<?php

App::uses('AppController','Controller');

class SpiderController extends AppController {

  public $uses = false; // autoloader

  public function beforeFilter(){
    parent::beforeFilter();
  }
  
  public function index($x=3133,$y=-1){
    if ($this->request->is('post')){
      $x = $_POST['x'];
      $y = $_POST['y'];
      if (isset($_POST['url_name'])){
        $this->Spidergen->read(null,$_POST['cur_id']);
        $this->Spidergen->set(array('wp_url'=>'https://en.wikipedia.org'.$_POST['url_name']));
        $this->Spidergen->save();

  public function ref() {
    $ref = [];
    $old = "";
    if ($this->request->is('post')) {
      $old = $_POST['cite'];
      if ($old) {
        $auth_links = "";
        $ref = parse_ref($old);
        foreach($ref as $key=>$val) {
          if (strpos($key, "last") !== false){
            $sub_index = ((strpos($key, 'editor') === false) ? 4 : 11);
            $auth_link = $this->Spiderauth->get_link($ref['first' . substr($key, $sub_index)] . " " . $val);
            if (strpos($auth_link, "[[") !== false) {
              //De-link
              $auth_links .= "| author-link" . substr($key, $sub_index) . "=" . str_replace(" ", "_", str_replace("[[", "", str_replace("]]", "", explode("|", $auth_link)[0])));
            }
          }
        }
        if (strlen($auth_links) > 0) {
          $ref['ref'] = substr($ref['ref'], 0, strlen($ref['ref']) - 8) . $auth_links . "}}</ref>";
        }
      }
    }
    $this->set('ref', $ref);
    $this->set('old', $old);
  }
  }
    foreach($locs as $key=>$val) {
      $locs[$key]['main'] = $this->Location->short_list($locs[$key]);
    }
 
    $num_gens = 0;
    $num_specs = 0;
    $all_gens = [];
    $gen_str = "";
    $detail_list = "";
    $toc_tag = "{{Compact ToC| right=yes| refs=yes";
    $atoz = range('A', 'Z');
    $atoz_index = -1;

    //Genus List
    foreach(get_all_matches($html, '/Gen\.\s<strong>\s*<i>\s*([^<]+)\s*<\/i>\s*<\/strong>\s*([\s\S]+\,\s*\d{4}[^\s]*)\s/U') as $val) {
      if (!($tmpgen = $this->Spidergen->find('first', array('conditions' => array('name' => $val[1]))))) {
        debug("GEN NOT FOUND: " . $val[1]);
      } else {
        $num_gens++;
        foreach(explode("Gen.", $html) as $v) {
          if ($g = $this->Spidergen->find('first', array('conditions' => array('name' => get_first_match($v, '/[^<]<strong>\s*<i>([^<]+)<\/i>\s*<\/strong>/'))))) {
            if ($tmpgen['Spidergen']['num_species'] != count(get_all_matches($v, '/href="\/species\/(\d+)\//'))) {
              $this->Spidergen->read(null, $g['Spidergen']['id']);
              $this->Spidergen->set(array('num_species' => count(get_all_matches($v, '/href="\/species\/(\d+)\//'))));
              $this->Spidergen->save();
              if ($tmpgen['Spidergen']['id'] == $g['Spidergen']['id']) {
                $tmpgen['Spidergen']['num_species'] = count(get_all_matches($v, '/href="\/species\/(\d+)\//'));
              }
            }
          }
        }
        $num_specs += $tmpgen['Spidergen']['num_species'];

        //Spider Info
        $tmp_si = spider_info($tmpgen['Spidergen']['nmbe_id'], $tmpgen);
        $tmp_si = $this->Spidergen->after_spider_info($tmp_si);

        if ($atoz_index == -1 || strcmp(strtoupper(substr($tmpgen['Spidergen']['name'], 0, 1)), $atoz[$atoz_index]) !== 0) {
          $atoz_index++;
          while($atoz_index < 26 && strcmp(strtoupper(substr($tmpgen['Spidergen']['name'], 0, 1)), $atoz[$atoz_index]) !== 0) {
            $toc_tag .= "| " . strtolower($atoz[$atoz_index]) . "=";
            $atoz_index++;
          }
          $detail_list .= "\n==" . $atoz[$atoz_index] . "==";
        }
        $gen_str .= "\n*''[[";

        $detail_list .= "\n===''" . $tmpgen['Spidergen']['name'] . "''===\n" .
          "<!--Use this template to add pictures\n{{multiple image\n| title = ''" . $tmpgen['Spidergen']['name'] . "''\n" .
          "| direction = vertical\n| image1 = \n| caption1 = ''[[]]''\n| image2 = \n| caption2 = ''[[]]''\n}}-->\n''[[";
        if (strcmp($tmpgen['Spidergen']['name'], $tmpgen['Spidergen']['wp_url']) !== 0) {
          $gen_str .= $tmpgen['Spidergen']['wp_url'] . "|";
          $detail_list .= $tmpgen['Spidergen']['wp_url'] . "|";
        }
        $gen_str .= $tmpgen['Spidergen']['name'] . "]]'' <small>" . $tmpgen['Spidergen']['auth'] . "</small>";
        $detail_list .= $tmpgen['Spidergen']['name'] . "]]'' <small>" . $tmpgen['Spidergen']['auth'] . "</small>";
        $tmp_num_specs = 0;
        foreach($tmp_si['species'] as $ts) {
          
          if (strtolower(trim(explode(" ", str_replace("_", " ", $ts['name']))[0])) !== strtolower($tmpgen['Spidergen']['name'])) {
            debug("CHECK NMBE ID: " . $tmpgen['Spidergen']['name'] . " | NMBE ID: " . $tmpgen['Spidergen']['nmbe_id']);
          }
          $tmp_num_specs += ((count(explode(" ", $ts['name'])) == 2) ? 1 : 0);

          $detail_list .= "\n*" . ((count(explode(" ", $ts['name'])) == 3) ? "*" : "") . " ''[[";
          // Redirect monotypic species to genus unless genus is disambig
          if ($tmpgen['Spidergen']['num_species'] == 1 && trim(str_replace("_", " ", $tmpgen['Spidergen']['wp_url'])) != trim(str_replace("_", " ", $tmpgen['Spidergen']['name']))) {
            $detail_list .= $tmpgen['Spidergen']['wp_url'] . "|";
          }
          $detail_list .= $ts['name'] . "]]'' <small>" . $ts['auth'] . "</small>" .
          ((strcmp($tmp_si['type_species']['name'], $ts['name']) == 0) ? " ([[Type_species|type]])" : "") . " — " . $ts['location'];
        }
        $detail_list .= "\n";
        if ($tmp_num_specs != $tmpgen['Spidergen']['num_species']) {
          $tmpgen['Spidergen']['num_species'] = $tmp_num_specs;
          $this->Spidergen->read(null, $tmpgen['Spidergen']['id']);
          $this->Spidergen->set(array('num_species' => $tmp_num_specs));
          $this->Spidergen->save();
        }

        if (array_key_exists($tmpgen['Spidergen']['name'], $locs) && $locs[$tmpgen['Spidergen']['name']] != NULL && $locs[$tmpgen['Spidergen']['name']] != "") {
          $gen_str .= " – " . implode(", ", $locs[$tmpgen['Spidergen']['name']]['main']);
        }
        if ($tmpgen['Spidergen']['auth'] != trim($val[2])) {
          $this->Spidergen->read(null, $tmpgen['Spidergen']['id']);
          $this->Spidergen->set(array('auth' => trim($val[2])));
          $this->Spidergen->save();
          $tmpgen['Spidergen']['auth'] = trim($val[2]);
        }
        array_push($all_gens, $tmpgen);
      }
    }

[[Category:Redirects to animals]]');
    
    $page_html = get_html($gen['Spidergen']['wp_url']);    
    $this->set('edit_url','https://en.wikipedia.org/w/index.php?title='.$gen['Spidergen']['name'].'&action=edit');
    $this->set('has_image',(strpos($page_html,'og:image')!==false));
    
    $this->set('x',$x+1);
    $this->set('y',$y-1);
      
    /* RECORD ALL GENERA
    foreach(get_all_matches(get_html('http://www.wsc.nmbe.ch/families'),'/<strong>([a-zA-Z]*)<\/strong>/U') as $key=>$val){
      debug(($key+1)." of 117 | ".$val[1]);
      foreach(get_all_matches(get_html('http://www.wsc.nmbe.ch/genlist/'.($key+1).'/'.$val[1]),'/<strong><i>([a-zA-Z]*)<\/i><\/strong>/U') as $wal){
        $this->Spidergen->create();
        $this->Spidergen->set(array(
          'family'=>$val[1],
          'name'=>$wal[1]
        ));
        $this->Spidergen->save();
    $atoz_index++;
    while ($atoz_index < 26) {
      $toc_tag .= "| " . strtolower($atoz[$atoz_index]) . "=";
      $atoz_index++;
    }

    $detail_list = "}}<!--{{TOC right}}-->\n{{main|" . str_replace("_", " ", $fam['Spiderfam']['wp_url']) . "}}\nThis page lists all described [[genus|genera]] and " .
      "[[species]] of the spider family '''" . $fam['Spiderfam']['name'] . "'''. " . as_of() . ", the [[World Spider Catalog]] accepts " .
      $num_specs . " species in " . $num_gens . " genera:<ref name=NMBE>{{cite web| title=Family: " . $fam['Spiderfam']['name'] .
      " " . $fam['Spiderfam']['auth'] . "| website=World Spider Catalog| accessdate=" . date("Y-m-d") .
      "| publisher=Natural History Museum Bern| url=http://www.wsc.nmbe.ch/" . $fam['Spiderfam']['nmbe_id'] . "}}</ref>" .
      $detail_list . "\n==References==\n{{reflist}}\n\n{{DEFAULTSORT:" . $fam['Spiderfam']['name'] . "}}\n" .
      "[[Category:Lists of spider species by family|" . $fam['Spiderfam']['name'] . "]]\n" .
      "[[Category:" . $fam['Spiderfam']['name'] . "]]\n\n{{Araneae}}";
    $this->set('str', $str . 
      (($num_gens <= 50) ? '{{div col| colwidth=30em}}' : '<div style="height: 300px; overflow:auto; border: 1.5px solid #242424; background: transparent; padding: 4px; text-align: left;">') .
      $gen_str . (($num_gens <= 50) ? '{{div col end}}' : '</div>'));
    $n = $this->Spiderfam->find('first', array('conditions' => array('id >' => $fam['Spiderfam']['id'])));
    $this->set('next_id', $n['Spiderfam']['id']);
    $this->set('fam', $fam['Spiderfam']);

    $taxobox = array('header' => "{{short description| Family of spiders}}\n{{Automatic taxobox", 'keys' => array());
    // NOTE: TITLE DOES NOT ITALICIZE IF NAME != TITLE
    if ($fam['Spiderfam']['nickname'] != NULL) {
      $taxobox['keys']['name'] = ucfirst(strtolower($fam['Spiderfam']['nickname']));
    }
    $taxobox['keys']['image'] = '';
    $taxobox['keys']['image_caption'] = "";
    $taxobox['keys']['taxon'] = $fam['Spiderfam']['name'];
    $taxobox['keys']['authority'] = $this->Spiderauth->get_auths($fam['Spiderfam']['auth']) . substr($fam['Spiderfam']['auth'], -6);
    $taxobox['keys']['range_map'] = "";
    $taxobox['keys']['diversity'] = "[[#Genera|" . $num_gens . " genera]], [[" . fam_list_link($fam['Spiderfam']['name']) . "|" . $num_specs . " species]]";
    $taxobox['keys']['diversity_ref'] = '<ref name=NMBE />';

    if ($num_gens < 4) {
      $taxobox['keys']['subdivision_ranks'] = "Genera";
      $taxobox['keys']['subdivision'] = "{{linked genus list";
      foreach($all_gens as $v) {
        $taxobox['keys']['subdivision'] .= "\n  | ''[[" .
          (($v['Spidergen']['name'] == $v['Spidergen']['wp_url']) ? "" : ($v['Spidergen']['wp_url'] . "{{!}}")) .
          $v['Spidergen']['name'] . "]]''|" . $v['Spidergen']['auth'];
      }
      $taxobox['keys']['subdivision'] .= "}}";
    }
    $taxobox['footer'] = "\n}}";
    $this->set('taxobox', build_taxobox($taxobox));
    $this->set('num_gens', $num_gens);
    $this->set('detail_list', $toc_tag . $detail_list); 
  }

  public function check() {
    foreach($this->Spiderfam->find('all', array('conditions' => array())) as $f) {
      $f = $f['Spiderfam'];
      $num_gens = 0;
      $html = get_html('https://wsc.nmbe.ch/genlist/' . $f['nmbe_id']);
      foreach(get_all_matches($html, '/\d+\.\s\<strong\>\<i\>([^\<]+)\<\/i\>\<\/strong[^\|]+\|\s*\<a\stitle\s*\=\s*\"Detail\"\s*href\s*\=\s*\"\/genusdetail\/(\d+)[^\d]/') as $v) {
        $num_gens++;
        if ($g = $this->Spidergen->find('first', array('conditions' => array('name' => $v[1])))) {
          // Genus in db
          if ($v[2] != $g['Spidergen']['nmbe_id']) {
            //debug("CHECK NMBE ID: " . $v[1] . "(" . $v[2] . ")");
          }
          if ($f['id'] != $g['Spidergen']['family_id']) {
            debug("CHECK FAM ID: " . $v[1] . "(" . $f['name'] . ")");
          }
        } else {
          debug("MISSING GEN: " . $v[1]);
        }
      }
    }
    /*
    
    
      
  }
  
  public function temp() {
    if ($this->request->is('post') && array_key_exists('cite', $_POST)) {
      $shtml_arr = explode("Friends Earned", $_POST['cite']);
      foreach(get_all_matches($shtml_arr[count($shtml_arr) - 1], '/\s([^\s][^\d]*)\s([A-Za-z]{3}\s\d+\,\s\d{4})\s*([\dN][\/A\d\,]*)\s*(\d[\d\,]*)\s/') as $val) {
        if (!$this->Badge->find('first', array('conditions' => array('name' => trim($val[1]))))) {
          $this->Badge->create();
          $this->Badge->set(array(
            'name' => $val[1],
            'date_added' => date("Y-m-d", strtotime($val[2])),
            'all_users' => intval(str_replace(",","", $val[3])),
            'all_users_updated' => date("Y-m-d")
          ));
          $this->Badge->save();
        } else {
          // badge already exists
        }
        
        debug($val);
        
      }
    }
      }
  }
}

?>