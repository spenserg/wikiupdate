<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
  
  public function beforeFilter(){
    
  }
  
  public function beforeRender(){

  }
  
 // alert  -- setFlash() wrapper
  protected function alert($msg, $config = null){
    $type = 'success';
    if(!$config){}
    elseif($config == 'err' || $config == 'error' || $config == 'e' || $config == 'bad')
    $type = 'danger';
    elseif($config == 'info' || $config == 'i')
    $type = 'info';
  
  
    if(strlen($msg))
      $this->Session->setFlash(__($msg), 'alert_msg', array('class' => 'alert alert-' . $type));
    else
      $this->Session->delete('Message.flash');
  }
  
  public function file_to_jpeg($file_arr){
    $allowedExts = array("gif", "jpeg", "jpg", "png", "bmp");
    $msg = "Image successfully uploaded!";
    $error = 0;
    $imageTmp = NULL;
    if (basename($file_arr["name"]) == ""){
      $msg = "File name is blank.";
      $error = 1;
    }else{
      $bob = explode(".", $file_arr["name"]);
      $ext = end($bob);
      if (in_array($ext, $allowedExts)){
        if (preg_match('/jpg|jpeg/i',$ext))
          $imageTmp=imagecreatefromjpeg($file_arr["tmp_name"]);
        if (preg_match('/png/i',$ext))
          $imageTmp=imagecreatefrompng($file_arr["tmp_name"]);
        if (preg_match('/gif/i',$ext))
          $imageTmp=imagecreatefromgif($file_arr["tmp_name"]);
        if (preg_match('/bmp/i',$ext))
          $imageTmp=imagecreatefrombmp($file_arr["tmp_name"]);
        if($imageTmp === false){
          $msg = "Unable to read image file. Please try a different file";
          $error = 1;
        }
      }else{
        $error = 1;
        $msg = "Invalid file type! Accepted types are .gif, .jpeg, .jpg, or .png";  
      }
    }
    if ($imageTmp == NULL)
      $error = 1;
    return array('file'=>$imageTmp,'msg'=>$msg, 'error'=>$error);
  }
  
  // Auto Loader for Models
  public function &__get($name) {
    if(!isset($this->modelsList))
      $this->modelsList = array_flip(App::objects('model'));
  
    if(isset($this->modelsList[$name])){
      try {
        $this->loadModel($name);
        return $this->$name;
      } catch(Exception $e) {
        
      }
    }
  
    // Model not found. Let's see if our parent knows what we're trying to access
    $ret = parent::__get($name);
    return $ret; // must return a variable containing false/null, not false itself
  }
}
