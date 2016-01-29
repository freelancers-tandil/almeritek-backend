<?php
/**
 *
 */
class User_m extends CI_Model
{

  var $details;

  function validate_user( $username, $password ) {
      // Build a query to retrieve the user's details
      // based on the received username and password
      $this->db->from('user');
      $this->db->where('username',$username );
      $this->db->where( 'password', $password );
      $login = $this->db->get()->result();

      // The results of the query are stored in $login.
      // If a value exists, then the user account exists and is validated
      if ( is_array($login) && count($login) == 1 ) {
          // Set the users details into the $details property of this class
          $this->details = $login[0];
          // Call set_session to set the user's session vars via CodeIgniter
          $this->set_session();
          return true;
      }

      return false;
  }

  function set_session() {
        // session->set_userdata is a CodeIgniter function that
        // stores data in CodeIgniter's session storage.  Some of the values are built in
        // to CodeIgniter, others are added.  See CodeIgniter's documentation for details.
        $this->session->set_userdata( array(
                'user_id'=>$this->details->id,
                'name'=> $this->details->nombre . ' ' . $this->details->apellido,
                'email'=>$this->details->email,
                'isLoggedIn'=>true
            )
        );
    }

    function get_usuarios()
    {
      $this->db->select('*');
      $this->db->from('user u');

      $query=$this->db->get();

      if($query->num_rows()>0)
      {
        return $query->result();
      }

    }



}
 ?>
