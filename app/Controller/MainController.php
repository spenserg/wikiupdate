<?php

App::uses('AppController','Controller');

class MainController extends AppController {

  public $uses = false; // autoloader
  
  public function beforeFilter(){
    parent::beforeFilter();
  }
  
  public function index() {}
  
}