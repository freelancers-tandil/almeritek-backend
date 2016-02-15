<?php
/**
 *
 */
class Config_m extends CI_Model
{

  function get_configuration(){
    $this->db->select('*');
    $this->db->from("configuracion c");
    $query=$this->db->get();
    $config_array=array();
    foreach($query->result_array() as $config){
      $item = array('clave'=>$config['clave'],
                    'valor'=>$config['valor'],
                    'descripcion'=>$config['descripcion']
                  );
      $config_array[]=(object)$item;
    }
    return $config_array;
  }

  function save_item($item){
    $data=array();
    $data['clave']=$item->clave;
    if (isset($item->valor)){
      $data['valor']=$item->valor;
      $this->db->where('clave',$item->clave);
      $result=$this->db->update('configuracion',$data);
      return true;
    } else {
      return false;
    }

  }

}

?>
