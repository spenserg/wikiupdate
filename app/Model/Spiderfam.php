<?php
/**
 * Spiderfam Model
 * 
 * app/Model/Spidergfam.php
 */

class Spiderfam extends AppModel {
  
  function get_nickname($fam_id) {
    if ($fam_id === null) { return ""; }
    $tmp_f = (is_string($fam_id) ? 'name' : 'id');
    if ($fam = $this->find('first', array('conditions' => array($tmp_f => $fam_id)))) {
      if ($fam['Spiderfam']['nickname'] != NULL) { return $fam['Spiderfam']['nickname']; }
      //if (in_array($fam['Spiderfam']['name'], ['Austrochilidae', 'Dictynidae', 'Nicodamidae', 'Psechridae', 'Titanoecidae'])) {
        //return "cribellate spiders";
      //}
    }
    return "";
  }

  function get_info($id = 1) {
    $result = $this->find('first', array('conditions' => array('nmbe_id' => $id)));
    if (!$result) { return null; }
    $result = $result['Spiderfam'];
    $g_cat = "Araneomorphae";
    $m_fams = ['Antrodiaetidae', 'Atypidae', 'Mecicobothriidae', 'Actinopodidae',
      'Atracidae', 'Barychelidae', 'Ctenizidae', 'Cyrtaucheniidae', 'Dipluridae',
      'Euctenizidae', 'Halonoproctidae', 'Hexathelidae', 'Idiopidae', 'Macrothelidae',
      'Microstigmatidae', 'Migidae', 'Nemesiidae', 'Paratropididae', 'Porrhothelidae', 'Theraphosidae'];
    if (in_array($result['name'], $m_fams)) {
      $g_cat = "Mygalomorphae";
    } else if ($result['name'] == 'Liphistiidae') {
      $g_cat = "Mesothelae";
    }
    $result['cat_page'] = "Members of the family " . 
      $result['name'] . " in the Suborder " .
      $g_cat . "\n\n{{Cat main|" . $result['name'] . 
      "}}\n{{Commons cat|" . $result['name'] .
      "}}\n\n[[Category:" . $g_cat . "]]";
    $result['url'] = 'en.wikipedia.org/w/index.php?title=Category:' . $result['name'] . '&action=edit';
    return $result;
  }
}