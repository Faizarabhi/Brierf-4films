<?php
  class Pages extends Controller {
    public function __construct(){
     
    }
    
    public function index(){
      
      $data = [
        'title' => 'SharePosts',
        'description' => 'Homme'
      ];
     
      $this->view('pages/index', $data);
    }

    public function posts(){
      if(isLoggedIn()){
        redirect('posts');
      }

      $data = [
        'title' => 'SharePosts',
        'description' => 'Simple social network built on the cinemaster PHP framework'
      ];
     
      $this->view('pages/index', $data);
    }
  }