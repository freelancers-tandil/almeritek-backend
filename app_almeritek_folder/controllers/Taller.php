<?php
require(APPPATH.'libraries/AT_REST_Controller.php');

/**
 *
 */
class Taller extends AT_REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index_post(){
    $data = json_decode($this->input->input_stream('json'));

    $taller = (array) $data;
    $this->load->model('Taller_m');
    $add_t= $this->Taller_m->add_taller($taller);

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
    $this->load->model('Taller_m');
    $taller = (object) $this->delete();
    $delete = $this->Taller_m->delete_taller($taller->id);
    if(!isset($delete['error'])){
      $this->response($delete,200);
    } else{
      $this->response($delete,400);
    }
  }

  public function list_get()
  {
    $this->load->model('Taller_m');
    $x=$this->Taller_m->get_talleres();
    $this->response($x,200);

  }

  public function index_put()
  {
    $this->load->model('Taller_m');
    $taller = json_decode($this->input->input_stream('json'));
    $update = $this->Taller_m->update_taller($taller);
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
  $this->load->model('Taller_m');
  $res=$this->Taller_m->get_taller_by_id($id);
  $this->response($res);
}

public function cantidad_get(){
  $this->load->model('Taller_m');
  $response = $this->Taller_m->cant_talleres();
  $this->response(array('cantidad'=>$response),200);
}

public function taller_get($id){
    $this->load->model('Taller_m');
    // $cliente = json_decode($this->input->input_stream('json'));
    $data = $this->Taller_m->get_taller_by_id($id);
    $this->response($data,200);
}

}
 ?>
