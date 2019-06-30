<?php
/**
 * Location Model
 * 
 * app/Model/Location.php
 */

class Location extends AppModel {
  
  function get_project_text($si) {
    $si['talk_page'] = "";
    $cd = $this->Location->get_common_denom($si['locations']);
    $si['talk_page'] .= "{{WPSpiders| class=" . strtolower($si['talk_info'][1]) . "| importance=" . strtolower($si['talk_info'][2]) .
      "| needs-photo=" . ((count($si['image']) == 0) ? "yes" : "no") . "}}";
    $wikiprojects = [];
    $casia = 0;
    $seasia = 0;
    $sasia = 0;
    $wasia = 0;
    
    foreach($si['locations'] as $val) {
      if (in_array($val['Location']['id'], [1, 13, 15, 16, 27, 31, 37, 45, 63, 77, 78, 79, 80, 82, 85, 87, 88, 91, 92, 93, 94, 96,
          106, 107, 118, 125, 134, 135, 137, 154, 174, 175, 176, 178, 183, 184, 194, 199,
          210, 214, 224, 235, 239, 252, 262, 264, 268, 271, 272, 280, 283, 285, 313, 546])) {
        if (!array_key_exists('Asia', $wikiprojects)) {
          $wikiprojects['Asia'] = "{{WikiProject Asia| class=" . strtolower($si['talk_info'][1]) . "| importance=low| needs-photo=" . ((count($si['image']) == 0) ? "yes" : "no");
        }
        if ($val['Location']['id'] == 37) { $wikiprojects['Asia'] .= "| china=yes| china-importance=low"; } // China
        if ($val['Location']['id'] == 262) { $wikiprojects['Asia'] .= "| hong-kong=yes| hong-kong-importance=low"; } // Hong Kong
        if ($val['Location']['id'] == 85) { $wikiprojects['Asia'] .= "| japan=yes| japan-importance=low"; } // Japan
        if ($val['Location']['id'] == 264) { $wikiprojects['Asia'] .= "| korea=yes| korea-importance=low"; } // Korea
        if ($val['Location']['id'] == 210) { $wikiprojects['Asia'] .= "| north-korea=yes| north-korea-importance=low"; } // North Korea
        if ($val['Location']['id'] == 91) { $wikiprojects['Asia'] .= "| south-korea=yes| south-korea-importance=low"; } // South Korea
        if ($val['Location']['id'] == 175) { $wikiprojects['Asia'] .= "| taiwan=yes| taiwan-importance=low"; } // Taiwan
        if ($val['Location']['id'] == 272) { $wikiprojects['Asia'] .= "| russia=yes| russia-importance=low"; } // Russia

        // Southeast Asia
        if (in_array($val['Location']['id'], [27, 31, 78, 94, 106, 178, 194, 214, 252, 268, 280, 313])) {
          if (in_array($val['Location']['id'], [94, 27])) { // Laos and Brunei
            if (!array_key_exists('SEAsia', $wikiprojects)) {
              $wikiprojects['SEAsia'] = "{{WikiProject Southeast Asia| class=" . strtolower($si['talk_info'][1]) . "| importance=low| needs-photo=" . ((count($si['image']) == 0) ? "yes" : "no");
            }
            if ($val['Location']['id'] == 94) { $wikiprojects['SEAsia'] .= "| Laos=yes| Laos-importance=low"; } // Laos
            if ($val['Location']['id'] == 27) { $wikiprojects['SEAsia'] .= "| Brunei=yes| Brunei-importance=low"; } // Brunei
            $seasia = 1;
          } else {
            if ($val['Location']['id'] == 94) { $wikiprojects['Asia'] .= "| bangladesh=yes| bangladesh-importance=low"; } // Bangladesh
            if ($val['Location']['id'] == 239) { $wikiprojects['Asia'] .= "| bhutan=yes| bhutan-importance=low"; } // Bhutan
            //if ($val['Location']['id'] == 77) { $wikiprojects['Asia'] .= "| india=yes| india-importance=low"; } // India
            if ($val['Location']['id'] == 107) { $wikiprojects['Asia'] .= "| maldives=yes| maldives-importance=low"; } // Maldives
            if ($val['Location']['id'] == 125) { $wikiprojects['Asia'] .= "| nepal=yes| nepal-importance=low"; } // Nepal
            if ($val['Location']['id'] == 135) { $wikiprojects['Asia'] .= "| pakistan=yes| pakistan-importance=low"; } // Pakistan
            if ($val['Location']['id'] == 224) { $wikiprojects['Asia'] .= "| sri-lanka=yes| sri-lanka-importance=low"; } // Sri Lanka
          }

          if ($seasia == 0) {
            $wikiprojects['Asia'] .= "| southeast-asia=yes| southeast-asia-importance=low";
            $seasia = 1;
          }
          if ($val['Location']['id'] == 27) { $wikiprojects['Asia'] .= "| brunei=yes| brunei-importance=low"; } // Brunei
          if ($val['Location']['id'] == 31) { $wikiprojects['Asia'] .= "| cambodia=yes| cambodia-importance=low"; } // Cambodia
          if ($val['Location']['id'] == 252) { $wikiprojects['Asia'] .= "| east-timor=yes| east-timor-importance=low"; } // East-Timor
          if ($val['Location']['id'] == 78) { $wikiprojects['Asia'] .= "| indonesia=yes| indonesia-importance=low"; } // Indonesia
          if ($val['Location']['id'] == 94) { $wikiprojects['Asia'] .= "| laos=yes| laos-importance=low"; } // Laos
          if ($val['Location']['id'] == 106) { $wikiprojects['Asia'] .= "| malaysia=yes| malaysia-importance=low"; } // Malaysia
          if ($val['Location']['id'] == 268) { $wikiprojects['Asia'] .= "| myanmar=yes| myanmar-importance=low"; } // Myanmar
          if ($val['Location']['id'] == 214) { $wikiprojects['Asia'] .= "| philippines=yes| philippines-importance=low"; } // Philippines
          if ($val['Location']['id'] == 280) { $wikiprojects['Asia'] .= "| singapore=yes| singapore-importance=low"; } // Singapore
          if ($val['Location']['id'] == 178) { $wikiprojects['Asia'] .= "| thailand=yes| thailand-importance=low"; } // Thailand
          if ($val['Location']['id'] == 194) { $wikiprojects['Asia'] .= "| vietnam=yes| vietnam-importance=low"; } // Vietnam
        }

        // South Asia
        if (in_array($val['Location']['id'], [16, 77, 107, 125, 135, 224, 239])) {
          if ($sasia == 0) {
            $wikiprojects['Asia'] .= "| south-asia=yes| south-asia-importance=low";
            $sasia = 1;
          }
          if ($val['Location']['id'] == 16) { $wikiprojects['Asia'] .= "| bangladesh=yes| bangladesh-importance=low"; } // Bangladesh
          if ($val['Location']['id'] == 239) { $wikiprojects['Asia'] .= "| bhutan=yes| bhutan-importance=low"; } // Bhutan
          if ($val['Location']['id'] == 77) { $wikiprojects['Asia'] .= "| india=yes| india-importance=low"; } // India
          if ($val['Location']['id'] == 107) { $wikiprojects['Asia'] .= "| maldives=yes| maldives-importance=low"; } // Maldives
          if ($val['Location']['id'] == 125) { $wikiprojects['Asia'] .= "| nepal=yes| nepal-importance=low"; } // Nepal
          if ($val['Location']['id'] == 135) { $wikiprojects['Asia'] .= "| pakistan=yes| pakistan-importance=low"; } // Pakistan
          if ($val['Location']['id'] == 224) { $wikiprojects['Asia'] .= "| sri-lanka=yes| sri-lanka-importance=low"; } // Sri Lanka
        }

        // Western Asia
        if (in_array($val['Location']['id'], [1, 13, 15, 45, 63, 79, 80, 82, 87, 92, 96, 134, 137, 154, 174, 183, 199, 235, 271, 283, 546])) {
          if ($wasia == 0) {
            $wikiprojects['Asia'] .= "| western-asia=yes| western-asia-importance=low";
            $wasia = 1;
          }
          if ($val['Location']['id'] == 1) { $wikiprojects['Asia'] .= "| afghanistan=yes| afghanistan-importance=low"; } // Afghanistan
          if ($val['Location']['id'] == 235) { $wikiprojects['Asia'] .= "| armenia=yes| armenia-importance=low"; } // Armenia
          if ($val['Location']['id'] == 13) { $wikiprojects['Asia'] .= "| azerbaijan=yes| azerbaijan-importance=low"; } // Azerbaijan
          if ($val['Location']['id'] == 15) { $wikiprojects['Asia'] .= "| bahrain=yes| bahrain-importance=low"; } // Bahrain
          if ($val['Location']['id'] == 45) { $wikiprojects['Asia'] .= "| cyprus=yes| cyprus-importance=low"; } // Cyprus
          if ($val['Location']['id'] == 63) { $wikiprojects['Asia'] .= "| georgia=yes| georgia-importance=low"; } // Georgia
          if ($val['Location']['id'] == 546) { $wikiprojects['Asia'] .= "| abkhazia=yes| abkhazia-importance=low"; } // Abkhazia
          if ($val['Location']['id'] == 79) { $wikiprojects['Asia'] .= "| iran=yes| iran-importance=low"; } // Iran
          if ($val['Location']['id'] == 80) { $wikiprojects['Asia'] .= "| iraq=yes| iraq-importance=low"; } // Iraq
          if ($val['Location']['id'] == 82) { $wikiprojects['Asia'] .= "| israel=yes| israel-importance=low"; } // Israel
          if ($val['Location']['id'] == 137) { $wikiprojects['Asia'] .= "| palestine=yes| palestine-importance=low"; } // Palestine
          if ($val['Location']['id'] == 87) { $wikiprojects['Asia'] .= "| jordan=yes| jordan-importance=low"; } // Jordan
          if ($val['Location']['id'] == 92) { $wikiprojects['Asia'] .= "| kuwait=yes| kuwait-importance=low"; } // Kuwait
          if ($val['Location']['id'] == 96) { $wikiprojects['Asia'] .= "| lebanon=yes| lebanon-importance=low"; } // Lebanon
          if ($val['Location']['id'] == 134) { $wikiprojects['Asia'] .= "| oman=yes| oman-importance=low"; } // Oman
          if ($val['Location']['id'] == 271) { $wikiprojects['Asia'] .= "| qatar=yes| qatar-importance=low"; } // Qatar
          if ($val['Location']['id'] == 154) { $wikiprojects['Asia'] .= "| saudi-arabia=yes| saudi-arabia-importance=low"; } // Saudi Arabia
          if ($val['Location']['id'] == 174) { $wikiprojects['Asia'] .= "| syria=yes| syria-importance=low"; } // Syria
          if ($val['Location']['id'] == 183) { $wikiprojects['Asia'] .= "| turkey=yes| turkey-importance=low"; } // Turkey
          if ($val['Location']['id'] == 283) { $wikiprojects['Asia'] .= "| united-arab-emirates=yes| united-arab-emirates-importance=low"; } // UAE
          if ($val['Location']['id'] == 199) { $wikiprojects['Asia'] .= "| yemen=yes| yemen-importance=low"; } // Yemen
        }

        // Central Asia
        if (in_array($val['Location']['id'], [88, 93, 118, 176, 184, 285])) {
          if ($casia == 0) {
            $wikiprojects['Asia'] .= "| central-asia=yes| central-asia-importance=low";
            $casia = 1;
          }
          if ($val['Location']['id'] == 88) { $wikiprojects['Asia'] .= "| kazakhstan=yes| kazakhstan-importance=low"; } // Kazakhstan
          if ($val['Location']['id'] == 93) { $wikiprojects['Asia'] .= "| kyrgyzstan=yes| kyrgyzstan-importance=low"; } // Kyrgyzstan
          if ($val['Location']['id'] == 118) { $wikiprojects['Asia'] .= "| mongols=yes| mongols-importance=low"; } // Mongolia
          if ($val['Location']['id'] == 176) { $wikiprojects['Asia'] .= "| tajikistan=yes| tajikistan-importance=low"; } // Tajikistan
          if ($val['Location']['id'] == 184) { $wikiprojects['Asia'] .= "| turkmenistan=yes| turkmenistan-importance=low"; } // Turkmenistan
          if ($val['Location']['id'] == 285) { $wikiprojects['Asia'] .= "| uzbekistan=yes| uzbekistan-importance=low"; } // Uzbekistan
        }
      }

      // Wikiproject India
      if (in_array($val['Location']['id'], [77, 568, 573])) {
        if (!array_key_exists('India', $wikiprojects)) {
          $wikiprojects['India'] = "{{WikiProject India| class=" . strtolower($si['talk_info'][1]) . "| importance=low" .
            "| image-needed=" . ((count($si['image']) == 0) ? "yes" : "no") . "| assess-date=" . date('Y-m-d');
        }
        if (in_array($val['Location']['id'], [568, 573])) { $wikiprojects['Asia'] .= "| andaman=yes"; } // Andaman and Nicobar Islands
      }
        
/* TODO:
|cities=
|districts=
|maps=
|states=
 */
 
        if ($val['Location']['id'] == 314) { $wikiprojects['Australia'] .= "|andaman="; } // South Australia

      // Wikiproject Australia
      if (in_array($val['Location']['id'], [12, 318, 314, 305, 304, 303, 302, 301, 300])) {
        if (!array_key_exists('Australia', $wikiprojects)) {
          $wikiprojects['Australia'] = "{{WikiProject Australia| class=" . strtolower($si['talk_info'][1]) . "| importance=low| biota=y| biota-importance=low" .
            "| needs-photo=" . ((count($si['image']) == 0) ? "yes" : "no");
          //array_push($si['categories'], 'Category:Endemic fauna of Australia');
        }
        if ($val['Location']['id'] == 314) { $wikiprojects['Australia'] .= "| SA=yes| SA-importance=low"; } // South Australia
        if ($val['Location']['id'] == 305) { $wikiprojects['Australia'] .= "| NT=yes| NT-importance=low"; } // Northern Territory
        if ($val['Location']['id'] == 304) { $wikiprojects['Australia'] .= "| WA=yes| WA-importance=low"; } // Western Australia
        if ($val['Location']['id'] == 303) { $wikiprojects['Australia'] .= "| VIC=yes| VIC-importance=low"; } // Victoria
        if ($val['Location']['id'] == 302) {
          $wikiprojects['Australia'] .= "| TAS=yes| TAS-importance=low"; // Tasmania
          array_push($si['categories'], "Category:Invertebrates of Tasmania");
        }
        if ($val['Location']['id'] == 301) { $wikiprojects['Australia'] .= "| QLD=yes| QLD-importance=low"; } // Queensland
        if ($val['Location']['id'] == 300) { $wikiprojects['Australia'] .= "| NSW=yes| NSW-importance=low"; } // New South Wales
      }

      // Caribbean
      if ($val['Location']['id'] == 385) { // Puerto Rico
        $wikiprojects['Puerto Rico'] = "{{WikiProject Puerto Rico| class=" . strtolower($si['talk_info'][1]) . "| importance=low";
      }
      if (in_array($val['Location']['id'], [9, 11, 14, 17, 21, 43, 68, 84, 148, 151, 182, 215, 253, 254, 261, 350, 386, 434, 435, 436, 437, 470])) {
        if (!array_key_exists('Caribbean', $wikiprojects)) {
          $wikiprojects['Caribbean'] = "{{WikiProject Caribbean| class=" . strtolower($si['talk_info'][1]) . "| importance=low";
        }
        $cayman = false;
        if ($val['Location']['id'] == 9) { $wikiprojects['Caribbean'] .= "| Antigua and Barbuda=yes| Antigua and Barbuda-importance=low"; }
        if ($val['Location']['id'] == 14) { $wikiprojects['Caribbean'] .= "| Bahamas=yes| Bahamas-importance=low"; }
        if ($val['Location']['id'] == 17) { $wikiprojects['Caribbean'] .= "| Barbados=yes| Barbados-importance=low"; }
        if ($val['Location']['id'] == 43) { $wikiprojects['Caribbean'] .=  "| Cuba=yes| Cuba-importance=low"; }
        if ($val['Location']['id'] == 253) { $wikiprojects['Caribbean'] .=  "| Dominica=yes| Dominica-importance=low"; }
        if ($val['Location']['id'] == 254) { $wikiprojects['Caribbean'] .=  "| Dominican Republic=yes| Dominican Republic-importance=low"; }
        if ($val['Location']['id'] == 68) { $wikiprojects['Caribbean'] .=  "| Grenada=yes| Grenada-importance=low"; }
        if ($val['Location']['id'] == 261) { $wikiprojects['Caribbean'] .=  "| Haiti=yes| Haiti-importance=low"; }
        if ($val['Location']['id'] == 84) { $wikiprojects['Caribbean'] .=  "| Jamaica=yes| Jamaica-importance=low"; }
        if ($val['Location']['id'] == 215) { $wikiprojects['Caribbean'] .=  "| Saint Kitts and Nevis=yes| Saint Kitts and Nevis-importance=low"; }
        if ($val['Location']['id'] == 148) { $wikiprojects['Caribbean'] .=  "Saint Lucia=yes| Saint Lucia-importance=low"; }
        if ($val['Location']['id'] == 151) { $wikiprojects['Caribbean'] .=  "| Saint Vincent=yes| Saint Vincent-importance=low"; }
        if ($val['Location']['id'] == 182) { $wikiprojects['Caribbean'] .=  "| Trinidad and Tobago=yes| Trinidad and Tobago-importance=low"; }
        if ($val['Location']['id'] == 470) { $wikiprojects['Caribbean'] .=  "| Martinique=yes| Martinique-importance=low"; }
        if ($val['Location']['id'] == 350) { $wikiprojects['Caribbean'] .=  "| Guadeloupe=yes| Guadeloupe-importance=low"; }
        if (!$cayman && in_array($val['Location']['id'], [386, 434, 435, 436, 437])) { $cayman=true; $wikiprojects['Caribbean'] .=  "| Cayman Islands=yes| Cayman Islands-importance=low"; }
        if ($val['Location']['id'] == 21) { $wikiprojects['Caribbean'] .=  "| Bermuda=yes| Bermuda-importance=low"; }
        if ($val['Location']['id'] == 11) { $wikiprojects['Caribbean'] .=  "| Aruba=yes| Aruba-importance=low"; }
      }

      // Wikiproject South America
      if (in_array($val['Location']['id'], [292, 10, 22, 26, 36, 40, 49, 74, 139, 171, 190, 193, 213, 326])) {
        if (!array_key_exists('South America', $wikiprojects)) {
          $wikiprojects['South America'] = "{{WikiProject South America| class=" . strtolower($si['talk_info'][1]) . "| importance=low";
        }
        if ($val['Location']['id'] == 10) { $wikiprojects['South America'] .= "| Argentina=yes| Argentina-importance=low"; }
        if ($val['Location']['id'] == 22) { $wikiprojects['South America'] .= "| Bolivia=yes| Bolivia-importance=low"; }
        if ($val['Location']['id'] == 26) { $wikiprojects['South America'] .= "| Brazil=yes| Brazil-importance=low"; }
        if ($val['Location']['id'] == 36) { $wikiprojects['South America'] .= "| Chile=yes| Chile-importance=low"; }
        if ($val['Location']['id'] == 40) { $wikiprojects['South America'] .= "| Colombia=yes| Colombia-importance=low"; }
        if ($val['Location']['id'] == 49) { $wikiprojects['South America'] .= "| Ecuador=yes| Ecuador-importance=low"; }
        if ($val['Location']['id'] == 326) { $wikiprojects['South America'] .= "| French Guiana=yes| French Guiana-importance=low"; }
        if ($val['Location']['id'] == 74) { $wikiprojects['South America'] .= "| Guyana=yes| Guyana-importance=low"; }
        if ($val['Location']['id'] == 139) { $wikiprojects['South America'] .= "| Paraguay=yes| Paraguay-importance=low"; }
        if ($val['Location']['id'] == 213) { $wikiprojects['South America'] .= "| Peru=yes| Peru-importance=low"; }
        if ($val['Location']['id'] == 171) { $wikiprojects['South America'] .= "| Suriname=yes| Suriname-importance=low"; }
        if ($val['Location']['id'] == 190) { $wikiprojects['South America'] .= "| Uruguay=yes| Uruguay-importance=low"; }
        if ($val['Location']['id'] == 193) { $wikiprojects['South America'] .= "| Venezuela=yes| Venezuela-importance=low"; }
      }

      // Wikiproject Africa
      if (in_array($val['Location']['id'], [4, 7, 20, 25, 29, 30, 32, 34, 35, 48, 52, 54, 61, 62, 65, 72, 73, 89, 97, 98, 99, 104, 105, 108, 112, 113, 121, 122, 123, 129, 144, 153, 156, 158, 159, 165, 166, 168, 170, 177, 179, 187, 198, 200, 205, 206, 207, 211, 220, 221, 240, 241, 242, 245, 248, 250, 257, 258, 288, 311, 310, 308, 309])) {
        if (!array_key_exists('Africa', $wikiprojects)) {
          $wikiprojects['Africa'] = "{{WikiProject Africa| class=" . strtolower($si['talk_info'][1]) . "| importance=low";
        }
        if ($val['Location']['id'] == 4) { $wikiprojects['Africa'] .= '| Algeria=yes| Algeria-importance=low'; }
        if ($val['Location']['id'] == 7) { $wikiprojects['Africa'] .= '| Angola=yes| Angola-importance=low'; }
        if ($val['Location']['id'] == 20) { $wikiprojects['Africa'] .= '| Benin=yes| Benin-importance=low'; }
        if ($val['Location']['id'] == 25) { $wikiprojects['Africa'] .= '| Botswana=yes| Botswana-importance=low'; }
        if ($val['Location']['id'] == 29) { $wikiprojects['Africa'] .= '| Burkina Faso=yes| Burkina Faso-importance=low'; }
        if ($val['Location']['id'] == 30) { $wikiprojects['Africa'] .= '| Burundi=yes| Burundi-importance=low'; }
        if ($val['Location']['id'] == 32) { $wikiprojects['Africa'] .= '| Cameroon=yes| Cameroon-importance=low'; }
        if ($val['Location']['id'] == 34) { $wikiprojects['Africa'] .= '| Central African Republic=yes| Central African Republic-importance=low'; }
        if ($val['Location']['id'] == 35) { $wikiprojects['Africa'] .= '| Chad=yes| Chad-importance=low'; }
        if ($val['Location']['id'] == 48) { $wikiprojects['Africa'] .= '| Djibouti=yes| Djibouti-importance=low'; }
        if ($val['Location']['id'] == 52) { $wikiprojects['Africa'] .= '| Eritrea=yes| Eritrea-importance=low'; }
        if ($val['Location']['id'] == 54) { $wikiprojects['Africa'] .= '| Ethiopia=yes| Ethiopia-importance=low'; }
        if ($val['Location']['id'] == 61) { $wikiprojects['Africa'] .= '| Gabon=yes| Gabon-importance=low'; }
        if ($val['Location']['id'] == 62) { $wikiprojects['Africa'] .= '| Gambia=yes| Gambia-importance=low'; }
        if ($val['Location']['id'] == 65) { $wikiprojects['Africa'] .= '| Ghana=yes| Ghana-importance=low'; }
        if ($val['Location']['id'] == 72) { $wikiprojects['Africa'] .= '| Guinea=yes| Guinea-importance=low'; }
        if ($val['Location']['id'] == 73) { $wikiprojects['Africa'] .= '| Guinea-Bissau=yes| Guinea-Bissau-importance=low'; }
        if ($val['Location']['id'] == 89) { $wikiprojects['Africa'] .= '| Kenya=yes| Kenya-importance=low'; }
        if ($val['Location']['id'] == 97) { $wikiprojects['Africa'] .= '| Lesotho=yes| Lesotho-importance=low'; }
        if ($val['Location']['id'] == 98) { $wikiprojects['Africa'] .= '| Liberia=yes| Liberia-importance=low'; }
        if ($val['Location']['id'] == 99) { $wikiprojects['Africa'] .= '| Libya=yes| Libya-importance=low'; }
        if ($val['Location']['id'] == 104) { $wikiprojects['Africa'] .= '| Madagascar=yes| Madagascar-importance=low'; }
        if ($val['Location']['id'] == 105) { $wikiprojects['Africa'] .= '| Malawi=yes| Malawi-importance=low'; }
        if ($val['Location']['id'] == 108) { $wikiprojects['Africa'] .= '| Mali=yes| Mali-importance=low'; }
        if ($val['Location']['id'] == 112) { $wikiprojects['Africa'] .= '| Mauritania=yes| Mauritania-importance=low'; }
        if ($val['Location']['id'] == 113) { $wikiprojects['Africa'] .= '| Mauritius=yes| Mauritius-importance=low'; }
        if ($val['Location']['id'] == 121) { $wikiprojects['Africa'] .= '| Morocco=yes| Morocco-importance=low'; }
        if ($val['Location']['id'] == 122) { $wikiprojects['Africa'] .= '| Mozambique=yes| Mozambique-importance=low'; }
        if ($val['Location']['id'] == 123) { $wikiprojects['Africa'] .= '| Namibia=yes| Namibia-importance=low'; }
        if ($val['Location']['id'] == 129) { $wikiprojects['Africa'] .= '| Nigeria=yes| Nigeria-importance=low'; }
        if ($val['Location']['id'] == 144) { $wikiprojects['Africa'] .= '| Rwanda=yes| Rwanda-importance=low'; }
        if ($val['Location']['id'] == 153) { $wikiprojects['Africa'] .= '| Sao Tome and Principe=yes| Sao Tome and Principe-importance=low'; }
        if ($val['Location']['id'] == 156) { $wikiprojects['Africa'] .= '| Senegal=yes| Senegal-importance=low'; }
        if ($val['Location']['id'] == 158) { $wikiprojects['Africa'] .= '| Seychelles=yes| Seychelles-importance=low'; }
        if ($val['Location']['id'] == 159) { $wikiprojects['Africa'] .= '| Sierra Leone=yes| Sierra Leone-importance=low'; }
        if ($val['Location']['id'] == 165) { $wikiprojects['Africa'] .= '| Somalia=yes| Somalia-importance=low'; }
        if ($val['Location']['id'] == 166) { $wikiprojects['Africa'] .= '| South Africa=yes| South Africa-importance=low'; }
        if ($val['Location']['id'] == 168) { $wikiprojects['Africa'] .= '| South Sudan=yes| South Sudan-importance=low'; }
        if ($val['Location']['id'] == 170) { $wikiprojects['Africa'] .= '| Sudan=yes| Sudan-importance=low'; }
        if ($val['Location']['id'] == 177) { $wikiprojects['Africa'] .= '| Tanzania=yes| Tanzania-importance=low'; }
        if ($val['Location']['id'] == 179) { $wikiprojects['Africa'] .= '| Togo=yes| Togo-importance=low'; }
        if ($val['Location']['id'] == 187) { $wikiprojects['Africa'] .= '| Uganda=yes| Uganda-importance=low'; }
        if ($val['Location']['id'] == 198) { $wikiprojects['Africa'] .= '| Western Sahara=yes| Western Sahara-importance=low'; }
        if ($val['Location']['id'] == 200) { $wikiprojects['Africa'] .= '| Zambia=yes| Zambia-importance=low'; }
        if ($val['Location']['id'] == 205) { $wikiprojects['Africa'] .= '| Comoros=yes| Comoros-importance=low'; }
        if ($val['Location']['id'] == 206) { $wikiprojects['Africa'] .= '| Equatorial Guinea=yes| Equatorial Guinea-importance=low'; }
        if ($val['Location']['id'] == 207) { $wikiprojects['Africa'] .= '| Gambia=yes| Gambia-importance=low'; }
        if ($val['Location']['id'] == 211) { $wikiprojects['Africa'] .= '| Niger=yes| Niger-importance=low'; }
        if ($val['Location']['id'] == 240) { $wikiprojects['Africa'] .= '| Cape Verde=yes| Cape Verde-importance=low'; }
        if ($val['Location']['id'] == 241) { $wikiprojects['Africa'] .= '| Cape Verde=yes| Cape Verde-importance=low'; }
        if ($val['Location']['id'] == 242) { $wikiprojects['Africa'] .= '| Republic of the Congo=yes| Republic of the Congo-importance=low'; }
        if ($val['Location']['id'] == 245) { $wikiprojects['Africa'] .= '| Republic of the Congo=yes| Republic of the Congo-importance=low'; }
        if ($val['Location']['id'] == 248) { $wikiprojects['Africa'] .= '| Ivory Coast=yes| Ivory Coast-importance=low'; }
        if ($val['Location']['id'] == 250) { $wikiprojects['Africa'] .= '| Ivory Coast=yes| Ivory Coast-importance=low'; }
        if ($val['Location']['id'] == 257) { $wikiprojects['Africa'] .= '| Eswatini=yes| Eswatini-importance=low'; } // Synonym
        if ($val['Location']['id'] == 258) { $wikiprojects['Africa'] .= '| Eswatini=yes| Eswatini-importance=low'; }
        if ($val['Location']['id'] == 288) { $wikiprojects['Africa'] .= '| Zimbabwe=yes| Zimbabwe-importance=low'; }
      }

      // Wikiproject Polynesia
      if (in_array($val['Location']['id'], [218, 181, 186])) {
        if (!array_key_exists('Polynesia', $wikiprojects)) {
          $wikiprojects['Polynesia'] = "{{WikiProject Polynesia| class=" . strtolower($si['talk_info'][1]) . "| importance=low| needs-image=" . ((count($si['image']) == 0) ? "yes" : "no");
        }
        if ($val['Location']['id'] == 218) { $wikiprojects['Polynesia'] .= '| Samoa=yes| Samoa-importance=low'; }
        if ($val['Location']['id'] == 181) { $wikiprojects['Polynesia'] .= '| Tonga=yes| Tonga-importance=low'; }
        if ($val['Location']['id'] == 186) { $wikiprojects['Polynesia'] .= '| Tuvalu=yes| Tuvalu-importance=low'; }
      }

      // Wikiproject Melanesia
      if (in_array($val['Location']['id'], [212, 164, 191, 324])) {
        if (!array_key_exists('Melanesia', $wikiprojects)) {
          $wikiprojects['Melanesia'] = "{{WikiProject Melanesia| class=" . strtolower($si['talk_info'][1]) . "| importance=low";
        }
        if ($val['Location']['id'] == 212) { $wikiprojects['Melanesia'] .= '| PNG=yes'; }
        if ($val['Location']['id'] == 164) { $wikiprojects['Melanesia'] .= '| SI=yes'; }
        if ($val['Location']['id'] == 191) { $wikiprojects['Melanesia'] .= '| Vanuatu=yes'; }
        if ($val['Location']['id'] == 324) { $wikiprojects['Melanesia'] .= '| NC=yes'; }
      }

      // Wikiproject China
      if ($val['Location']['id'] == 37) {
        $wikiprojects['China'] = "{{WikiProject China| class=" . strtolower($si['talk_info'][1]) . "| importance=low| image-needed=" . ((count($si['image']) == 0) ? "yes" : "no");
      }

      // Wikiproject New Zealand
      if ($val['Location']['id'] == 128) {
        $wikiprojects['New Zealand'] = "{{WikiProject New Zealand| class=" . strtolower($si['talk_info'][1]) . "| importance=low| needs-photo=" . ((count($si['image']) == 0) ? "yes" : "no");
      }
    }

    /*
    TODO: Single Location; no wikiprojects
    if (count($si['locations']) == 1 && count($wikiprojects) == 0) {
      $si['talk_page'] = "{{WikiProjectBannerShell| 1=\n" . $si['talk_page'] .
        "\n{{WikiProject " . $si['locations'][0]['Location']['name'] . "| class=" . strtolower($si['talk_info'][1]) . "| importance=low";
      if ($si['locations'][0]['Location']['name'] == "Australia") {
        $si['talk_page'] .= "| biota=y| biota-importance=low";
      }
      foreach(['needs-photo', 'needs-image', 'image-needed', 'photo-needed', 'image-requested'] as $talk_v) {
        $si['talk_page'] .= "| " . $talk_v . "=" . ((count($si['image']) == 0) ? "yes" : "no");
      }
      $si['talk_page'] .= "}}\n}}";
    }
    */

    if (count($wikiprojects) > 0){
      $si['talk_page'] = "{{WikiProjectBannerShell| 1=\n" . $si['talk_page'] . "\n" . implode("}}\n", $wikiprojects) . "}}\n}}";
    }
    return $si;
  }

