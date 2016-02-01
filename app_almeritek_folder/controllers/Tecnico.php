<?php
require(APPPATH.'libraries/AT_REST_Controller.php');

/**
 *
 */
class Tecnico extends AT_REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index_post(){
    $data = json_decode($this->input->input_stream('json'));

    $tecnico = (array) $data;
    $this->load->model('Tecnico_m');
    $add_t= $this->Tecnico_m->add_tecnico($tecnico);

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
    $this->load->model('Tecnico_m');
    $tecnico = json_decode($this->input->input_stream('json'));
    $delete = $this->Tecnico_m->delete_tecnico($tecnico->id);
    if($delete){
      $this->response($delete,200);
    }
    else{
      $this->response($delete,400);
    }
  }

  public function list_get()
  {
    $this->load->model('Tecnico_m');
    $x=$this->Tecnico_m->get_tecnicos();
    $this->response($x,200);

  }

  public function index_put()
  {
    $this->load->model('Tecnico_m');
    $tecnico = json_decode($this->input->input_stream('json'));
    $update = $this->Tecnico_m->update_tecnico($tecnico);
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
  $this->load->model('Tecnico_m');
  $res=$this->Tecnico_m->get_tecnico_by_id($id);
  $this->response($res);
}

public function cantidad_get(){
  $this->load->model('Tecnico_m');
  $response = $this->Tecnico_m->cant_tecnicos();
  $this->response(array('cantidad'=>$response),200);
}


}
 ?>
