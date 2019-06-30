<h3><?=$fam['name']?> (<?=$num_gens?> Gens)</h3>
<form method="post" action="/spider/fams">
  <input type="text" value="https://en.wikipedia.org/wiki/<?=$fam['name']?>" /><br/>
  <b>Taxobox:</b><br/><textarea rows="4" cols="40"><?=$taxobox?></textarea><br/><br/>
  <b>Genera:</b><br/><textarea rows="8" cols="40"><?=$str?></textarea><br/><br/>
  <b>List of Gens:</b><input value="https://en.wikipedia.org/w/index.php?title=List_of_<?=$fam['name']?>_species&action=edit" /><br/>
  <textarea rows="4" cols="40"><?=$detail_list?></textarea><br/><br/>
  <div>Next: <input type="number" name="next_id" value="<?=$next_id?>" /></div><br/>
  <button type="submit">Next</button><br/>
</form>
