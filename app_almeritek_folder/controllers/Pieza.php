<?php
require(APPPATH.'libraries/AT_REST_Controller.php');
/**
 *
 */
class Pieza extends AT_REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index_post(){
    $data = json_decode($this->input->input_stream('json'));

    $pieza = (array) $data;
    $this->load->model('Pieza_m');
    $add_t= $this->Pieza_m->add_pieza($pieza);

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
    $this->load->model('Pieza_m');
    $pieza = json_decode($this->input->input_stream('json'));
    $delete = $this->Pieza_m->delete_pieza($pieza->id);
    if($delete){
      $this->response($delete,200);
    }
    else{
      $this->response($delete,400);
    }
  }

  public function list_get()
  {
    $this->load->model('Pieza_m');
    $x=$this->Pieza_m->get_piezas();
    $this->response($x,200);

  }

  public function index_put()
  {
    $this->load->model('Pieza_m');
    $pieza = json_decode($this->input->input_stream('json'));
    $update = $this->Pieza_m->update_pieza($pieza);
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
    $this->load->model('Pieza_m');
    $res=$this->Pieza_m->get_pieza_by_id($id);
    $this->response($res);

  }

}
 ?>
