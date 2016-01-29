<?php

/**
 *
 */
class Cliente_m extends CI_Model
{



  public function add_cliente($data)
  // Add client in BD
  {
    $db_response = $this->db->insert('cliente',$data);
    if ($db['error']=$this->db->error()){
      return $db;
    } else {
      $this->db->select('*');
      $this->db->from('cliente c');
      $this->db->where('id',$this->db->insert_id());
      return $this->db->get()->result();
    }
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

  function get_cliente($cliente){

      $this->db->select('*');
      $this->db->from('cliente c');
      if (isset($cliente->id)){
        $this->db->where('id',$cliente->id);
      }
      if (isset($cliente->nombre)){
        $this->db->like('nombre',$cliente->nombre);
      }
      if (isset($cliente->apellido_1)){
        $this->db->like('apellido_1',$cliente->apellido_1);
      }
      if (isset($cliente->apellido_2)){
        $this->db->like('apellido_2',$cliente->apellido_2);
      }
      if (isset($cliente->identity_number)){
        $this->db->like('identity_number',$cliente->identity_number);
      }
      if (isset($cliente->telefono_1)){
        $this->db->like('telefono_1',$cliente->telefono_1);
      }
      if (isset($cliente->telefono_2)){
        $this->db->like('telefono_2',$cliente->telefono_2);
      }
      if (isset($cliente->direccion)){
        $this->db->like('direccion',$cliente->direccion);
      }
      if (isset($cliente->tipo_cliente)){
        $this->db->where('tipo_cliente',$cliente->tipo_cliente);
      }
      if (isset($cliente->codigo_postal)){
        $this->db->like('codigo_postal',$cliente->codigo_postal);
      }

      return $this->db->get();

  }


}


 ?>
