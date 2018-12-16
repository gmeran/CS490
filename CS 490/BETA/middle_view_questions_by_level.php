<?php
/*
   Gabriel Meran
   CS490
   Middle End Beta
   
   Viewing Questions by level of difficulty that were added.
*/
if((isset($_POST['level']) == false))
{
  die("Unable to view question");
}
else
{
  $level = $_POST['level'];
}

$res_project = view_question_project($level);
echo $res_project;

function view_question_project($level){
       $data = array('level'=> $level);
       $url = ;
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       $response = curl_exec($ch);
       curl_close($ch);
       return $url;



}
?>
