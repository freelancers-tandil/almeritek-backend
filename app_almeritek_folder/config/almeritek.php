<?php

defined('BASEPATH') OR exit('No direct script access allowed');


$config['authorization_enabled']=true;

$config['authorization_role_session_var']='rol';

$config['authorization_exceptions']['user']['login']['post']=true;
$config['authorization_exceptions']['user']['logout']['get']=true;
$config['authorization_exceptions']['user']['checklogin']['post']=true;

/*
*
* Por defecto solo los administradores acceden a todo
*
*/
$config['authorization']['*']['*']['*']=array('0');


/*
*
* Autorizaciones para los tickets
*
*/
$config['authorization']['ticket']['*']['*']=array('0','1');
$config['authorization']['ticket']['*']['delete']=array('0');

/*
*
* Autorizaciones para los clientes
*
*/
$config['authorization']['cliente']['list']['*']=array('*');
$config['authorization']['cliente']['*']['get']=array('*');

/*
*
* Autorizaciones para los talleres
*
*/
$config['authorization']['taller']['list']['*']=array('*');

/*
*
* Autorizaciones para los usuarios
*
*/
$config['authorization']['user']['list']['*']=array('*');



$config['authorization']['pedido']['list_logged']['*']=array('*');

 ?>
