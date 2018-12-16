<?php
/*
   Gabriel Meran
   CS490 
   Middle Beta
   
   Viewing Exam Table from Backend
*/
if((isset($_POST(['name']) == false)))
{
   die("Unable to view exam");
}
else
{
  $name = $_POST['name'];
}
$re_project = view_examTable($name);
echo $res_project;

function view_examTable($name);{

       $data = array('name' => $name);
       $url = ;
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFERS, $1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       $response = curl_exec($ch);
       return $reponse;

}


?>
