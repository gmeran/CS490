<?php
/*
   Gabriel Meran
   CS490
   Middle End Beta

   Adding questions to an Exam.

*/


if (isset($_POST['func_name']) & isset($_POST['parameters'])&& isset($_POST['description']) && isset($_POST['level']) && isset($_POST['question_type']) && isset($_POST['test_cases']) == false)
{
 die ("Unable to add question to EXAM");
}
else
{
	// retrieve raw strings from post
   $func_name = $_POST['func_name'];
   $description = $_POST['description'];
   $level = $_POST['level'];
   $question_type = $_POST['question_type'];
   
   $parameters_str = $_POST['parameters'];
   $test_input_str = $_POST['test_cases'];
   $test_output_str = $_POST['test_output'];
   
   // split raw parameter string by comma
   $parameters = explode(',', $parameters_str);
   
   // split raw input/output strings by ||
   $test_input = array(); $test_output = array();
   $test_input = explode('||', $test_input_str);
   $test_output = explode('||', $test_output_str);
   $test_cases = array();
   
   // if length of input and output are the same, create associative array $test_cases, else die
   if(sizeof($test_input) == sizeof($test_output))
   {
	   for($i = 0; $i < sizeof($test_input); $i++)
		   $test_cases[$test_input[$i]] = $test_output[$i];
   }
   else
	   die("Length of test input and test output do not match, question not added.");
   
   //echo implode(',',array_keys($test_cases))."+".implode(',',array_values($test_cases));
}

$data = array('func_name'=>$func_name,'parameters'=>$parameters,'description'=>$description,'level'=>$level,'question_type'=>$question_type,'test_cases'=>$test_cases);
$url ="https://web.njit.edu/~vc259/add_question.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$questions = curl_exec($ch);
curl_close($ch);
echo $questions;

?>