<?php
/*
   Gabriel Meran
   CS490
   Middle End Beta

   Insert the Student's answers 

*/


if (isset($_POST['exam_name']) & isset($_POST['user_id']) && isset($_POST['answers']) == false)
{
 die ("Unable to insert student's answers");
}
else
{
	// retrieve raw strings from post
   $exam_name = $_POST['exam_name'];
   $user_id = $_POST['user_id'];
   
   $answers_str = $_POST['answers'];
   
   // split raw answers string by comma
   $answers = explode(',', $answers_str);

$data = array('exam_name'=>$exam_name,'user_id'=>$user_id,'answers'=>$answers);
$url ="https://web.njit.edu/~vc259/insert_answers.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$questions = curl_exec($ch);
curl_close($ch);
//echo $questions;

?>