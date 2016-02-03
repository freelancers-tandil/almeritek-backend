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
    if ($db_response){
      $this->db->select('*');
      $this->db->from('cliente c');
      $this->db->where('id',$this->db->insert_id());
      return $this->db->get()->result();
    } else {
      return array('error'=>$this->db->error());
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

  public function check_exists($id){

    $this->db->select('id');
    $this->db->from('cliente c');
    $this->db->where('id', $id);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
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

  public function delete_cliente($id)
  {
    if($this->check_exists($id)){
      $this->db->where('id',$id);
      $this->db->delete('cliente');
      if ($this->check_exists($id)){
        return array('error' => $this->db->error());
      }
      return true;
    } else {
      $error = array(
        'code'=>'50001',
        'message'=>'El id del taller no existe'
      );
      return array('error' => $error);
    }

  }

  public function update_cliente($cliente)
  {
    $cliente = (object) $cliente;
    if($this->check_exists($cliente->id)){
      $data = array(
      );
      if(isset($cliente->nombre)){
        $data['nombre'] = $cliente->nombre;
      }
      if(isset($cliente->apellido_1)){
        $data['apellido_1'] = $cliente->apellido_1;
      }
      if(isset($cliente->apellido_2)){
        $data['apellido_2'] = $cliente->apellido_2;
      }
      if(isset($cliente->identity_number)){
        $data['identity_number'] = $cliente->identity_number;
      }
      if(isset($cliente->telefono_1)){
        $data['telefono_1'] = $cliente->telefono_1;
      }
      if(isset($cliente->telefono_2)){
        $data['telefono_2'] = $cliente->telefono_2;
      }
      if(isset($cliente->direccion)){
        $data['direccion'] = $cliente->direccion;
      }
      if(isset($cliente->tipo_cliente)){
        $data['tipo_cliente']= $cliente->tipo_cliente;
      }
      if(isset($cliente->codigo_postal)){
        $data ['codigo_postal'] = $cliente->codigo_postal;
      }

      $this->db->where('id',$cliente->id);
      $this->db->update('cliente',$data);
      return true;
    }
    else
    {
      $error = array(
        'code'=>'50001',
        'message'=>'El id del cliente no existe'
      );
      return array('error' => $error);
    }
  }


  public function cant_clientes(){
    $this->db->select('*');
    $this->db->from('cliente c');
    $query=$this->db->get();
    return $query->num_rows();
  }

  // public function record_count(){
  //   return $this->db->count_all('cliente');
  // }

  public function fetch_clients($limit, $start){
    $this->db->limit($limit, $start);
    $query = $this->db->get('cliente');

    if($query->num_rows()>0){
      foreach ($query->result() as $row) {
        $data[]=$row;
      }
      return $data;
    }
    return false;

  }


}


 ?>
