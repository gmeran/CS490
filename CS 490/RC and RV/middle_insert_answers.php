<?php
/*
   Gabriel Meran
   CS490
   Middle End Beta

   Insert the Student's amswers 

*/
if (isset($_POST['exam_name'])  && isset($_POST['answers']) == false)
{
 die ("Unable to insert student's answers");
}
else
{
	// retrieve raw strings from post
   $exam_name = $_POST['exam_name'];
 
   $answers = $_POST['answers'];
   
}
$res_send_answers = send_answers($exam_name,$answers);
echo $res_send_answers;
function send_answers($exam_name,$answers){
$data = array('exam_name'=>$exam_name,'answers'=>$answers);
$url ="https://web.njit.edu/~vc259/insert_answers.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$questions = curl_exec($ch);
curl_close($ch);
return $questions;
}
include_once "middle_grading.php";
?>