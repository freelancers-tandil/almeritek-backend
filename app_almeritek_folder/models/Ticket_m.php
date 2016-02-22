<?php
/**
 *
 */
class Ticket_m extends CI_Model
{

  public function add_ticket($ticket)
  {
    $resp = $this->db->insert('ticket', $ticket);

    if(!$resp){
      return array(
          'error' => $this->db->error()
      );
    }
    else{
      $this->db->select('*');
      $this->db->from('ticket t');
      $this->db->where('id',$this->db->insert_id());
      return $this->db->get()->result();
    }
  }

  public function check_exists($id){

    $this->db->select('id');
    $this->db->from('ticket t');
    $this->db->where('id', $id);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
  }

  public function delete_ticket($id)
  {
    if($this->check_exists($id)){
      $this->db->where('id',$id);
      $this->db->delete('ticket');
      if ($this->check_exists($id)){
        return array('error' => $this->db->error());
      }
      return true;
    } else {
      $error = array(
        'code'=>'50501',
        'message'=>'El id del ticket no existe'
      );
      return array('error' => $error);
    }
  }

  public function get_tickets(){

    $this->db->select('t.*,c.nombre AS nombre_cliente, c.apellido_1 AS apellido_1_cliente, c.apellido_2 AS apellido_2_cliente,u.nombre AS nombre_usuario, u.apellido AS apellido_usuario, ta.nombre AS nombre_taller');
    $this->db->from('ticket t');
    $this->db->join('cliente c', 't.cliente = c.id','left');
    $this->db->join('user u', 't.tecnico = u.id','left');
    $this->db->join('taller ta', 't.taller = ta.id','left');

    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }

  public function update_ticket($ticket)
  {
    $ticket = (object) $ticket;
    if($this->check_exists($ticket->id)){
      $data = array(
      );
      if(isset($ticket->num_ticket)){
        $data['num_ticket'] = $ticket->num_ticket;
      }
      if(isset($ticket->fecha)){
        $data['fecha'] = $ticket->fecha;
      }
      if(isset($ticket->taller)){
        $this->load->model('Taller_m');
        if($this->Taller_m->check_exists($ticket->taller)){
          $data['taller'] = $ticket->taller;
        }
        else{
          $error = array(
            'code'=>'50302',
            'message'=>'El taller no existe'
          );
          return  array( 'error'=>$error);
        }
      }
      if(isset($ticket->equipo)){
        $data['equipo'] = $ticket->equipo;
      }
      if(isset($ticket->modelo)){
        $data['modelo'] = $ticket->modelo;
      }
      if(isset($ticket->marca)){
        $data['marca'] = $ticket->marca;
      }
      if(isset($ticket->imei)){
        $data['imei'] = $ticket->imei;
      }
      if(isset($ticket->cliente)){
        $this->load->model('Cliente_m');
        if($this->Cliente_m->check_exists($ticket->cliente)){
          $data['cliente'] = $ticket->cliente;
        }
        else{
          $error = array(
            'code'=>'50002',
            'message'=>'El cliente no existe'
          );
          return  array( 'error'=>$error);
        }
      }
      if(isset($ticket->costo_reparacion)){
        $data['costo_reparacion']= $ticket->costo_reparacion;
      }
      if(isset($ticket->tecnico)){
        $this->load->model('User_m');
        if($this->User_m->check_exists_id($ticket->tecnico)){
          $data['tecnico']= $ticket->tecnico;
        }
        else{
          $error = array(
            'code'=>'50602',
            'message'=>'El usuario no existe'
          );
          return  array( 'error'=>$error);
        }
      }
      if(isset($ticket->avisado)){
        $data ['avisado'] = $ticket->avisado;
      }

      if(isset($ticket->estado)){
          $data['estado']= $ticket->estado;
      }
      if(isset($ticket->observaciones)){
        $data ['observaciones'] = $ticket->observaciones;
      }
      if(isset($ticket->fecha_cierre)){
        $data ['fecha_cierre'] = $ticket->fecha_cierre;
      }
      $this->db->where('id',$ticket->id);
      $this->db->update('ticket',$data);
      return true;
    }
    else
    {
      $error = array(
        'code'=>'50501',
        'message'=>'El id del ticket no existe'
      );
      return array('error' => $error);
    }
  }

  public function get_ticket_by_id($id)
  {
    $this->db->select('t.*');
    $this->db->from('ticket t');
    $this->db->where('id',$id);
    $query = $this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }

  public function cant_tickets(){
    $this->db->select('*');
    $this->db->from('ticket t');
    $query=$this->db->get();
    return $query->num_rows();
  }

  public function ticket_not_estado($estado){
    $this->db->select('*');
    $this->db->from('ticket t');
    $this->db->where('estado !=',$estado);
    $result = $this->db->get();
    return $result->num_rows();
  }

