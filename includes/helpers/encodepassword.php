<?php
function encodePassword($password){
  $password = $password .'ugpn';
  $password = MD5($password);
return $password;
}
?>