  function get_dem_link($loc_id) {
    $result = "";
    if (($loc = $this->get_loc($loc_id))) {
      if ($loc['Location']['synonym_of'] !== NULL) {
        return $this->get_dem_link(intval($loc['Location']['synonym_of']));
      } else {
        if ($loc['Location']['demonym'] === NULL) {
          $par = $this->Locationlink->find('first', array('conditions' => array('child_id' => $loc['Location']['id'])));
          return $this->get_dem_link($this->find('first', array('conditions' => array('id' => $par['Locationlink']['parent_id']))));
        }
      }
      $pos = strpos($loc['Location']['demonym'], (($loc['Location']['wikilink'] == NULL) ? $loc['Location']['name'] : $loc['Location']['wikilink']));
      if ($pos !== false) {
        if ($pos > 0) {
          $result .= substr((($loc['Location']['wikilink'] == NULL) ? $loc['Location']['name'] : $loc['Location']['wikilink']), 0, $pos);
        }
        $result .= "[[" . substr($loc['Location']['demonym'], $pos, strlen((($loc['Location']['wikilink'] == NULL) ? $loc['Location']['name'] : $loc['Location']['wikilink']))) . "]]" .
          substr($loc['Location']['demonym'], ($pos + strlen((($loc['Location']['wikilink'] == NULL) ? $loc['Location']['name'] : $loc['Location']['wikilink']))));
      } else {
        $result = "[[" . (($loc['Location']['wikilink'] == NULL) ? $loc['Location']['name'] : $loc['Location']['wikilink']) . "|" . $loc['Location']['demonym'] . "]]";
      }
    }
    return $result;
  }
  
