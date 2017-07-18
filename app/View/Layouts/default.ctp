<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
  
  <?php 
  echo $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css');
  echo $this->Html->css('https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
  echo $this->Html->css('/css/main.css');
  ?>
  
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js"></script>

</head>
<body<?php if ($this->request->params['action'] == 'view_game'){
  echo ' class="gameview'.(($game['style']==NULL)?'':'-'.$game['style']).'"';
} ?>>
<?php if ($this->request->params['action'] != 'index'){ ?>
  <nav class="navbar navbar-default">
    <div class="container" style="height:50px; width:100%;">
      <div class="navbar-header"><!--
        <span style="font-family:Spac3;font-size:40px;color:yellow">game</span>
        <span style="color:green;font-size:40px;font-family:ArcadeClassic;">Vault</span>&nbsp;&nbsp;&nbsp;-->
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li>
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Consoles <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
<?php foreach($all_systems as $val){ ?>
                  <li><a href="/main/view_system/<?=$val['id']?>"><?=$val['name']?></a></li>
<?php } ?>
              </ul>
            </div>
          </li>
          <li>
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Add New <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <li><a href="/main/add_console">Console</a></li>
                <li><a href="/main/add_new_game">Game</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/main/add_chart">Chart</a></li>
                <li><a href="/main/add_file/1">Document</a></li>
                <li><a href="/main/add_file/2">Image</a></li>
              </ul>
            </div>
          </li>
          <li>
            <form class="navbar-form navbar-right" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<?php } ?>
  
	<div id="container">
		<div id="header">

		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
			
		</div>
	</div>
</body>
</html>
