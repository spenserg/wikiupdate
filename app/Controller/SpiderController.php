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
      }
    }
    $x = 1; //NMBE id
    $y = ($y != -1) ? $y : count($this->Spidergen->find('all',array('conditions'=>array('nmbe_id >='=>$x,'num_species'=>1,'only_author'=>0))));
    
    $this->set('taxobox',$t = spider_taxobox('http://www.wsc.nmbe.ch/genus/'.$x));
    $this->set('gen',$gen = $this->Spidergen->find('first',array('conditions'=>array('nmbe_id'=>$x))));
    $this->set('redir_html','#REDIRECT [['.$t['genus'][1].']]
    
{{R to monotypic taxon|spider}}

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
      }
    }
     */ 
     
     /* UPDATE NMBE ID AND NUM SPECIES
     for($y=4990;$y<6000;$y++){
      $wer = spider_taxobox('http://www.wsc.nmbe.ch/genus/'.$y);
      if ($ert = $this->Spidergen->find('first',array('conditions'=>array('name'=>$wer['genus'][1])))){
        $this->Spidergen->read(null,$ert['Spidergen']['id']);
        $this->Spidergen->set(array(
          'nmbe_id'=>$y,
          'num_species'=>count($wer['species'])
        ));
        $this->Spidergen->save();
      }
    }
      */ 
      
      
    /*
     * 
     * UPDATE ALL (Warning: Takes about an hour if all chosen)
     * 
     * page exists | template exists | auto taxobox | type_spec | only user | needs spec relocation
     * 
     
    
    
    foreach($this->Spidergen->find('all') as $val){
            
      $xarr = array();
      $page_html = get_html($val['Spidergen']['wp_url']);
      $wp_name = substr($val['Spidergen']['wp_url'],30);
      $template_html = get_html('https://en.wikipedia.org/wiki/Template:Taxonomy/'.$wp_name);
      $talk_html = get_html('https://en.wikipedia.org/w/index.php?title='.$wp_name.'&action=history');
      
      $xarr[$val['Spidergen']['name']]['page_exists'] = !(strpos($page_html,'noarticletext')!==false);
      $xarr[$val['Spidergen']['name']]['template_exists'] = (strpos($template_html,"Eukaryote")!==false);
      $xarr[$val['Spidergen']['name']]['has_auto_taxobox'] = (strpos($page_html,'wiki/Template:Taxonomy')!==false);
      $xarr[$val['Spidergen']['name']]['has_type_spec'] = !(strpos($page_html,'/wiki/Type_species" title="Type species')!==false);
      
      $xarr[$val['Spidergen']['name']]['only_user'] = $xarr[$val['Spidergen']['name']]['page_exists'];
      
      foreach(get_all_matches($talk_html,'/<bdi>([\s\S]*)<\/bdi>/U') as $wal){
        if ($wal[1] != "Sesamehoneytart")
          $xarr[$val['Spidergen']['name']]['only_user'] = false;
      }
      if ($xarr[$val['Spidergen']['name']]['needs_spec_relocation'] = $xarr[$val['Spidergen']['name']]['has_auto_taxobox']){
        $spec_list_html = substr($page_html,strpos($page_html,'Species</th>'));
        $spec_list_html = substr($spec_list_html,0,strpos($spec_list_html,'</table>'));
        $xarr[$val['Spidergen']['name']]['needs_spec_relocation'] = (strpos($spec_list_html,'Synonym')!==false)?0:(count(get_all_matches($spec_list_html,'/<li([\s\S]*)<\/li>/U'))>5);
      }
      $this->Spidergen->read(null,$val['Spidergen']['id']);
      $this->Spidergen->set(array(
        'has_auto_taxobox'=>($xarr[$val['Spidergen']['name']]['has_auto_taxobox'])?1:0,
        'only_author'=>($xarr[$val['Spidergen']['name']]['only_user'])?1:0,
        'page_exists'=>($xarr[$val['Spidergen']['name']]['page_exists'])?1:0,
        'has_type_spec'=>($xarr[$val['Spidergen']['name']]['has_type_spec'])?1:0,
        'needs_spec_reloc'=>($xarr[$val['Spidergen']['name']]['needs_spec_relocation'])?1:0
      ));
      $this->Spidergen->save();
    }
     * 
     * END OF UPDATE ALL
     * 
     */
  }
}

?>