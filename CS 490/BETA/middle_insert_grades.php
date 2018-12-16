<?php
/*
   Gabriel Meran
   CS490
   Middle End Beta

   Insert the student grade

*/


if (isset($_POST['exam_name']) & isset($_POST['user_id']) && isset($_POST['grades']) == false)
{
 die ("Unable to insert student's grade");
}
else
{
	// retrieve raw strings from post
   $exam_name = $_POST['exam_name'];
   $user_id = $_POST['user_id'];
   
   $grades_str = $_POST['grades'];
   
   // split raw grades string by comma
   $grades = explode(',', $grades_str);
  
}

$data = array('exam_name'=>$exam_name,'user_id'=>$user_id,'grades'=>$grades);
$url ="https://web.njit.edu/~vc259/insert_grades.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$questions = curl_exec($ch);
curl_close($ch);
//echo $questions;

?>