  function is_inside($loc, $inside) {
    $x = $this->get_parent_ids($this->get_loc($loc));
    $i_loc = $this->get_loc($inside);
    return in_array($i_loc['Location']['id'], $x);
  }

  function get_common_denom($locs) {
    $gcd_list = [];
    $input_type = 0;
    // 0 = list of name strings
    // 1 = list of id #s
    // 2 = list of location objects
    if (is_array($locs)) {
      foreach($locs as $val) {
        if (is_array($val)) {
          // list of arrays
          if (array_key_exists('Location', $val)) {
            $input_type = 2;
            array_push($gcd_list, $val['Location']['id']);
          } else {
            debug("get_common_denom() Input Unknown");
          }
        } else {
          if (intval($val) != 0) {
            // list of id #s
            $input_type = 1;
            $gcd_list = $val;
          } else {
            // list of string names
            $input_type = 0;
            if ($tmp_l = $this->find('first', array('conditions' => array('name' => ucfirst(strtolower(trim($val))))))) {
              array_push($gcd_list, $tmp_l['Location']['id']);
            } else {
              debug("get_common_denom() Input Unknown");
            }
          }
        }
      }
    } else {
      // Not Array Input
      if (strpos($locs, "|") !== false) {
        return $this->get_common_denom(explode("|", $locs));
      } else if (strpos($locs, ",") !== false) {
        return $this->get_common_denom(explode(",", $locs));
      } else {
        debug("get_common_denom() Input Unknown");
        return null;
      }
    }

    // Create List
    $result = $this->get_parent_ids($this->get_loc(array_pop($locs)));
    foreach($locs as $val) {
      $tmp_res = [];
      foreach($this->get_parent_ids($this->get_loc($val)) as $wal) {
        if (in_array($wal, $result)) {
          array_push($tmp_res, $wal);
        }
      }
      $result = $tmp_res;
    }

    // Find lowest on list
    $lowest = $this->get_loc(array_pop($result));
    foreach($result as $val) {
      if ($l = $this->get_loc($val)) {
        if ($l['Location']['type_level'] > $lowest['Location']['type_level']) {
          $lowest = $this->get_loc($l['Location']['id']);
        }
      }
    }
    return $lowest;
  }

