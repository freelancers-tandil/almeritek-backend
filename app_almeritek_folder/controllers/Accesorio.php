<?php
require(APPPATH.'libraries/AT_REST_Controller.php');
/**
 *
 */
class Accesorio extends AT_REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index_post(){
    $data = json_decode($this->input->input_stream('json'));

    $accesorio = (array) $data;
    $this->load->model('Accesorio_m');
    $add_t= $this->Accesorio_m->add_accesorio($accesorio);

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
    $this->load->model('Accesorio_m');
    $accesorio = json_decode($this->input->input_stream('json'));
    $delete = $this->Accesorio_m->delete_accesorio($accesorio->id);
    if($delete){
      $this->response($delete,200);
    }
    else{
      $this->response($delete,400);
    }
  }

  public function list_get()
  {
    $this->load->model('Accesorio_m');
    $x=$this->Accesorio_m->get_accesorios();
    $this->response($x,200);

  }

  public function index_put()
  {
    $this->load->model('Accesorio_m');
    $accesorio = json_decode($this->input->input_stream('json'));
    $update = $this->Accesorio_m->update_accesorio($accesorio);
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
    $this->load->model('Accesorio_m');
    $res=$this->Accesorio_m->get_accesorio_by_id($id);
    $this->response($res);
  }

  public function cantidad_get(){
    $this->load->model('Accesorio_m');
    $response = $this->Accesorio_m->cant_accesorios();
    $this->response(array('cantidad'=>$response),200);
  }

}
 ?>
