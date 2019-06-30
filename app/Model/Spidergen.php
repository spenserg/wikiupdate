<?php
/**
 * Spidergen Model
 * 
 * app/Model/Spidergen.php
 */

class Spidergen extends AppModel {
  
  function after_spider_info($si) {
    // Author Ref Links
    $auth_links = "";
    foreach($si['gen_ref'] as $key=>$val) {
      if (strpos($key, "last") !== false){
        $sub_index = ((strpos($key, 'editor') === false) ? 4 : 11);
        $auth_link = $this->Spiderauth->get_link($si['gen_ref']['first' . (array_key_exists('first' . substr($key, $sub_index), $si['gen_ref']) ? substr($key, $sub_index) : "")] . " " . $val);
        if (strpos($auth_link, "[[") !== false) {
          //De-link
          $si['gen_ref']['author-link' . substr($key, $sub_index)] = str_replace(" ", "_", str_replace("[[", "", str_replace("]]", "", explode("|", $auth_link)[0])));
          $auth_links .= "| author-link" . substr($key, $sub_index) . "=" . str_replace(" ", "_", str_replace("[[", "", str_replace("]]", "", explode("|", $auth_link)[0])));
        }
      }
    }
    if (strlen($auth_links) > 0) {
      $si['gen_ref']['ref'] = substr($si['gen_ref']['ref'], 0, strlen($si['gen_ref']['ref']) - 8) . $auth_links . "}}</ref>";
    }

    //Talk Page data
    $html = get_html("https://en.wikipedia.org/wiki/Talk:" . $si['data']['wp_url']);
    $si['talk_info'] = get_first_match($html, '/Wikipedia\:WikiProject[\s\_]Spiders\"\s*title\s*\=\s*\"Wikipedia\:WikiProject[\s\_]Spiders\"\>WikiProject\sSpiders\<\/a\>\s*\<\/td\>\s*\<th\s*style\s*\=\s*\"text\-align\s*\:\s*left\;\s*width\:50\%\;\s*padding\:0\.3em\s*0\.3em\s*0\.3em\s*0\;\"\>\(Rated\s*([^\)]+)\-class\,\s*([^\)]+)\-importance\)\<\/th/');

    //Synonyms
    $html = get_html("https://wsc.nmbe.ch/genus/" . $si['nmbe_id']);

    $refs_used = [$si['gen_ref']['name']];
    $si['synonyms'] = [];
    if ($tmp = get_first_match($html,'/In\ssynonymy:([\s\S]+)Gen\.\s\<strong\>/U')) {
      foreach(get_all_matches($tmp, '/\<b\>\<i\>([^\s]+)\<\/i\>\<\/b\>\s*([^\s][^\=]+)\=[^\"]+\"\/genus\/([\d]+)\/([^\"]+)\"\>\s*\<b>\s*\<i\>[^\<]+\<\/i\>\s*\<\/b\>\s*\<\/a\>\s*[^\(]+\(\<a\s*href\s*\=\s*\"\/reference\/([\d]+)\"\>[^\:]+\:\s*([\d]+)\s*[^\d]/U') as $x) {
        if (!in_array($x[1], $si['synonyms']) && $x[1] != $si['genus']) {
          $ref_html = get_html('https://wsc.nmbe.ch/reference/' . $x[5]);
          $ref_info = parse_ref(get_first_match($ref_html, '/h6\>Requested\s*reference<\/h6\>\s*\<div\sclass\s*\=\s*\"reference\"\>\s*\<p\>([\s\S]+)<a title=/'), true, $x[6]);
          array_push($si['synonyms'], "''" . $x[1] . "'' <small>" . trim($x[2]) . "</small>" .
            ((in_array($ref_info['name'], $refs_used)) ? ("<ref name=" . $ref_info['name'] . " />") : $ref_info['ref'])
          );
          array_push($refs_used, $ref_info['name']);
        }
      }
    }
    $si['taxobox']['keys']['synonyms'] = "";
    if (count($si['synonyms']) > 0) {
      $si['taxobox']['keys']['synonyms'] = "\n*" . implode("\n*", $si['synonyms']);
      $si['taxobox']['keys']['synonyms_ref'] = "<ref name=NMBE />";
    }
    return $si;
  }
  
