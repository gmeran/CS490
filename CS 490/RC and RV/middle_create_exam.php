<?php
 /*
   Gabriel Meran
   CS490
   Middle End Beta

   Adding a new exam.
 */
 
if((isset($_POST['exam_name']) && isset ($_POST['questions'])) == false)
{
  die("Unable to add EXAM");
}
else
{
 foreach($_POST as $key => $value)
         $exam_data[$key] = $value;
}

$res_project = questions_project($exam_data);
echo $res_project;


function questions_project($exam_data){

       $url= "https://web.njit.edu/~vc259/create_exam.php";
       $ch= curl_init();
       $curl_setopt($ch, CURLOPT_URL, $url);
       $curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $curl_setopt($ch, CURLOPT_POSTFIELDS, $exam_data);
       $response = curl_exec($ch);
       curl_close($ch);
       return $response;
}







?>