  function get_parent_ids($loc = null, $id_only = true, $include_earth = true, $include_self = false) {
    $result = [];
    if ($l = $this->get_loc($loc)) {
      if ($include_self) {
        array_push($result, $l['Location']);
      }
      foreach($this->Locationlink->find('all', array('conditions' => array('child_id' => $l['Location']['id']))) as $val) {
        if ($val['Locationlink']['parent_id'] != 297 || $include_earth) {
          array_push($result, $this->get_loc($val['Locationlink']['parent_id'])['Location']);
          $result = array_merge($result, $this->get_parent_ids(intval($val['Locationlink']['parent_id']), false, $include_earth, false));
        }
      }
    }
    usort($result, function ($a, $b) {
      if (!$a) { return 1; }
      if (!$b) { return -1; }
      if ($a['type_level'] == $b['type_level']) {
        $ll = $this->Locationlink->find('first', array('conditions' => array('child_id' => $a['id'])));
        return (($ll['Locationlink']['parent_id'] == $b['id']) ? 1 : -1);
      }
      return ($a['type_level'] < $b['type_level']) ? -1 : 1;
    });

    if ($id_only) {
      $tmp_res = [];
      foreach($result as $val) {
        array_push($tmp_res, $val['id']);
      }
      $result = $tmp_res;
    }
    return array_unique($result, SORT_REGULAR);
  }

