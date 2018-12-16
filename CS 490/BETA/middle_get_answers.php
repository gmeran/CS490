<?php
/*
   Gabriel Meran
   CS490
   Middle End Beta

   Getting the student's answers
*/
if((isset($_POST['user_id']) && isset($_POST['exam_name']))== false) 
{
  die("Unable to get student's answers");
}
else 
{
  $user_id = $_POST['user_id'];
  $exam_name = $_POST['exam_name'];
}

$res_project = questions_project($user_id,$exam_name);
echo $res_project;

function questions_project($user_id,$exam_name){
   $data = array('user_id' => $user_id, 'exam_name' => $exam_name);
    $url = "https://web.njit.edu/~vc259/get_answers.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;;
}
?>