  function get_tickets_search($ticket,$page=null,$cantidad=null){

      $this->db->select('t.*,c.nombre AS nombre_cliente, c.apellido_1 AS apellido_1_cliente, c.apellido_2 AS apellido_2_cliente,u.nombre AS nombre_usuario, u.apellido AS apellido_usuario, ta.nombre AS nombre_taller');
      $this->db->from('ticket t');
      $this->db->join('cliente c', 't.cliente = c.id','left');
      $this->db->join('user u', 't.tecnico = u.id','left');
      $this->db->join('taller ta', 't.taller = ta.id','left');

      $dato_array = explode(" ",$ticket->cliente);
      $size = sizeof($dato_array);

      if ($size>2){

        for($i=0;$i<$size-2;$i++){
          $nombre_array[$i] = $dato_array[$i];
        }

        $nombre = implode(" ", $nombre_array);
        $apellido_1 = $dato_array[$size-2];
        $apellido_2 = $dato_array[$size-1];
        $this->db->like('c.nombre',$nombre);
        $this->db->like('c.apellido_1',$apellido_1);
        $this->db->like('c.apellido_2',$apellido_2);
        $this->db->or_like('u.nombre',$nombre);
        $this->db->like('c.apellido',$apellido_1." ".$apellido_2);
        $this->db->or_like('u.nombre',$nombre." ".$apellido_1);
        $this->db->like('u.apellido',$apellido_2);
      } else if($size > 1) {
        $nombre=$dato_array[0];
        $apellido_1 = $dato_array[1];
        $apellido_2 = $dato_array[1];
        $this->db->like('c.nombre',$nombre);
        $this->db->like('c.apellido_1',$apellido_1);
        $this->db->or_like('c.apellido_1',$nombre);
        $this->db->like('c.apellido_2',$apellido_1);
        $this->db->or_like('c.nombre',$nombre);
        $this->db->like('c.apellido_2',$apellido_1);
        $this->db->or_like('u.nombre',$nombre);
        $this->db->like('u.apellido',$apellido_1);
      } else {

        if (!isset($nombre) && isset($ticket->cliente)){
          $nombre = $ticket->cliente;
        }
        if (isset($nombre)){
          $this->db->like('c.nombre',$nombre);
          $this->db->or_like('u.nombre',$nombre);
        }

        if (!isset($apellido_1) && isset($ticket->cliente)){
          $apellido_1 = $ticket->cliente;
        }
        if (isset($apellido_1)){
          $this->db->or_like('c.apellido_1',$apellido_1);
          $this->db->or_like('u.apellido',$apellido_1);
        }

        if (!isset($apellido_2) && isset($ticket->cliente)){
          $apellido_2 = $ticket->cliente;
        }
        if (isset($apellido_2)){
          $this->db->or_like('c.apellido_2',$apellido_2);
          $this->db->or_like('u.apellido',$apellido_2);
        }

      }


      if (isset($ticket->num_ticket)){
        $this->db->or_like('num_ticket',$ticket->num_ticket);
      }
      if (isset($ticket->fecha)){
        $this->db->or_like('fecha',$ticket->fecha);
      }
      if (isset($ticket->taller)){
        $this->db->or_like('ta.nombre',$ticket->taller);
      }
      if (isset($ticket->equipo)){
        $this->db->or_like('equipo',$ticket->equipo);
      }

      if (isset($ticket->modelo)){
        $this->db->or_like('modelo',$ticket->modelo);
      }

      if (isset($ticket->marca)){
        $this->db->or_like('marca',$ticket->marca);
      }

      if (isset($ticket->imei)){
        $this->db->or_like('imei',$ticket->imei);
      }

      if (isset($ticket->costo_reparacion)){
        $this->db->or_like('costo_reparacion',$ticket->costo_reparacion);
      }

      if (isset($ticket->tecnico)){
        $this->db->or_like('tecnico',$ticket->tecnico);
      }

      if (isset($ticket->avisado)){
        $this->db->or_like('avisado',$ticket->avisado);
      }

      if (isset($ticket->estado)){
        $this->db->or_like('estado',$ticket->estado);
      }

      if (isset($ticket->observaciones)){
        $this->db->or_like('observaciones',$ticket->observaciones);
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

  }

  public function fetch_tickets($limit, $start){
    $this->db->select('t.*,c.nombre AS nombre_cliente, c.apellido_1 AS apellido_1_cliente, c.apellido_2 AS apellido_2_cliente,u.nombre AS nombre_usuario, u.apellido AS apellido_usuario, ta.nombre AS nombre_taller');
    $this->db->from('ticket t');
    $this->db->join('cliente c', 't.cliente = c.id','left');
    $this->db->join('user u', 't.tecnico = u.id','left');
    $this->db->join('taller ta', 't.taller = ta.id','left');
    $this->db->limit($limit, $start);
    $query = $this->db->get();

    if($query->num_rows()>0){
      foreach ($query->result() as $row) {
        $data[]=$row;
      }
      return $data;
    }
    return false;

  }


  public function get_tickets_pendientes($all=false){
    $tecnico = $this->session->get_userdata()['user_id'];
    $this->db->select('t.*,c.nombre AS nombre_cliente, c.apellido_1 AS apellido_1_cliente, c.apellido_2 AS apellido_2_cliente,u.nombre AS nombre_usuario, u.apellido AS apellido_usuario, ta.nombre AS nombre_taller');
    $this->db->from('ticket t');
    $this->db->join('cliente c', 't.cliente = c.id','left');
    $this->db->join('user u', 't.tecnico = u.id','left');
    $this->db->join('taller ta', 't.taller = ta.id','left');
    $this->db->where('t.estado <', '3');
    if (!$all){
      $this->db->where('t.tecnico',$tecnico);
    }
    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }


  // public function get_tickets($all){
  //   $rol = $this->session->get_userdata('rol');
  //   if ($all){
  //     if ($rol == 0){
  //
  //     }
  //   }
  // }

}
 ?>
