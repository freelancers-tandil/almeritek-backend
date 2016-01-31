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
        'num_ticket'=>$ticket->num_ticket,
        'fecha'=>$ticket->fecha,
        'taller'=>$ticket->taller,
        'equipo'=>$ticket->equipo,
        'modelo'=>$ticket->modelo,
        'marca'=>$ticket->marca,
        'imei'=>$ticket->imei,
        'cliente'=>$ticket->cliente,
        'costo_reparacion'=>$ticket->costo_reparacion,
        'tecnico'=>$ticket->tecnico,
        'avisado'=>$ticket->avisado,
        'estado'=>$ticket->estado,
        'beneficio_tecnico'=>$ticket->beneficio_tecnico,
        'observaciones'=>$ticket->observaciones,
        'fecha_cierre'=>$ticket->fecha_cierre,
        'pedido'=>$ticket->pedido,
      );
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
