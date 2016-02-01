<?php
require(APPPATH.'libraries/AT_REST_Controller.php');
/**
 *
 */
class Estado extends AT_REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index_post(){
    $data = json_decode($this->input->input_stream('json'));

    $estado = (array) $data;
    $this->load->model('Estado_m');
    $add_t= $this->Estado_m->add_estado($estado);

    if($add_t)
    {
      $this->response($add_t,200);
    }
    else{
      $this->response($add_t,400);
    }
  }

  public function index_delete()
  {
    $this->load->model('Estado_m');
    $estado = json_decode($this->input->input_stream('json'));
    $delete = $this->Estado_m->delete_estado($estado->id);
    if($delete){
      $this->response($delete,200);
    }
    else{
      $this->response($delete,400);
    }
  }

  public function list_get()
  {
    $this->load->model('Estado_m');
    $x=$this->Estado_m->get_estados();
    $this->response($x,200);

  }

  public function index_put()
  {
    $this->load->model('Estado_m');
    $estado = json_decode($this->input->input_stream('json'));
    $update = $this->Estado_m->update_estado($estado);
    if(isset($update['error'])){
      $this->response($update['error'], 404);
    }
    else {
      $this->response('Update Complete', 200);
    }
  }


  public function index_get()
  {
    $id=$this->get('id');
    $this->load->model('Estado_m');
    $res=$this->Estado_m->get_estado_by_id($id);
    $this->response($res);
  }
  

}
 ?>
