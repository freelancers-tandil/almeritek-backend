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
    $data2 = (array) $data;
    $this->load->model('Taller_m');
    $error= $this->Taller_m->add_taller($data2);

    if(isset($error))
    {
      $error_j = json_encode($error);
      $this->response($error,400);
    }
  }
}
 ?>
