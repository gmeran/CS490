<?php
/*
  Gabriel Meran
  CS490
  Middle End Beta
  
  Selecting Exam for the student to take
*/
if((isset($_POST['user_id']) && isset($_POST['exam_name'])) && isset ($_POST['questions']) == false)
{
   die("Unable to select queston");

}
else
{
 $id = $_POST['user_id'];
 $name = $_POST['exam_name'];
 $questions = $_POST['questions'];
}

$res_project = questions_project($user_id,$exam_name,$question);
echo $res_project;

function questions_project($id,$name,$questions){
         $data = array('user_id'=>$user_id, 'exam_name'=>$exam_name, 'questions'=>$questions);
	 $url = ;
	 $ch = curl_init();
	 $curl_setopt($ch,CURLOPT_URL,$url);
	 $curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	 $curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	 $response = curl_exec($ch);
	 curl_close($ch);
	 return $response;

}




?>
