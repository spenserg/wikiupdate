<form method="post" action="/spider" style="display:none">
  <input type="submit" id="refresh_button" name="next_id" value="<?=(isset($next) ? ($next - 1) : $info['nmbe_id'])?>" />
</form>
<form method="post" action="/spider">
<?php if($info['data']['bug_id']) { ?>
  <h4 style="display:inline;">Check <a target='_blank' href='<?php
echo (($info['data']['bug_id'] == NULL) ? ("https://bugguide.net/index.php?q=search&keys=" . $info['genus'] . "&edit%5Btype%5D%5Bbgpage%5D=on") :
("https://bugguide.net/node/view/" . $info['data']['bug_id']))?>'>BugGuide</a></h4>
  &nbsp;&nbsp;<input type="text" value="<?php echo "<ref name=bugguide>{{cite web| title=Genus " . $info['genus'] .
    "| publisher=BugGuide| accessdate=" . date('Y-m-d') . "| url=https://bugguide.net/node/view/" . $info['data']['bug_id'] . "}}</ref>"?>" />
<?php } ?>
  <h3><?=$info['genus']?> (ID = <?=$info['nmbe_id']?>) <a target='_blank' href="https://wsc.nmbe.ch/genus/<?=$info['nmbe_id']?>">NMBE</a></h3>
  Next: <input type="number" name="next_id" id="next_id" value="<?=(isset($next) ? $next : $info['nmbe_id'] + 1)?>" />&nbsp;&nbsp;
  <button id="next_button" type="submit">Next</button>&nbsp;&nbsp;
  <button class="btn btn-danger" type="button" onclick="prev_click()">Previous</button>&nbsp;&nbsp;
  <button class="btn btn-success" type="button" onclick="refresh_page()">Refresh</button>
  <?php if (count($info['species']) == 1) { echo "<h4>Monotypic Genera - <span style='color:red'>TAXONBAR</span></h4>"; } ?>
  <?php if (count($info['species']) != 1 && $info['data']['wp_url'] == $info['genus'] && count($info['synonyms']) == 0) { echo "<br/>"; } ?>
  <input type="hidden" name="gen_id" value="<?=$info['data']['id']?>" /><br/>
  en.wikipedia.org/wiki/<input name="wp_url" type="text" value="<?=(($info['data']['wp_url'] == NULL) ? ((count($info['species']) == 1) ? ($info['species'][0]['name']) : $info['genus']) : $info['data']['wp_url'])
?>" />
<?php if (count($info['species']) <= 1) { ?>
  &nbsp;&nbsp;<a target='_blank' href="<?=$info['redir_url']?>&action=edit">EDIT</a><br/>
  Redir HTML: <textarea name="redir_html" rows="3"><?=$info['redir_html']?></textarea>&nbsp;{{R from move}}
<?php } ?><br/>
<?php if (count($info['synonyms']) > 0) { ?>
  Syn Redirect: <textarea name="syn_redir" rows="2"><?=$info['syn_redir']?></textarea>&nbsp;&nbsp;
<?php foreach($info['synonyms'] as $val) {
    $val = substr($val, 2); $val = substr($val, 0, strpos($val, "'"));
    echo '&nbsp;<a class="syn_link" target="_blank" href="https://en.wikipedia.org/w/index.php?title=' . $val . '&action=edit">' . $val . '</a>';
  } } ?><br/>
  Taxo Template URL: <input name="taxo_template_url" type="text" value="<?=$info['taxo_template_url']?>" />
<?php if ($info['data']['wp_url'] != $info['genus']) { echo " <b><-- <span style='color:red'>***CHECK AUTO TAXOBOX***</span></b>"; } ?><br/>
  Taxo Template: <textarea name="taxo_template" rows="2"><?=$info['taxo_template']?></textarea>
  <textarea name="de_orphan" rows="2"><?=$info['de_orphan_text']?></textarea><br/><br/>
  Taxobox: <textarea name="taxobox" rows="2" cols="50"><?=$info['taxobox']?></textarea><br/>
  <!-- Edit URL: <input name="wp_url" type="text" value="<?=$edit_url?>" /><br/><br/>-->
  Page HTML: <textarea name="page_html" rows="5" cols="50"><?=$info['article']?></textarea>&nbsp;&nbsp;
  <a target='_blank' href="https://en.wikipedia.org/w/index.php?title=<?=(($info['data']['wp_url'] == NULL) ? ((count($info['species']) == 1) ? ($info['species'][0]['name']) : $info['genus']) : $info['data']['wp_url'])
?>&action=edit">EDIT</a><br/><br/>
  Talk Page: <textarea name="talk_page" rows="3" cols="50"><?=$info['talk_page']?></textarea>&nbsp;&nbsp;
  <a target='_blank' href="https://en.wikipedia.org/w/index.php?title=Talk:<?=(($info['data']['wp_url'] == NULL) ? ((count($info['species']) == 1) ? ($info['species'][0]['name']) : $info['genus']) : $info['data']['wp_url'])
?>&action=edit">EDIT</a><br/>
  <!-- Redir URL: <input name="redir_url" type="text" value="https://en.wikipedia.org/w/index.php?action=edit&title=<?=$taxobox['species'][0][1]?>" /><br/><br/> -->
<?php if (count($info['species']) > 1) { ?>
  <!-- Species: <textarea name="species" rows="2" cols="50"><?=$info['s_list']?></textarea><br/> -->
<?php } ?>
  <!-- New wiki: <input name="url_name" id="wpurl" type="text" value="/wiki/<?=substr($gen['Spidergen']['wp_url'],30)?>" />&nbsp;&nbsp;<button type="button" onclick="add_rem_spid()">(spider)</button><br/><br/> -->
<br/><button type="submit">Next</button>
</form>

<script>
  function add_rem_spid(){
    if ($("#wpurl").val().includes("(spider)")){
      $("#wpurl").val($("#wpurl").val().slice(0,$("#wpurl").val().length-9));
    }else{
      $("#wpurl").val($("#wpurl").val()+" (spider)");
    }
  }

  function prev_click() {
    $("#next_id").val(parseInt($("#next_id").val()) - 2);
    $("#next_button").click();
  }

  function refresh_page() {
    $("#refresh_button").click();
  }
</script>