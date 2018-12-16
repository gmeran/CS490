<?php
/*
  Gabriel Meran
  CS490
  Middle End Beta
  
  Selecting Exam for the student to take
*/
if((isset($_POST['id']) && isset($_POST['name'])) && isset ($_POST['questions']) == false)
{
   die("Unable to select queston");

}
else
{
 $id = $_POST['id'];
 $name = $_POST['name'];
 $questions = $_POST['questions'];
}

$res_project = questions_project($id,$name,$question);
echo $res_project;

function questions_project($id,$name,$questions){
         $data = array('id'=>$id, 'name'=>$name, 'questions'=>$questions);
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
