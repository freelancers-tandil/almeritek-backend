<?php
/**
 *
 */
class Ticketporaccesorio_m extends CI_Model
{

  public function add_accesorio($accesorio, $ticket)
  {
    $ticketAcc= array('ticket' => $ticket,
                      'accesorio' => $accesorio);
    $resp = $this->db->insert('ticketporaccesorio', $ticketAcc);
    if($data['error']=$this->db->error()){
      return $data;
    }
    else{
      $this->db->select('*');
      $this->db->from('ticketporaccesorio a');
      $this->db->where('ticket',$ticket);
      $this->db->where('accesorio',$accesorio);
      return $this->db->get()->result();
    }
  }

  public function check_exists($accesorio, $ticket){

    $this->db->select('*');
    $this->db->from('ticketporaccesorio a');
    $this->db->where('accesorio', $accesorio);
    $this->db->where('ticket', $ticket);
    $res=$this->db->get()->result();
    if($res){
      return $res;
    }
    return false;
  }


  public function delete_accesorio($accesorio, $ticket)
  {
    if($this->check_exists($accesorio, $ticket)){
      $this->db->where('accesorio',$accesorio);
      $this->db->where('ticket',$ticket);
      $this->db->delete('ticketporaccesorio');
      if ($this->check_exists($accesorio, $ticket)){
        return array('error' => $this->db->error());
      }
      return true;
      } else {
        $error = array(
          'code'=>'50001',
          'message'=>'El id del accesorio no existe'
        );
        return array('error' => $error);
    }
  }

  public function get_accesorios(){

    $this->db->select('*');
    $this->db->from('ticketporaccesorio a');

    $query=$this->db->get();
    if($query->num_rows()>0)
    {
      return $query->result();
    }
  }

  public function update_accesorio($accesorio, $ticket)
  {

    $accesorio = (object) $accesorio;
    $ticket = (object) $ticket;
    if($this->check_exists($accesorio, $ticket)){
      $data = array(
      );
      if(isset($accesorio)){
        $data['accesorio']=$accesorio;
      }
      if(isset($ticket)){
        $data['ticket']=$ticket;
      }

      $this->db->where('accesorio',$accesorio);
      $this->db->where('ticket',$ticket);
      $this->db->update('ticketporaccesorio',$data);
      return true;
    }
    else
    {
      $error = array(
        'code'=>'50001',
        'message'=>'El id del accesorio no existe'
      );
      return array('error' => $error);
    }
  }

}

 ?>