  function get_continent($loc_id, $include_prefix = false) {
    if (($loc = $this->get_loc($loc_id)) !== null) {
      if ($loc['Location']['synonym_of'] !== NULL) { return $this->get_continent($loc['Location']['synonym_of'], $include_prefix); }
      if ($loc['Location']['type_id'] == 2) { return ($include_prefix ? $loc : $loc['Location']); } else {
        if ($x = $this->Locationlink->find('first', array('conditions' => array('child_id' => $loc['Location']['id'])))) {
          return $this->get_continent($this->get_loc(intval($x['Locationlink']['parent_id'])), $include_prefix);
        }
      }
    }
    return null;
  }

  function parse_locations($spec_list) {
    $list = [];
    foreach($spec_list as $val) {
      if (is_array($val) && array_key_exists('location', $val)) {
        array_push($list, $val['location']);
      } else {
        array_push($list, $val);
      }
    }
    $result = [];
    foreach($list as $key=>$xal) {
      foreach(get_all_matches($xal, '/[^\(]+\(([^\)]+)\)/') as $val) {
        $list[$key] = trim(str_replace("(" . $val[1] . ")", "(" . str_replace(",", "|", $val[1]) . ")", $xal));
      }
      $rep_none = ["Introduced to", ". Introduced", "incl.", "mainland", "from ", "unknown"];
      $rep_div = [" to ", ".  ", " and ", " or ", "/"];
      $rep_is = ["Islands", "Island"];
      $rep_mtn = ["Mountains", "Mountain", "Mount", "Mtns.", "Mtns", "Mtn", "Mt."]; // Order is Important!!!
      $rep_dir = ["nw", "sw", "ne", "se"];
      $rep_other = array("st." => "Saint", "rep." => "Republic", "arch." => "Archipelago",
        "se asia" => "Southeast Asia",
        "south-eastern" => "Southeast", "south-western" => "Southwest", "north-eastern" => "Northeast", "north-western" => "Northwest",
        "south-east" => "Southeast", "south-west" => "Southwest", "north-east" => "Northeast", "north-west" => "Northwest",
        "southeastern" => "Southeast", "southwestern" => "Southwest", "northeastern" => "Northeast", "northwestern" => "Northwest"
      );
      foreach($rep_is as $a) {
        $xal = str_ireplace($a, "Is.", $xal);
      }
      foreach($rep_mtn as $a) {
        $xal = str_ireplace($a, "Mtn..", str_ireplace($a, "Mtn.", $xal));
      }
      foreach($rep_dir as $a) {
        // Directional drops: "se europe" => "europe", etc.
        if (strtolower(substr($a, 0, 3)) == ($a . " ")) {
          $xal = substr($xal, 3);
        }
      }
      foreach($rep_none as $a) {
        $xal = trim(str_ireplace($a, "", $xal));
      }
      foreach($rep_div as $a) {
        $xal = str_ireplace($a, ",", $xal);
      }
      foreach($rep_other as $k=>$v) {
        $xal = str_ireplace($k, $v, $xal);
      }
      $list[$key] = ucwords(strtolower(str_replace(",", ", ", str_replace("(", "( ", $xal))));
    }

    // Replace commas with delimiters
    foreach($list as $key=>$val) {
      $counter = 0;
      while(get_first_match($val, '/(\([^\)]*\,[^\)]*\))/') && $counter < 30) {
        $counter++;
        $val = preg_replace('/(\([^\)]*)\,([^\)]*\))/', "$1|$2", $val);
      }
      $list[$key] = $val;
    }

    $keep_arr = ['eastern europe', 'southern australia', 'northern territory', 'western australia', 'western sahara',
      'east africa', 'east asia', 'southeast asia', 'west indies', 'west africa',
      'east holmes is.', 'east holmes reef', 'west holmes is.', 'west holmes reef',
      'south flinders is.', 'south flinders reef', 'south moore is.', 'south moore reef',
      'north flinders is.', 'north flinders reef', 'north moore is.', 'north moore reef',
      'south australia', 'new south wales', 'south america', 'south sudan', 'south africa', 'south korea',
      'north africa', 'north america', 'north korea', 'far east', 'central europe',
      'central africa', 'central america', 'central african republic'
    ];
    $loc_count = [];
    $missing_locs = [];
    foreach($list as $val) {
      foreach(explode(",", $val) as $wal) {
        if (strpos($wal, "?") === false && stripos($wal, "probably") === false && stripos($wal, "possibly") === false){ // (If unknown, exclude loc)
          $subs = [];
          if (strpos($wal, "(") === false) {
            $wal = trim($wal);
            foreach(["northern", "southern", "western", "eastern", "north", "south", "west", "east", "central"] as $a) {
              if (!in_array(strtolower($wal), $keep_arr)) {
                $wal = trim(str_ireplace($a, "", $wal));
              }
            }
            if (strlen($wal) > 0) {
              if ($z = $this->find('first', array('conditions' => array('name' => $wal)))) {
                while ($z['Location']['synonym_of'] != NULL) {
                  $z = $this->find('first', array('conditions' => array('id' => $z['Location']['synonym_of'])));
                }
                if (!in_array($z, $result)) {
                  array_push($result, $z);
                }
                if (!array_key_exists($z['Location']['id'], $loc_count)) {
                  // Count appearances of loc
                  $loc_count[$z['Location']['id']] = 0;
                }
                $loc_count[$z['Location']['id']]++;
              } else { // Missing Main Location
                if (!array_key_exists("MAIN", $missing_locs)) {
                  $missing_locs["MAIN"] = [];
                }
                if (!in_array($wal, $missing_locs["MAIN"])) {
                  array_push($missing_locs["MAIN"], trim($wal));
                }
              }
            }
          } else { // XX ( YYY )
            $tmp_sub = explode("(", trim(str_replace(")", "", $wal)));
            $tmp_sub[0] = trim($tmp_sub[0]);
            foreach(["northern", "southern", "western", "eastern", "north", "south", "west", "east", "central"] as $uqa) {
              if (!in_array(strtolower($tmp_sub[0]), $keep_arr)) {
                $tmp_sub[0] = trim(str_ireplace($uqa, "", $tmp_sub[0]));
              }
            }
            $z = $this->find('first', array('conditions' => array('name' => $tmp_sub[0])));
            if (!($z)) {
              // Missing Main
              if (!array_key_exists("MAIN", $missing_locs)) {
                $missing_locs["MAIN"] = [];
              }
              if (!in_array($tmp_sub[0], $missing_locs["MAIN"])) {
                array_push($missing_locs["MAIN"], $tmp_sub[0]);
              }
            } else {
              while ($z['Location']['synonym_of'] != NULL) {
                $z = $this->find('first', array('conditions' => array('id' => $z['Location']['synonym_of'])));
              }
              if (!in_array($z, $result)) {
                array_push($result, $z);
              }
              // Count appearances of loc
              if (!array_key_exists($z['Location']['id'], $loc_count)) {
                $loc_count[$z['Location']['id']] = 0;
              }
              $loc_count[$z['Location']['id']]++;
            }
            foreach(explode("|", trim($tmp_sub[1])) as $xal) {
              $xal = trim($xal);
              foreach(["northern", "southern", "western", "eastern", "north", "south", "west", "east", "central"] as $uqa) {
                if (!in_array(strtolower($xal), $keep_arr)) {
                  $xal = trim(str_ireplace($uqa, "", $xal));
                }
              }
              if (strlen($xal) > 0) {
                $z = $this->find('first', array('conditions' => array('name' => trim($xal))));
                if ($z) {
                  while ($z['Location']['synonym_of'] != NULL) {
                    $z = $this->find('first', array('conditions' => array('id' => $z['Location']['synonym_of'])));
                  }
                  if (!in_array($z, $result)) {
                    array_push($result, $z);
                  }
                } else { // Missing Sub Location
                  if (!array_key_exists($tmp_sub[0], $missing_locs)) {
                    $missing_locs[$tmp_sub[0]] = [];
                  }
                  if (!in_array(trim($xal), $missing_locs[$tmp_sub[0]])) {
                    array_push($missing_locs[$tmp_sub[0]], trim($xal));
                  }
                }
              }
            }
          }
        }
      }
    }
    if (count($missing_locs) > 0) {
      debug("MISSING LOCS:");
      debug($missing_locs);
    }
    return $result;
  }

