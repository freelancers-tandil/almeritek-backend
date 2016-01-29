<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['authorization_enabled']=true;

$config['authorization_role_session_var']='rol';

$config['authorization_exceptions']['user']['login']['*']=true;
$config['authorization']['*']['*']['*']=array('*');

 ?>
