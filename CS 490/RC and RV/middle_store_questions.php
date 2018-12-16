<?php
/*
   Gabriel Meran
   CS490
   Middle End Beta

   Storing the questions for the Exam so the student can answer those
   questions.
*/

if((isset($_POST['user_id']) && isset($_POST['exam_name']) &&
isset($_POST['questions']) == false) 
{
  die("Unable to store questions to Exam");
}
else 
{
  foreach($_POST as $key => $value)
          $stored_data[$key] = $value;
}

$res_project = questions_project($stored_data);
echo $res_porject;

function questions_project($stored_data){
       
       $url = "http://web.njit.edu/~vc259/store_questions.php"
       $ch = curl_init();
       $curl_setopt($ch, CURLOPT_URL, $url);
       $curl_setopt($ch, CURLOPT_RETURNTRANSER, 1);
       $curl_setopt($ch, CURLOPT_POSTFIELDS, $stored_data);
       $response = curl_exec($ch);
       curl_close($ch);
       return $response;
}
?>
