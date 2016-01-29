<?php

require(APPPATH.'libraries/REST_Controller.php');

/**
 *
 */
abstract class AT_REST_Controller extends REST_Controller
{

  protected $authorization;

  function __construct()
  {

    parent::__construct();

    $this->config->load('almeritek');
    $this->authorization = $this->config->item('almeritek');

    if (isset($this->authorization['role_session_var'])){
      $var_name=$this->authorization['role_session_var'];
      $has_access=false;
      if (null!==$this->session->userdata($var_name)){
        $roles=$this->session->userdata($var_name);
        // [S,S,S]
        if ((null!==$this->authorization[$this->router->class][$this->router->method][$this->request->method]) && (!empty($access))){
          $access=$this->authorization[$this->router->class][$this->router->method][$this->request->method];
        } // [S,S,A]
        else if ((null!==$access=$this->authorization[$this->router->class][$this->router->method]['*']) && (!empty($access))){
          $access=$this->authorization[$this->router->class][$this->router->method]['*'];
        } // [S,A,S]
        else if ((null!==$access=$this->authorization[$this->router->class]['*'][$this->request->method]) && (!empty($access))){
          $access=$this->authorization[$this->router->class]['*'][$this->request->method];
        } // [S,A,A]
        else if ((null!==$access=$this->authorization[$this->router->class]['*']['*']) && (!empty($access))){
          $access=$this->authorization[$this->router->class]['*']['*'];
        } // [A,S,S]
        else if ((null!==$this->authorization['*'][$this->router->method][$this->request->method]) && (!empty($access))){
          $access=$this->authorization['*'][$this->router->method][$this->request->method];
        } // [A,S,A]
        else if ((null!==$this->authorization['*'][$this->router->method]['*']) && (!empty($access))){
          $access=$this->authorization['*'][$this->router->method]['*'];
        } // [A,A,S]
        else if ((null!==$this->authorization['*']['*'][$this->request->method]) && (!empty($access))){
          $access=$this->authorization['*']['*'][$this->request->method];
        } // [A,A,A]
        else if ((null!==$this->authorization['*']['*']['*']) && (!empty($access))){
          $access=$this->authorization['*']['*']['*'];
        } // Nothing defined
        else {
          $has_access=false;
        }
      }
      if (isset($access)){
        if (is_array($roles)){
          foreach ($roles as $role) {
            if (in_array($roles,$access)){
              $has_access=true;
              break;
            }
          }
        } else if (!in_array($roles,$access)){
          $has_access=true;
        }
      }
      if (!$has_access){
        $this->response([
                $this->config->item('rest_status_field_name') => FALSE,
                $this->config->item('rest_message_field_name') => $this->lang->line('text_rest_api_key_unauthorized')
            ], self::HTTP_UNAUTHORIZED);
      }
    }
  }
}


?>
