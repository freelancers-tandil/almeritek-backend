<?php
require(APPPATH.'libraries/AT_REST_Controller.php');
/**
 *
 */
class Ticket extends AT_REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index_post(){
    $data = json_decode($this->input->input_stream('json'));

    $ticket = (array) $data;
    $this->load->model('Ticket_m');
    $add_t= $this->Ticket_m->add_ticket($ticket);

    if(!isset($add_t['error']))
    {
      $this->response($add_t,200);
    }
    else{
      $this->response($add_t,400);
    }
  }

  public function index_delete()
  {
    $this->load->model('Ticket_m');
    $ticket= (object) $this->delete();
    $delete = $this->Ticket_m->delete_ticket($ticket->id);
    if(isset($delete['error'])){
      $this->response($delete,200);
    }
    else{
      $this->response($delete,400);
    }
  }

  public function list_get()
  {
    $this->load->model('Ticket_m');
    $x=$this->Ticket_m->get_tickets();
    $this->response($x,200);

  }

  public function index_put()
  {
    $this->load->model('Ticket_m');
    $ticket = json_decode($this->input->input_stream('json'));
    $update = $this->Ticket_m->update_ticket($ticket);
    if(isset($update['error'])){
      $this->response($update, 400);
    }
    else {
      $this->response(true, 200);
    }
  }


  public function ticket_get($id)
  {
    $this->load->model('Ticket_m');
    $res=$this->Ticket_m->get_ticket_by_id($id);
    $this->response($res, 200);
  }

  public function cantidad_get(){
    $this->load->model('Ticket_m');
    $response = $this->Ticket_m->cant_tickets();
    $this->response(array('cantidad'=>$response),200);
  }

  public function notEstado_get(){
    $this->load->model('Ticket_m');
    $ticket = json_decode($this->get('json'));
    $response = $this->Ticket_m->ticket_not_estado($ticket->estado);
    $this->response(array('cantidad'=>$response),200);
  }

  public function search_get($page,$cantidad){
    $this->load->model('Ticket_m');
    $data = (object) json_decode($this->get('json'));
    $response = $this->Ticket_m->get_tickets_search($data,$page,$cantidad);
    $this->response($response,200);
  }

  public function searchcantidad_get(){
    $this->load->model('Ticket_m');
    $data = (object) json_decode($this->get('json'));
    $response = $this->Ticket_m->get_tickets_search($data);
    $this->response($response,200);
  }

  public function paginado_get($page, $limit){
    $this->load->model('Ticket_m');
    $result=($page-1)*$limit;
    $data['results'] = $this->Ticket_m->
        fetch_tickets($limit, $result);
    $this->response($data['results'],200);
  }

}
 ?>