  function which_taxon($nmbe_id, $t1, $t2) {
    if ($t1 == $t2 || $t1 == NULL) { return $t2; }
    if ($t2 == NULL) { return $t1; }
    $hits = [0, 0];
    $data = array(
      $t1 => array('id' => 0, 'taxon_id' => $t1, 'html' => get_html(get_url('q', $t1))),
      $t2 => array('id' => 1, 'taxon_id' => $t2, 'html' => get_html(get_url('q', $t2)))
    );
    if ($cur_gen = $this->find('first', array('conditions' => array('nmbe_id' => $nmbe_id)))) {
      foreach($data as $val) {
        //EOL
        $tmp_eol_id = get_first_match($val['html'], '/href\x*\=\x*\"https\:\/\/eol\.org\/pages\/([\d]+)\"/');
        if ($tmp_eol_id == $cur_gen['Spidergen']['eol_id'] && $tmp_eol_id != NULL) { $hits[$val['id']]++; }

        //BugGuide
        $tmp_bug_id = get_first_match($val['html'], '/href\s*\=\s*\"https\:\/\/bugguide\.net\/node\/view\/([\d]+)\"/');
        if ($tmp_bug_id == $cur_gen['Spidergen']['bug_id'] && $tmp_bug_id != NULL) { $hits[$val['id']]++; }

        //Taxonbar
        $tmp_taxon_id = get_first_match($val['html'], '/\"wgPageName\"\s*\:\s*\"Q([\d]+)\"/');
        if ($tmp_taxon_id == $cur_gen['Spidergen']['taxon_id'] && $tmp_taxon_id != NULL) { $hits[$val['id']]++; }

        //Name and Auth
        if (get_first_match($val['html'], "/(" . $cur_gen['Spidergen']['name'] . ")/")) { $hits[$val['id']]++; }
        if (get_first_match($val['html'], "/(" . $cur_gen['Spidergen']['auth'] . ")/")) { $hits[$val['id']]++; }
      }
      return (($hits[0] > $hits[1]) ? $t1 : $t2);
    } else { return NULL; }
  }

