<?php
/**
 *
 */
class Ticket_m extends CI_Model
{

  public function add_ticket($ticket)
  {
    $resp = $this->db->insert('ticket', $ticket);
    if($data['error']=$this->db->error()){
      return $data;
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
      return !$this->check_exists($id);
    }
    return false;
  }

  public function get_tickets(){

    $this->db->select('*');
    $this->db->from('ticket t');

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
        $this->load->model('Tecnico_m');
        if($this->Tecnico_m->check_exists($ticket->tecnico)){
          $data['tecnico']= $ticket->tecnico;
        }
        else{
          $error = array(
            'code'=>'55002',
            'message'=>'El tecnico no existe'
          );
          return  array( 'error'=>$error);
        }
      }
      if(isset($ticket->avisado)){
        $data ['avisado'] = $ticket->avisado;
      }

      if(isset($ticket->estado)){
        $this->load->model('Estado_m');
        if($this->Estado_m->check_exists($ticket->estado)){
          $data['estado']= $ticket->estado;
        }
        else{
          $error = array(
            'code'=>'55003',
            'message'=>'El estado no existe'
          );
          return  array( 'error'=>$error);
        }
      }
      if(isset($ticket->beneficio_tecnico)){
        $data ['beneficio_tecnico'] = $ticket->beneficio_tecnico;
      }
      if(isset($ticket->observaciones)){
        $data ['observaciones'] = $ticket->observaciones;
      }
      if(isset($ticket->fecha_cierre)){
        $data ['fecha_cierre'] = $ticket->fecha_cierre;
      }
      if(isset($ticket->pedido)){
        $this->load->model('Pedido_m');
        if($this->Pedido_m->check_exists($ticket->pedido)){
          $data['pedido']= $ticket->pedido;
        }
        else{
          $error = array(
            'code'=>'55004',
            'message'=>'El pedido no existe'
          );
          return  array( 'error'=>$error);
        }
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
    $this->db->select('*');
    $this->db->from('ticket t');
    $this->db->where('id',$id);
    $query = $this->db->get();
    if($query->num_rows()>=0)
    {
      return $query->result();
    }
  }

}
 ?>
