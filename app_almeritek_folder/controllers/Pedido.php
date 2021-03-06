<?php
require(APPPATH.'libraries/AT_REST_Controller.php');
/**
 *
 */
class Pedido extends AT_REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index_post(){
    $data = json_decode($this->input->input_stream('json'));

    $pedido = (array) $data;
    $this->load->model('Pedido_m');
    $add_t= $this->Pedido_m->add_pedido($pedido);

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
    $this->load->model('Pedido_m');
    $pedido = (object) $this->delete();
    $delete = $this->Pedido_m->delete_pedido($pedido->id);
    if(!isset($delete['error'])){
      $this->response($delete,200);
    } else{
      $this->response($delete,400);
    }
  }

  public function list_get()
  {
    $this->load->model('Pedido_m');
    $x=$this->Pedido_m->get_pedidos();
    $this->response($x,200);

  }

  public function list_logged_get()
  {
    $this->load->model('Pedido_m');
    $x=$this->Pedido_m->get_pedidos_for_logged_user();
    $this->response($x,200);

  }

  public function list_logged_for_ticket_get($id)
  {
    // $id=$this->get('id');
    $this->load->model('Pedido_m');
    $x=$this->Pedido_m->get_pedidos_for_ticket_for_logged_user($id);
    $this->response($x,200);

  }


  public function index_put()
  {
    $this->load->model('Pedido_m');
    $pedido = json_decode($this->input->input_stream('json'));
    $update = $this->Pedido_m->update_pedido($pedido);
    if(isset($update['error'])){
      $this->response($update['error'], 404);
    }
    else {
      $this->response(true, 200);
    }

  }

  public function pedido_get($id)
  {
    $this->load->model('Pedido_m');
    $res=$this->Pedido_m->get_pedido_by_id($id);
    $this->response($res, 200);
  }

  public function index_get()
  {
    $id=$this->get('id');
    $this->load->model('Pedido_m');
    $res=$this->Pedido_m->get_pedido_by_id($id);
    $this->response($res);
  }

  public function cantidad_get(){
    $this->load->model('Pedido_m');
    $response = $this->Pedido_m->cant_pedidos();
    $this->response(array('cantidad'=>$response),200);
  }

  public function search_get($page,$cantidad){
    $this->load->model('Pedido_m');
    $data = (object) json_decode($this->get('json'));
    $response = $this->Pedido_m->get_pedidos_search($data,$page,$cantidad);
    $this->response($response,200);
  }

  public function searchcantidad_get(){
    $this->load->model('Pedido_m');
    $data = (object) json_decode($this->get('json'));
    $response = $this->Pedido_m->get_pedidos_search($data);
    $this->response($response,200);
  }

  public function paginado_get($page, $limit){
    $this->load->model('Pedido_m');
    $result=($page-1)*$limit;
    $data['results'] = $this->Pedido_m->
        fetch_pedidos($limit, $result);
    $this->response($data['results'],200);
  }
}
 ?>