  function get_wiki_info($nmbe_id = null, $si = []) {
    if ($nmbe_id === null) { return ""; }

    if ($tmp_data = $this->Spidergen->find('first', array('conditions' => array('nmbe_id' => $nmbe_id)))) {
      $si = spider_info($nmbe_id, $tmp_data);
      $si['data'] = $tmp_data['Spidergen'];

      // Wikipedia
      if ($tmp_data['Spidergen']['wp_url'] != NULL) {
        // If a WP page exists
        $qhtml = "";
        $whtml = get_html(get_url('w', $tmp_data['Spidergen']['wp_url']));

        // WSC LSID
        if ($lsid = get_first_match($whtml, '/urn\:lsid\:nmbe\.ch\:spidergen\:(\d+)\"/')) {
          if ($tmp_data['Spidergen']['id'] != $lsid) {
            $this->read(null, $tmp_data['Spidergen']['id']);
            $this->set(array('nmbe_lsid' => $lsid));
            $this->save();
          }
          if ($wsc_data = json_decode(get_html('https://wsc.nmbe.ch/api/lsid/urn:lsid:nmbe.ch:spidergen:' . $lsid . '?apiKey=f2a6635302ee0690176c42322239023dg4JCXbafDb'), true)) {
            if ($tmp_fam = $this->Spiderfam->find('first', array('conditions' => array('id' => $si['data']['family_id'])))) {
              if (intval($tmp_fam['Spiderfam']['nmbe_lsid']) != intval(substr($wsc_data['taxon']['familyObject']['famLsid'], 27))) {
                $this->Spiderfam->read(null, $tmp_fam['Spiderfam']['id']);
                $this->Spiderfam->set(array('nmbe_lsid' => substr($wsc_data['taxon']['familyObject']['famLsid'], 27)));
                $this->Spiderfam->save();
              }
            }
          }
        }

        // WP TAXON ID
        $tmp_taxon_id = get_first_match($whtml, '/href\s*\=\s*\"https\:\/\/www\.wikidata\.org\/wiki\/Q([\d]+)\"/');
        if ($tmp_taxon_id != $tmp_data['Spidergen']['taxon_id']) {
          if ($tmp_data['Spidergen']['taxon_id'] == NULL) {
            $tmp_data['Spidergen']['taxon_id'] = $tmp_taxon_id;
            $this->read(null, $tmp_data['Spidergen']['id']);
            $this->set(array('taxon_id' => $tmp_taxon_id));
            $this->save();
          } else {
            debug("WP TAXON ID (" . $tmp_taxon_id . ")!= DB TAXON ID (" . $tmp_data['Spidergen']['taxon_id'] .")");
            $tmp_taxon_id = $this->which_taxon($tmp_data['Spidergen']['id'], $tmp_taxon_id, $tmp_data['Spidergen']['taxon_id']);
          }
        } // end of if taxonid = db taxon id

        if ($tmp_taxon_id != NULL) {
          $qhtml = get_html(get_url('q', $tmp_taxon_id));

          // BugGuide
          $tmp_bug_id = get_first_match($qhtml, '/href\s*\=\s*\"https\:\/\/bugguide\.net\/node\/view\/([\d]+)\"/');
          if ($tmp_bug_id != $tmp_data['Spidergen']['bug_id']) {
            if ($tmp_data['Spidergen']['bug_id'] == NULL) {
              $tmp_data['Spidergen']['bug_id'] = $tmp_bug_id;
              $this->read(null, $tmp_data['Spidergen']['id']);
              $this->set(array('bug_id' => $tmp_bug_id));
              $this->save();
            } else {
              debug("WP BUG ID (" . $tmp_bug_id . ")!= DB BUG ID (" . $tmp_data['Spidergen']['bug_id'] .")");
              $tmp_bug_id = NULL;
            }
          }
          
          // EOL
          $tmp_eol_id = get_first_match($qhtml, '/href\s*\=\s*\"https\:\/\/eol\.org\/pages\/([\d]+)\"/');
          if ($tmp_eol_id != $tmp_data['Spidergen']['eol_id']) {
            if ($tmp_data['Spidergen']['eol_id'] == NULL) {
              $tmp_data['Spidergen']['eol_id'] = $tmp_eol_id;
              $this->read(null, $tmp_data['Spidergen']['id']);
              $this->set(array('eol_id' => $tmp_eol_id));
              $this->save();
            } else {
              debug("WP EOL ID (" . $tmp_eol_id . ")!= DB EOL ID (" . $tmp_data['Spidergen']['eol_id'] .")");
              $tmp_eol_id = NULL;
            }
          }
        }
      } else {
        debug ("WP URL IS NULL FOR " . $tmp_data['Spidergen']['name'] . "| NMBE_ID: " . $tmp_data['Spidergen']['nmbe_id']);
      } // end of if w url != null
    } else {
      $si = spider_info($nmbe_id);
    }
    $si = $this->after_spider_info($si);

    // Mygalomorph / Araneomorph
    $g_cat = "";
    $m_fams = ['Antrodiaetidae', 'Atypidae', 'Mecicobothriidae', 'Actinopodidae',
      'Atracidae', 'Barychelidae', 'Ctenizidae', 'Cyrtaucheniidae', 'Dipluridae',
      'Euctenizidae', 'Halonoproctidae', 'Hexathelidae', 'Idiopidae', 'Macrothelidae',
      'Microstigmatidae', 'Migidae', 'Nemesiidae', 'Paratropididae', 'Porrhothelidae', 'Theraphosidae'];
    $stub_fams = ['Araneidae', 'Gnaphosidae', 'Linyphiidae', 'Lycosidae', 'Oonopidae', 'Pholcidae',
      'Sparassidae', 'Theraphosidae', 'Theridiidae', 'Thomisidae'];
    if (in_array($si['family'], $m_fams)) {
      $g_cat .= "Mygalomorphae";
    } else if ($si['family'] == 'Liphistiidae') {
      $g_cat .= "Mesothelae";
    } else {
      $g_cat .= "Araneomorphae";
    }
    $si['fam_nickname'] = $this->Spiderfam->get_nickname($si['family']);
    $num_species = 1;
    $num_subspecies = 0;

    // Linking auths
    $auth_ignore = [];
    $tmp_links = $this->Spiderauth->add_links($si['taxobox']['keys']['authority']);
    $si['taxobox']['keys']['authority'] = $tmp_links['auth'];
    if (count($si['species']) > 1) {
      $num_species--;
      $tmp_links = $this->Spiderauth->add_links($si['type_species']['auth'], $tmp_links['ignore']);
      $si['type_species']['auth'] = $tmp_links['auth'];
      $auth_ignore = $tmp_links['ignore'];
      $si['taxobox']['keys']['type_species_authority'] = $si['type_species']['auth'];
      if (count($si['species']) < 4) {
        $si['taxobox']['keys']['subdivision'] = "{{Specieslist";
      }
      foreach($si['species'] as $xk => $xv) {
        if (count(explode(" ", $xv['name'])) == 2) {
          $num_species++;
        } else if (count(explode(" ", $xv['name'])) == 3) {
          $num_subspecies++;
        } else {
          debug('CHECK SPECIES (NO SPACES OR >2 SPACES): "' . $xv['name'] . '"');
        }
        $tmp_links = $this->Spiderauth->add_links($xv['auth'], $auth_ignore);
        $si['species'][$xk]['auth'] = $tmp_links['auth'];
        $auth_ignore = $tmp_links['ignore'];
        if (count($si['species']) < 4) {
          $si['taxobox']['keys']['subdivision'] .= "\n| [[" . $xv['name'] . "|" .
          substr($xv['name'], 0, 1) . ". " . trim(explode(" ", $xv['name'])[1]) . "]]|<small>" .
          $si['species'][$xk]['auth'] . "</small> – " . $xv['location'];
        }
      }
      if (count($si['species']) < 4) { $si['taxobox']['keys']['subdivision'] .= "}}"; }
    } else {
      $tmp_links = $this->Spiderauth->add_links($si['taxobox']['keys']['parent_authority'], $tmp_links['ignore']);
      $si['taxobox']['keys']['parent_authority'] = $tmp_links['auth'];
    }
    foreach($si['synonyms'] as $t_key=>$t_syns) {
      $tmp_links = $this->Spiderauth->add_links(get_first_match($t_syns, '/<small>([\s\S]+)<\/small>/'));
      $si['synonyms'][$t_key] = str_replace(
        get_first_match($t_syns, '/<small>([\s\S]+)<\/small>/'), $tmp_links['auth'], $si['synonyms'][$t_key]
      );
    }
    if (count($si['synonyms']) > 0) {
      $si['taxobox']['keys']['synonyms'] = "\n*" . implode("\n*", $si['synonyms']);
    }

    $si['article'] = build_taxobox($si['taxobox']) . "\n'''''" . $si['genus'] . "''''' is a " .
      (($num_species == 1) ? "[[monotypic taxon|monotypic]] " : "") . "[[genus]] of ";

    $si['locations'] = $this->Location->parse_locations($si['species']);
    $si['location_comden'] = $this->Location->get_common_denom($si['locations']);
    if ($si['location_comden']['Location']['id'] != 297) {
      // Prevent over-linking
      $si['location_comden'] = (($num_species > 1) ? $this->Location->get_dem_link($si['location_comden']) : $si['location_comden']['Location']['demonym']);
      $si['article'] .= $si['location_comden'] . " ";
    } else {
      $si['location_comden'] = "";
    }

    if ($si['fam_nickname']) {
      $si['article'] .= "[[" . $si['family'] . "|" . $si['fam_nickname'] . "]]";
    } else {
      if (in_array($si['family'], ['Austrochilidae', 'Dictynidae', 'Nicodamidae', 'Psechridae', 'Titanoecidae'])) {
        $si['article'] .= "[[cribellum|cribellate]] ";
      }
      $si['article'] .= "[[" . $g_cat . "|" .
      (($g_cat == "Mesothelae") ? "mesothelian" : strtolower(substr($g_cat, 0, -2))) .
       "]] spiders in the [[" . $si['family'] . "]] family";
    }
    
    // Monotypic genera
    if ($num_species == 1) {
      $si['article'] .= " containing the single species, '''''" . $si['species'][0]['name'] . 
        "'''''. It";
    } else if ($si['fam_nickname']){
      $si['article'] .= " that";
    } else {
      $si['article'] .= ", and";
    }

    // Authority link
    $si['article'] .= " was first described by ";
    $auths = [];
    foreach($si['gen_ref'] as $index=>$value) {
      if (substr($index, 0, 4) == "last") {
        array_push($auths, $this->Spiderauth->get_link(trim($si['gen_ref']['first' . substr($index, 4)]) . " " . trim($value), false));
      }
    }
    array_push($si['categories'], 'Category:Spiders described in ' . (($num_species != 1) ? $si['gen_ref']['year'] : get_first_match($si['type_species']['auth'], '/(\d{4})/')));
    array_push($auths, $si['gen_ref']['year']);
    for ($i = 0; $i < count($auths); $i++) {
      if ($i < count($auths) - 1) {
        if ($i == (count($auths) - 2) && count($auths) > 2) {
          $si['article'] .= " & ";
        }
        $si['article'] .= $auths[$i];
        if ($i < (count($auths) - 3) && count($auths) > 3) {
          $si['article'] .= ", ";
        } // Format: [name1, name2, name3, year]
      }// Format: [name1, name2, year]
    }// Format: [name1, year]
    $si['article'] .= " in " . trim($auths[count($auths) - 1]);
    $lhtml = $this->Location->list_to_html($si['locations']);
    $si['article'] .= ((($num_species == 1) && $lhtml != '[[]]') ? "," : ".") . $si['gen_ref']['ref'];
    if ($num_species > 3) {
      $si['article'] .= "\n\n==Species==\n";
    }

    $si['nmbe_ref'] = "{{cite web| title=Gen. " . $si['genus'] . " " . $si['auth'] .
      "| website=World Spider Catalog Version 20.0| accessdate=" . date("Y-m-d") .
      "| year=" . date("Y") . "| publisher=Natural History Museum Bern| url=http://www.wsc.nmbe.ch/genus/" .
      $si['nmbe_id'] . "| doi=10.24436/2}}";

    $lhtml = str_ireplace("in [[", "[[",
      str_ireplace("in [[New Caledonia]]", "on [[New Caledonia]]", str_ireplace("in [[Madagascar]]", "on [[Madagascar]]"
      , str_ireplace("[[", "in [[",
      str_ireplace("[[Azores]]", "the [[Azores]]", str_ireplace("[[United Kingdom]]", "the [[United Kingdom]]",
      str_ireplace("[[United States]]", "the [[United States]]", str_ireplace("[[Philippines]]", "the [[Philippines]]", str_ireplace("[[Congo]]", "[[Central Africa|Middle Africa]]",
      $lhtml)))))))));

    // Monotypic genera
    $si['s_list'] = "";
    if ($num_species == 1) {
      if (strlen(trim($lhtml)) > 0) {
        $si['article'] .= " and has only been found " . $lhtml . ".";
      } else {
        $si['article'] = str_replace(",<ref", ".<ref", $si['article']);
      }
      $si['article'] .= "<ref name=NMBE>" . $si['nmbe_ref'] . "</ref>";
    } else {
      // Species List
      $si['s_list'] .= (($num_species < 4) ? " " : "") . as_of() .
        " it contains " . (($num_species < 4) ? "only " : "") .
        trim(spellnumber($num_species)) . " species";
      if ($num_subspecies > 0) {
        $si['s_list'] .= " and " . spellnumber($num_subspecies) . " subspecies";
      }
      if (strlen(trim($lhtml)) > 0) {
        $si['s_list'] .= ", " . (($num_species == 2) ? "both " : "") . "found " . $lhtml;
      }

      if ($num_species < 4) {
        // Species in Text
        $last = "";
        $si['s_list'] .= ": ";
        foreach($si['species'] as $ks=>$vs) {
          $explas = explode(" ", $last);
          if ($last != "") {
            $si['s_list'] .= (($ks < 2) ? "" : ", ") . "''" . 
            ((count($explas) == 2) ? ("[[" . $last ."|") : "") .
            strtoupper(substr($last, 0, 1)) . ". ";
            if (count($explas) == 2) {
              $si['s_list'] .= strtolower($explas[1]) . "]]";
            } else if (count($explas) == 3){
              $si['s_list'] .= substr(strtolower($explas[1]), 0, 1) . ". " . strtolower(explode(" ", $last)[2]);
            }
            $si['s_list'] .= "''";
          }
          $last = $vs['name'];
        }
        $explas = explode(" ", $last);
        $si['s_list'] .= ((count($si['species']) == 2) ? "" : ",") . " and ''" . 
          ((count($explas) == 2) ? ("[[" . $last . "|") : "") . strtoupper(substr($last, 0, 1)) . ". " .
          ((count($explas) == 2) ? (strtolower($explas[1]) . "]]") : (substr(strtolower($explas[1]), 0, 1) . ". " . strtolower($explas[2]))) .
          "''.<ref name=NMBE>" . $si['nmbe_ref'] . "</ref>";
      } else {
        // List of Species
        $si['s_list'] .= ":<ref name=NMBE>" . $si['nmbe_ref'] . "</ref>";
        foreach($si['species'] as $val) {
          $si['s_list'] .= "\n*";
          $tmp_names = explode(" ", $val['name']);
          if (count($tmp_names) == 3) {
            // Sub-Species
            $si['s_list'] .= "*''[[" . $tmp_names[0] . " " . $tmp_names[1] . "|" .
              $tmp_names[0] . " " . substr($tmp_names[1], 0, 1) . ". " . $tmp_names[2] . "]]''";
          } else {
            $si['s_list'] .= "''[[" . $val['name'];
            if ($num_species > 50) {
              $si['s_list'] .= "|" . substr($tmp_names[0], 0, 1) . ". " . $tmp_names[1];
            }
            $si['s_list'] .= "]]''";
          }
          $si['s_list'] .= " <small>" . $val['auth'] . "</small>";
          if ($si['type_species']['name'] == $val['name']) {
            $si['s_list'] .= " ([[Type_species|type]])";
          }
          $si['s_list'] .= " – " . $val['location'];
        }
      }
    }
    $si['article'] .= $si['s_list'];

    // SI - Bugguide
    $si['bugguide'] = false;
    foreach($si['locations'] as $val) {
      $si['bugguide'] = ($si['bugguide'] || $this->Location->is_inside($val, 'North America'));
      if ($si['bugguide']) { break; }
    }

    // References
    $tmp_fam_link = fam_list_link($si['family'], $si['genus']);
    if ($tmp_fam_link) {
      $si['article'] .= "\n\n==See also==\n* [[" . $tmp_fam_link . "]]";
    }
    $si['article'] .= "\n\n==References==\n{{Reflist}}\n";

    // External Links
    //$si['article'] .= $si['external_links'];
    /*
    $si['article'] .= "\n==External links==\n*''[https://wsc.nmbe.ch/genus/" . $si['data']['nmbe_id'] . " " .
      $si['data']['name'] . "]'' at the [[World Spider Catalog]]\n";
    if ($si['data']['eol_id'] != NULL) {
      $si['article'] .= "*{{EOL|" . $si['data']['eol_id'] . "}}\n";
    }
    if ($si['bugguide'] && $si['data']['bug_id'] != NULL) {
      $si['article'] .= "*[https://bugguide.net/node/view/" . $si['data']['bug_id'] . " " . $si['genus'] . "] at [[BugGuide]]\n";
    }
     */

    if ($si['wikidata_id']) {
      $si['article'] .= "\n{{Taxonbar| from" . ((strpos($si['wikidata_id'], "from2") !== false) ? "1" : "") . "=" . $si['wikidata_id'] . "}}\n\n";
    }

    // Update num_species
    if ($num_species != $si['data']['num_species']) {
      $this->read(null, $si['data']['id']);
      $this->set(array('num_species' => $num_species));
      $this->save();
    }

    // Categories
    array_push($si['categories'],
      "Category:" . $si['family'],
      "Category:" . (($num_species == 1) ? "Monotypic " : "") . $g_cat . " genera"
    );
    $si['categories'] = array_merge($si['categories'], $this->Spiderauth->get_cats($auths));

    $si['categories'] = array_unique($si['categories']);
    sort($si['categories']);
    foreach($si['categories'] as $val) {
      $si['article'] .= "[[" . $val . "]]\n";
    }
    if (trim(strtolower($si['talk_info'][1]) != "start")) {
      $si['article'] .= "\n\n{{" .
        (($si['family'] == "Salticidae") ? "Jumping-spider" : (in_array($si['family'], $stub_fams) ? $si['family'] : $g_cat)) . "-stub}}";
    }
    return $si;
  }
}