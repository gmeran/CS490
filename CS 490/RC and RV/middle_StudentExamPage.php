<?php 
 if(isset($_POST['exam_name']) == false)
   {
     die("Unable to get Exam");
   }
 else
 {
   $exam_name = $_POST['exam_name'];
 }
 
 $res_project = questions_project($exam_name);
 echo $res_project;
function questions_project($exam_name);
{
 $data = array('exam_name' => $exam_name);
 $url = "https://web.njit.edu/~vc259/get_exam.php" ;
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 $response = curl_exec($ch);
 curl_close($ch);
 return $response

}
  
?>
