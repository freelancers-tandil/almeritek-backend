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

  public function index_post()
{
  $data = json_decode($this->input->input_stream('json'));
  $data2 = (array) $data;
  $this->load->model('User_m');
  $error= $this->User_m->add_user($data2);

  if(isset($error)){
    $error_j = json_encode($error);
    $this->response($error,400);
    }
  }

  public function index_delete()
  {
    $this->load->model('User_m');
     $delete = $this->User_m->delete_user($this->input->input_stream('username'));
     if(isset($error)){
       $error_j = json_encode($error);
       $this->response($error,400);
      }
  }

  public function index_put()
  {
    $this->load->model('User_m');
    $user = json_decode($this->input->input_stream('json'));
    $update = $this->User_m->update_user($user);
    if(isset($update['error'])){
      $this->response($update['error'], 404);
    }
    else {
      $this->response('Update Complete', 200);
    }
  }

}
 ?>
