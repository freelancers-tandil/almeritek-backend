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
        'code'=>'50001',
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
            'code'=>'55000',
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
            'code'=>'55001',
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
            'code'=>'55002',
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
        'code'=>'50001',
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

}
 ?>
