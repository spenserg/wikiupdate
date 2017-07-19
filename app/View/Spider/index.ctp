<?php if ($has_image){ ?>
<h1>HAS IMAGE</h1>
<?php } ?>

<form method="post" action="/admin/index/">
  <h3><?=$taxobox['genus'][1]?> (<?=$gen['Spidergen']['nmbe_id']?>) [<?=$y+1?> left]</h3>
  
  Wiki URL: <input name="wp_url" type="text" value="<?=$gen['Spidergen']['wp_url']?>" /><br/><br/>
  Taxo URL: <input name="taxo_url" type="text" value="<?=$taxobox['auto_taxobox_url']?>" /><br/><br/>
  Taxobox: <textarea name="taxobox" rows="5"><?=$taxobox['auto_taxobox']?></textarea><br/><br/>
  <!--Edit URL: <input name="wp_url" type="text" value="<?=$edit_url?>" /><br/><br/>-->
  Page HTML: <textarea name="page_html" rows="5"><?=$taxobox['new_page']?></textarea><br/><br/>
  WPSpiders: <input name="talk_page" type="text" value="<?=$taxobox['talk_page']?>" /><br/><br/>
  Redir URL: <input name="redir_url" type="text" value="https://en.wikipedia.org/w/index.php?action=edit&title=<?=$taxobox['species'][0][1]?>" /><br/><br/>
  Redir HTML: <textarea name="redir_url" rows="3"><?=$redir_html?></textarea><br/><br/>
  New wiki: <input name="url_name" id="wpurl" type="text" value="/wiki/<?=substr($gen['Spidergen']['wp_url'],30)?>" />&nbsp;&nbsp;<button type="button" onclick="add_rem_spid()">(spider)</button><br/><br/>
  <button type="submit">Next</button><br/>
  <div>Next: <input type="number" name="x" value="<?=$x?>" /><br/><br/></div>
  <input name="y" type="hidden" value="<?=$y?>" />
  <input name="cur_id" type="hidden" value="<?=$gen['Spidergen']['id']?>" />
</form>

<script>
  function add_rem_spid(){
    if ($("#wpurl").val().includes("(spider)")){
      $("#wpurl").val($("#wpurl").val().slice(0,$("#wpurl").val().length-9));
    }else{
      $("#wpurl").val($("#wpurl").val()+" (spider)");
    }
  }
</script>