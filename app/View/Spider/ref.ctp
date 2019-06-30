Old Ref: <input type="text" value="<?=$old?>" disabled><br/>
Wiki Ref: <textarea rows="4" cols="40"><?=((array_key_exists('ref', $ref)) ? $ref['ref'] : "")?></textarea><br/>
<form method="POST" action="/spider/ref">
  Cite: <input type="text" name="cite" value="" /><br/>
  <button type="submit">GO</button>
</form>