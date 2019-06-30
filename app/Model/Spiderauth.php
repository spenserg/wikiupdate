<?php
/**
 * Spiderauth Model
 * 
 * app/Model/Spiderauth.php
 */

class Spiderauth extends AppModel {

  function get_link($auth = "", $last_only = true) {
    $auth_arr = ((strpos($auth, " ") === false) ? array($auth) : explode(" ", $auth));
    $a = $this->find('first', array('conditions' => array('ref' => $auth_arr[count($auth_arr) - 1])));
    if (!$a) {
      $a = $this->find('first', array('conditions' => array('ref' => $auth)));
    }
    if (!$a && count($auth_arr) == 2) {
      // D. Hirst, B. Baehr, M. Baehr, etc.
      $a = $this->find('first', array('conditions' => array('ref' => (substr(strtoupper($auth_arr[0]), 0, 1) . ". " . ucfirst(strtolower($auth_arr[1]))))));
      if (!$a) {
        //$a = $this->find('all', array('conditions' => array('ref LIKE' => '%' . ucfirst(strtolower($auth_arr[1])) . '%')));
        //TODO check for last name only, and use if there is only one hit
      }
    }
    if ($a) {
      if ($a['Spiderauth']['wikilink'] === NULL) {
        // No Link
        return ($last_only ? ($auth_arr[count($auth_arr) - 1]) : $auth);
      }
      $result = "[[" . $a['Spiderauth']['wikilink'];
      if ($last_only) {
        if ($a['Spiderauth']['wikilink'] != $a['Spiderauth']['ref']) {
          $result .= "|" . $a['Spiderauth']['ref'];
        }
      } else {
        if ($a['Spiderauth']['wikilink'] != $a['Spiderauth']['full_name']) {
          $result .= "|" . $a['Spiderauth']['full_name'];
        }
      }
      return $result . "]]";
    }
    return $auth;
  }

  function add_links($auth, $ignore = []) {
    if (!is_array($ignore)) { $ignore = []; }
    $result = array('auth' => $auth, 'ignore' => $ignore);
    foreach(get_all_matches($auth, "/([^\,\&\(\)0-9]+)/") as $val) {
      $val[1] = trim($val[1]);
      if (!in_array($val[1], $ignore)) {
        if ($val[1] != "" && $xauth = $this->find('first', array('conditions' => array('ref' => $val[1])))) {
          if ($xauth['Spiderauth']['wikilink'] != NULL) {
            $result['auth'] = str_replace($val[1], "[[" . $xauth['Spiderauth']['wikilink'] . "|" . $val[1] . "]]", $result['auth']);
          }
          array_push($result['ignore'], $val[1]);
        }
      }
    }
    return $result;
  }

  function get_auths($str) {
    $result = "";
    $list = explode("|", str_replace(",", "|", str_replace("&", "|",
      ((preg_match('/\\d/', $str) > 0) ? substr(trim($str), 0, -6) : trim($str))
    )));
    for($i = 0; $i < count($list); $i++) {
      $result .= $this->get_link(trim($list[$i]), true);
      if ($i < count($list) - 1) {
        $result .= (($i < count($list) - 2) ? ", " : " & ");
      }
    }
    return $result;
  }

  function get_cats($arr) {
    $result = [];
    foreach($arr as $val) {
      $val = trim(str_replace("'", " ", str_replace("[", " ", str_replace("]", " ", $val))));
      if ($a = $this->find('first', array('conditions' => array('OR' => array('ref' => $val, 'wikilink' => $val, 'full_name' => $val))))) {
        if ($a['Spiderauth']['cat_name']) {
          array_push($result, "Category:" . $a['Spiderauth']['cat_name']);
        }
      }
    }
    return array_unique($result);
  }

}
