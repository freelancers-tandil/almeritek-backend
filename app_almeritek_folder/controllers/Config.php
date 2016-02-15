<?php
require(APPPATH.'libraries/AT_REST_Controller.php');

/**
 *
 */
class Config extends AT_REST_Controller{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Config_m');
  }

  function index_get(){
    $configs=$this->Config_m->get_configuration();
    $this->response((array)$configs,200);
  }

  function index_put(){
    $data=json_decode($this->input->input_stream("json"));
    $result=$this->Config_m->save_item($data);
    if ($result){
      $this->response("",200);
    } else {
      $this->response("",400);
    }
  }

}

?>
