<?php
require(APPPATH.'libraries/AT_REST_Controller.php');

/**
 *
 */
class Cliente extends AT_REST_Controller//REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }


  public function index_post()
  {
    $data = json_decode($this->input->input_stream('json'));

    $cliente = (array) $data;
    $this->load->model('Cliente_m');
    $added_cliente = $this->Cliente_m->add_cliente($cliente);
    if ($added_cliente){
      $this->response($added_cliente,200);
    } else {
      $this->response($added_cliente,400);
    }

  }

  public function list_get(){
    //Calls method get_clientes of the model Cliente_m and lists all the client
    $this->load->model('Cliente_m');
    $response=$this->Cliente_m->get_clientes();
    if($response){
      $this->response($response,200);
    } else {
      $this->response($response,404);
    }
  }

  public function list_post(){
    //Calls method get_clientes of the model Cliente_m and lists all the client
    $this->load->model('Cliente_m');
    $data = json_decode($this->input->input_stream('json'));

    foreach($data as $cliente){
      $cliente_array = (array) $cliente;
      $this->load->model('Cliente_m');
      $added_cliente = $this->Cliente_m->add_cliente($cliente_array);
      $not_added=array();
      $added=array();
      if (isset($added_cliente['error'])){
        $cliente_array['error']=$added_cliente['error'];
        array_push($not_added,$cliente_array);
      } else {
        $added[$added_cliente['id']]=$added_cliente;
      }
      $this->response(array("added"=>$added,"not_added"=>$not_added),200);
    }
  }

  public function index_get($id){
      $this->load->model('Cliente_m');
  }



  public function search_get($data){
    $this->load->model('Cliente_m');
    $response = $this->Cliente_m->get_cliente($data);
    $this->response($response,200);
  }

  public function cantidad_get(){
    $this->load->model('Cliente_m');
    $response = $this->Cliente_m->cant_clientes();
    $this->response(array('cantidad'=>$response),200);
  }

}


 ?>
