<?php
if((isset($_POST['exam_name']) && isset($_POST['grades']) == false))
{
  die ('unable to recieve exam grades');
}
else
{
      $exam_name = $_POST['exam_name'];
      $grades = $_POST['grades'];
}
$res_update = update($exam_name,$grades);
echo $res_update;
function update($exam_name, $grades){
  $data = array('exam_name' => $exam_name, 'grades' => $grades);
  $url ="https://web.njit.edu/~vc259/update_grades.php";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
} 
?>
