<?php
/*
  Gabriel Meran
  CS490
  Middle End Beta

  View Questions by they're name.
*/

if((isset($_POST['questions']) == false))
{
  die ("Unable to view questions by name"); 
}
else
{
 $questions = $_POST['questions'];

}

$res_project = view_questions_project($questions);
echo $res_project;

function view_questions_project($questions){

        $data = array('questions'=> $questions);
	$url = ;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_POSTFEILDS,$data);
	$response = curl_exec($ch);
	curl_close($ch);
	return $url;
}


?>
