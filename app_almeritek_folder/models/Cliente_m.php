<?php

/**
 *
 */
class Cliente_m extends CI_Model
{



  public function add_cliente($data)
  // Add client in BD
  {
    $this->db->insert('cliente',$data);
  }

  function get_clientes()
  {
    $this->db->select('*');
    $this->db->from('cliente c');

    $query=$this->db->get();

    if($query->num_rows()>0)
    {
      return $query->result();
    }

  }



}


 ?>
