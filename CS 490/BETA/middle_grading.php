
<?php
/*
  Gabriel Meran
  CS490 
  Middle End 
   
 Grading Process
*/
// reieve post from the front end
if((isset($_POST['user_id']) && isset($_POST['exam_name'])) && isset($_POST['grades']))&& isset($_POST['func_name']))&& isset($_POST['parametets']))&& isset($_POST['test_cases']))&& isset($_POST['category']))&& isset($_POST['student_answers']))== false)
{
  die ('unable to recieve exam information');
}
else{
//things that will be received from either front or back
$func_name = $_POST['func_name'];
$parameters = $_POST['parameters'];
$test_cases = $_POST['test_cases'];
$category = $_POST['category'];
$student_answers =$_POST['student_answers']; 

$total_points = 100.00;
$func_def_points = 0;
$func_name_points = 0;
$func_para_points = 0;
$func_categ_points = 0;
$test_case_points = 0;
//grading conditions
$has_func_def = false;
$has_func_name = false;
$has_parameters = false;
$has_category = false;

if($category == 'Conditional')
	$category = 'if';

$line = strtok($student_answer, $seperator);

//check for file definition line, if present, check for the correct function name and paraemeters
while($line !== false) {
	//try to find the function definition attempt
	if(stripos($line, "def") !== false){

		$has_func_def = true;

		//then check if the definition contains the correct function name and syntax
		if (preg_match("/def ".$func_name."\(.*\)\:/", $line)){

			$has_func_name = true;

			//finally, check for the correct parameter names and syntax
			$parameter_string = implode(",",$parameters) . "|" . implode(", ",$parameters);
			$parameter_match = "/def ".$func_name."\( ?".$parameter_string." ?\)\:/";
			if (preg_match($parameter_match, $line))
				$has_parameters = true;
		}
	}



	// match category - check for if statement or for or while loop
	if(stripos($line, $category))
		$has_category = true;

	$line = strtok("\r\n");
}

$test_case_successes = count($test_cases);
$total = count($test_cases);
$test_case_points = .5/$total;
foreach($test_cases as $input => $output)
{
	//save student response with test function call to a temp file
	$function_call = "print($func_name($input), end='')";
	file_put_contents("test2.py", $student_answer ."\n". $function_call);

	// get output
	#$cmd = "/afs/cad/linux/anaconda3.6/anaconda/lib/python3.6 public_html/pathtofile.py";
	$cmd = "python3 test2.py";
	#$cmd = "python test.py";
	$cmd = escapeshellcmd($cmd);
	$shell_output = shell_exec($cmd);
	if($shell_output != $output)
		$test_case_successes -= 1;
   
}
echo "got $test_case_successes out of $total\n";

//grading
// if stderr then deduct
// checks and deducts points if the function is defined incorrectly
if(!$has_func_def){
   echo "function not defined correctly \n";
   $func_def_points = .1*$total_points;
}
// checks and deducts points if the function is name incorrect
if(!$has_func_name){
  echo "function name  is incorrect \n";
  $func_name_points = .1*$total_points;
}
// checks and deducts points if the function's parameters are coorect
if(!$has_parameters){
   echo "fucntion parameters entered incorrectly \n";
   $func_para_points =.1*$total_points;
}
// checks and deducts points if missing a loop or if statements within function body
if(!$has_category){
 echo "missing either if statement,for loop,or while loop with the body of the function \n";
 $func_categ_points =.2*$total_points;
}
$test_case_points = (.5 - .5*($test_case_successes/$total))*$total_points;

echo $total_points - $func_def_points - $func_name_points - $func_para_points - $func_categ_points - $test_case_points;
}

// Curl to send to backend insert grades
$data = array('exam_name'=>$exam_name,'user_id'=>$user_id,'grades'=>$grades);
$url ="https://web.njit.edu/~vc259/insert_grades.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$questions = curl_exec($ch);
curl_close($ch);
?>