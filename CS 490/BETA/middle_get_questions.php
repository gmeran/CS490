<?php
/*
   Gabriel Meran
   CS490
   Middle End Beta

   Getting the questions for the Exam so the student can answer those
   questions.
*/

if((isset($_POST['id']) && isset($_POST['exam_name']) &&
isset($_POST['questions']) == false) 
{
  die("Unable to store questions to Exam");
}
else 
{
  foreach($_POST as $key => $value)
          $get_data[$key] = $value;
}

$res_project = questions_project($get_data);
echo $res_project;

function questions_project($get_data){
       
       $url = "http://web.njit.edu/~vc259/get_questions.php";
       $ch = curl_init();
       $curl_setopt($ch, CURLOPT_URL, $url);
       $curl_setopt($ch, CURLOPT_RETURNTRANSER, 1);
       $curl_setopt($ch, CURLOPT_POSTFIELDS, $get_data);
       $response = curl_exec($ch);
       curl_close($ch);
       return $response;
}
?>
