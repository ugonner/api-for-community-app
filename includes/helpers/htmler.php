<?php
function shout($text){

echo out($text);
}
 
function out($text){
     $text = htmlspecialchars($text, ENT_QUOTES, 'utf-8');
     
     $text = preg_replace('/\(b\)/i' , '<strong>', $text);
     $text = preg_replace('/\(\/b\)/i' , '</strong>', $text);

     $text = preg_replace('/\(i\)/i' , '<em>', $text);
     $text = preg_replace('/\(\/i\)/i' , '</em>', $text);

//converting linebreaks in windows;
     $text = str_replace("\r\n" , "\n", $text);
//converting linebreaks in macs all to unix "\n';
     $text = str_replace("\r" , "\n", $text);
     $text = str_replace("\n" , "\n", $text);

//Changing linebreaks and dbllinebreaks to br and p;
    $text = preg_replace('/\n/' , '<br/>', $text);
    $text = "<p>".preg_replace('/\n\n/' , '</p><p>', $text."</p>");

 return $text;
    }
?>