  function get_countries($locs) {
    $result = [];
    if (!is_array($locs)) { $locs = (array)$locs; }
    foreach((array)$locs as $val) {
      $tmp_loc = $this->get_loc($val);
      if ($tmp_loc['Location']['type_id'] == 3) {
        array_push($result, $tmp_loc['Location']['name']);
      } else {
        foreach($this->Locationlink->find('all', array('conditions' => array('child_id' => $tmp_loc['Location']['id']))) as $wal) {
          array_merge($result, (array)$this->get_countries($this->get_loc($wal['Locationlink']['parent_id'])));
        }
      }
    }
    return array_unique($result);
  }

  function get_country($loc_id, $include_prefix = false) {
    if (($loc = $this->get_loc($loc_id)) !== null) {
      if ($loc['Location']['synonym_of'] !== NULL) { return $this->get_country($loc['Location']['synonym_of'], $include_prefix); }
      if ($loc['Location']['type_id'] == 3) { return ($include_prefix ? $loc : $loc['Location']); } else {
        if ($x = $this->Locationlink->find('first', array('conditions' => array('child_id' => $loc['Location']['id'])))) {
          return $this->get_country($this->get_loc(intval($x['Locationlink']['parent_id'])), $include_prefix);
        }
      }
    }
    return null;
  }

