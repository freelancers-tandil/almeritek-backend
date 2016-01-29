<?php
require(APPPATH.'libraries/REST_Controller.php');

/**
 *
 */
class Cliente extends REST_Controller
{

  function __construct()
  {
    parent::__construct();
  }


  public function index_post()
  {
    $data = json_decode($this->input->input_stream('json'));

    $data2 = (array) $data;
    $this->load->model('Cliente_m');

    $this->Cliente_m->add_cliente($data2);

  }

  public function list_get(){
    //Calls method get_clientes of the model Cliente_m and lists all the client
    $this->load->model('Cliente_m');
    $x=$this->Cliente_m->get_clientes();
    $this->response($x,200);
  }


}


 ?>
