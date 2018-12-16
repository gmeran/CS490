<?php
/*
   Gabriel Meran
   CS490
   Middle End Beta

   Insert the Professor's Comment 

*/


if (isset($_POST['exam_name']) && isset($_POST['user_id']) && isset($_POST['comments']) == false)
{
 die ("Unable to insert professor's comments");
}
else
{
	// retrieve raw strings from post
   $exam_name = $_POST['exam_name'];
   $user_id = $_POST['user_id'];
   
   $comments_str = $_POST['comments'];
   
   // split raw comments string by comma
   $comments = explode(',', $comments_str);
}
$res_project = question_project($exam_name,$user_id,$comments);
echo $res_project;
function question_project($exam_name,$user_id,$comments){
$data = array('exam_name'=>$exam_name,'user_id'=>$user_id,'comments'=>$comments);
$url ="https://web.njit.edu/~vc259/insert_comments.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$questions = curl_exec($ch);
curl_close($ch);
return $questions;
}
?>