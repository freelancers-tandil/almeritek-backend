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

  public function get_client($id){
    $this->db->select('*');
    $this->db->from('cliente c');
    $this->db->where('id',$id);
    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result()[0];
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

  function get_clientes_search($cliente,$page=null,$cantidad=null){

      $this->db->select('*');
      $this->db->from('cliente c');

      if (isset($cliente->tipo_cliente)){
        $this->db->where('tipo_cliente',$cliente->tipo_cliente);
      }

      $dato_array = explode(" ",$cliente->nombre);
      $size = sizeof($dato_array);
      if ($size>2){

        for($i=0;$i<$size-2;$i++){
          $nombre_array[$i] = $dato_array[$i];
        }

        $nombre = implode(" ", $nombre_array);
        $apellido_1 = $dato_array[$size-2];
        $apellido_2 = $dato_array[$size-1];
        $this->db->like('nombre',$nombre);
        $this->db->like('apellido_1',$apellido_1);
        $this->db->like('apellido_2',$apellido_2);
      } else if($size > 1){
        $nombre=$dato_array[0];
        $apellido_1 = $dato_array[1];
        $apellido_2 = $dato_array[1];
        $this->db->like('nombre',$nombre);
        $this->db->like('apellido_1',$apellido_1);
        $this->db->or_like('apellido_1',$nombre);
        $this->db->like('apellido_2',$apellido_1);
        $this->db->or_like('nombre',$nombre);
        $this->db->like('apellido_2',$apellido_1);


      } else {

        if (!isset($nombre) && isset($cliente->nombre)){
          $nombre = $cliente->nombre;
        }
        if (isset($nombre)){
          $this->db->or_like('nombre',$nombre);
        }

        if (!isset($apellido_1) && isset($cliente->apellido_1)){
          $apellido_1 = $cliente->apellido_1;
        }
        if (isset($apellido_1)){
          $this->db->or_like('apellido_1',$apellido_1);
        }

        if (!isset($apellido_2) && isset($cliente->apellido_2)){
          $apellido_2 = $cliente->apellido_2;
        }
        if (isset($apellido_2)){
          $this->db->or_like('apellido_2',$apellido_2);
        }

      }

      if (isset($cliente->identity_number)){
        $this->db->or_like('identity_number',$cliente->identity_number);
      }
      if (isset($cliente->telefono_1)){
        $this->db->or_like('telefono_1',$cliente->telefono_1);
      }
      if (isset($cliente->telefono_2)){
        $this->db->or_like('telefono_2',$cliente->telefono_2);
      }
      if (isset($cliente->direccion)){
        $this->db->or_like('direccion',$cliente->direccion);
      }

      if (isset($cliente->codigo_postal)){
        $this->db->or_like('codigo_postal',$cliente->codigo_postal);
      }

      if (isset($cantidad) && isset($page)){
        $start=($page-1)*$cantidad;
        $this->db->limit($cantidad, $start);
        $response= $this->db->get();
        return $response->result();
      } else {
        $response= $this->db->get();
        return array('cantidad' => $response->num_rows());
      }

      //

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
          'message'=>'El id del cliente no existe'
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

  public function tickets_cliente($id){
    $this->db->select(' t.id, t.num_ticket, t.fecha, t.taller, t.equipo, t.modelo, t.marca, t.imei, t.cliente, t.costo_reparacion, t.tecnico, t.avisado, t.estado, c.nombre, c.apellido_1');
    $this->db->from('ticket t');
    $this->db->join('cliente c', 'c.id = t.cliente');
    $this->db->where('c.id', $id);
    $query = $this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }

  }


}


 ?>