  function is_country($loc_id) {
    if ($l = get_loc($loc_id)) {
      return ($l['Location']['type_id'] == 3);
    }
    return false;
  }

  function short_list($list) {
    if (count($list) == 1) {
      if ($t = $this->get_country($list[0])) {
        return array(0 => $t['name']);
      } else {
        return array(0 => $list[0]);
      }
    }
    $c = [];
    $result = [];
    foreach($list as $key=>$val) {
      if($x = $this->get_country($val)) {
        if (!array_key_exists($x['name'], $c)) {
          $c[$x['name']] = 0;
        }
        $c[$x['name']]++;
      }
    }
    if (count($c) < 4) {
      // < 4 Countries
      foreach($c as $key=>$val) {
        array_push($result, $key);
      }
    } else {
      // Continents
      $d = [];
      foreach($c as $key=>$val) {
        if($y = $this->get_continent($key)) {
          if (!array_key_exists($y['name'], $d)) {
            $d[$y['name']] = 0;
          }
          $d[$y['name']]++;
        }
      }
      foreach($d as $key=>$val) {
        if ($val == 1) {
          foreach($c as $k=>$v) {
            if ($this->get_continent($k)['name'] == $key) {
              array_push($result, $k);
            }
          }
        } else {
          array_push($result, $key);
        }
      }
    } 
    return $result;
  }

