<?php
require(APPPATH.'libraries/AT_REST_Controller.php');

/**
 *
 */
class User extends AT_REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function login_post()
  {
    $this->load->model('User_m');
    $data = json_decode($this->input->input_stream('json'));
    $user = $this->User_m->validate_user($data->username,$data->password);
    if(!isset($user['error'])){
      $this->response($user['user'],200);
    }
    else{
      $this->response($user,401);
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
    if (!isset($error['error'])){
      $this->response($error,200);
    } else {
      $this->response($error,400);
    }
  }

  public function index_delete()
  {
    $this->load->model('User_m');
    $user = (object) $this->delete();
    $delete = $this->User_m->delete_user($user->username);
    if(!isset($delete['error'])){
      $this->response($delete,200);
    }
    else{
      $this->response($delete,400);
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

  public function checklogin_post(){
    if (null!==$this->session->userdata('user_id')){
      $this->load->model('User_m');
      $user=$this->User_m->get_user_by_id($this->session->userdata('user_id'));
      $this->response($user,200);
    } else {
      $this->response($user,400);
    }
  }

  public function cantidad_get(){
    $this->load->model('User_m');
    $response = $this->User_m->cant_users();
    $this->response(array('cantidad'=>$response),200);
  }

  public function user_get($id){
      $this->load->model('User_m');
      // $cliente = json_decode($this->input->input_stream('json'));
      $data = $this->User_m->get_user_by_id($id);
      $this->response($data,200);
  }

}
 ?>
