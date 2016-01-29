<?php
require(APPPATH.'libraries/REST_Controller.php');

/**
 *
 */
class User extends REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function login_get($user,$password)
  {
    $this->load->model('User_m');

    if($this->User_m->validate_user($user, $password)){
      $this->response(200);
    }
    else{
      $this->response(array(),401);
    }

  }


  public function logout_get()
  {
      $this->session->sess_destroy();
  }


  public function list_get()
  {
    $this->load->model('User_m');
    $x=$this->User_m->get_usuarios();
    $this->response($x,200);
  }



}
 ?>