  function get_loc($loc_id) {
    // Accepts name, id, Location array
    if (!$loc_id) { return null; }
    $loc = null;
    if (is_string($loc_id)) {
      if (intval($loc_id) == 0) {
        // find by name
        if (strpos($loc_id, "(") !== false) {
          $loc_id = trim(explode("(", $loc_id)[0]);
        }
        $loc = $this->find('first', array('conditions' => array('name' => ucwords(strtolower(trim($loc_id))))));
      } else {
        // string value of numerical id
        return $this->get_loc(intval($loc_id));
      }
    } else if (is_integer($loc_id)) {
      //find by id
      $loc = $this->find('first', array('conditions' => array('id' => $loc_id)));
    } else if (is_array($loc_id)) {
      if (array_key_exists('Location', $loc_id)) {
        // Location array
        $loc = $loc_id;
      } else if (array_key_exists('demonym', $loc_id)) {
        // Location array without "Location"
        $loc = $this->get_loc($loc_id['id']);
      } else { return null; }
    } else { return null; }
    if ($loc) {
      if ($loc['Location']['synonym_of'] !== NULL) {
        return $this->get_loc(intval($loc['Location']['synonym_of']));
      }
      $ltype = $this->Locationtype->find('first', array('conditions' => array('id' => $loc['Location']['type_id'])));
      $loc['Location']['type_level'] = $ltype['Locationtype']['level'];
      return $loc;
    } else { return null; }
  }

  function list_to_html($locs = null, $wikilinks = true, $max = 5) {
    $tmp_res = [];
    $loc_list = [];
    foreach (((is_string($locs)) ? explode(",", $locs) : $locs) as $val) {
      if ($l = $this->get_loc(is_array($val) ? $val : trim($val))) {
        $pids = $this->get_parent_ids($l, true, false, true);
        array_push($loc_list, $pids);
        if (!array_key_exists($pids[0], $tmp_res)) {
          $tmp_res[$pids[0]] = [];
        }
        if (count($pids) == 1) {
          array_push($tmp_res[$pids[0]], null);
        } else if (!in_array($pids[1], $tmp_res[$pids[0]])) {
          array_push($tmp_res[$pids[0]], $pids[1]);
        }
      }
    }

    // Nulls and singles
    $result = [];
    $done = false;
    while (!$done) {
      $done = true;
      $tmp_res2 = $tmp_res;
      foreach($tmp_res2 as $key=>$val) {
        if (in_array(null, $val)) {
          array_push($result, $key);
          unset($tmp_res[$key]);
          $done = false;
        } else if (count($val) == 1) {
          $inc_arr = [];
          foreach($loc_list as $wal) {
            if ($index_of = array_search($val[0], $wal)) {
              array_push($inc_arr, (($index_of == (count($wal) - 1)) ? null : $wal[$index_of + 1]));
            }
          }
          $tmp_res[$val[0]] = array_unique($inc_arr);
          unset($tmp_res[$key]);
          $done = false;
        }
      }
    }

    // Multiple IDs
    $left = $max - count($result) - count($tmp_res);
    foreach($tmp_res as $key=>$val) {
      if (count($val) <= $left - 1) {
        $result = array_merge($result, $val);
      } else {
        array_push($result, $key);
      }
    }

    // To HTML
    $result_str = [];
    $index = -1;
    $tmp_count = 0;
    $prefix = null;
    foreach($result as $y) {
      $index++;
      if ($x = $this->get_loc($y)) {
        $x = $x['Location'];
        $tmp_res = "";
        $tmp_count++;
        $tmp_prefix = "in"; // type_id = 2, 3, 4, 5, 6, 8, 9, 10, 11, 13
        if (in_array($x['type_id'], [1, 7, 12, 14]) || in_array($x['id'], [9, 45, 56, 68, 104, 107, 109, 110, 124, 136, 148, 151, 158, 164, 181, 182, 186, 191, 205, 215])) {
          $tmp_prefix = "on";
        }
        if ($x['id'] == 62) { // Add special note for The Gambia
          $tmp_prefix .= '<!-- Not a typo- the capital "T" in "The Gambia" was started in the mid-1960s, and is more common than a lowercase "t" in "the Gambia" -->'; 
        }
        $tmp_res .= (($index == (count($result) - 1) && $tmp_count > 1) ? "and " : "");
        if ($tmp_prefix != $prefix) {
          $prefix = $tmp_prefix;
          $tmp_res .= $tmp_prefix . " ";
        }
        if ((in_array($x['type_id'], [1, 7, 12, 13, 14]) || in_array($x['id'], [14, 34, 107, 110, 158, 164, 189, 192, 198, 214, 225, 242, 244, 245, 248, 254, 283, 291, 305, 350, 403, 539, 540]))
            && !in_array($x['type_id'], [350, 359, 365, 411, 640])) {
          $tmp_res .= "the ";
        }
        if ($wikilinks) {
          $tmp_res .= "[[";
          if ($x['id'] == 248) {
            $tmp_res .= "Ivory Coast]]"; // Hack to solve a UTF-8 translation problem with special characters in "Côte d'Ivoire"
          } else {
            if ($x['wikilink'] != null && $x['wikilink'] != $x['name']) {
              $tmp_res .= $x['wikilink'] . "|";
            }
            $tmp_res .= $x['name'] . "]]";
          }
        }
        array_push($result_str, $tmp_res);
      }
    }
    return join(((count($result) > 2) ? ", " : " "), $result_str);
  }
}