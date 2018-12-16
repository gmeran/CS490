
<?php

// this gets the student's answers
if(isset($_POST['exam_name']) == false)
{
  die ('unable to recieve exam information');
}
else
{
      $exam_name = $_POST['exam_name'];
}
$res_project = questions_project($exam_name);
//echo "USER ID => " . $res_project['user_id'] . "\n";
echo "EXAM NAME => ". $res_project['exam_name'] . "\n";
//print_r($res_project);
function questions_project($exam_name){
       $data = array("exam_name" => $exam_name);
       $url ="https://web.njit.edu/~vc259/get_answers.php";
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
       $response = curl_exec($ch);
       curl_close($ch);
       $answer_array=(json_decode($response,true));
       return $answer_array;   
}
// this gets the exam questions
$res1_project = questions1_project($exam_name);
//print_r($res1_project);
function questions1_project($exam_name){
       $data = array("exam_name" => $exam_name);
       $url ="https://web.njit.edu/~vc259/get_exam.php";
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
       $response = curl_exec($ch);
       curl_close($ch);
       $question_array =json_decode($response,true);
       foreach($question_array as $in => $out)
        {
          $in = str_replace('\\"', '"', $in);
          $out = str_replace('\\"', '"', $out);
        }
       return $question_array;
}

// arrays that are assign to each of items recieved from the database 
$func_name_lst = array();
$parameter_lst = array();
$category_lst = array();
$test_case_lst = array();
$score_lst = array();
foreach($res1_project['questions'] as $q)
{
  $func_name_lst[] = $q['func_name'];
  $parameter_lst[] = $q['parameters'];
  $category_lst[] = $q['question_type'];
  $test_case_lst[] = $q['test_cases'];
  $score_lst[] = $q['max_score'];  
}
$ans_lst = array();
foreach($res_project['answers'] as $i)
{
   $ans_lst[] = $i['answer'];
}
//things that will be received from either front or back
$func_name = $func_name_lst;
$parameters = $parameter_lst;
$test_cases = $test_case_lst;
$category = $category_lst;
$student_answers = $ans_lst;

$total_points = $score_lst;
$func_def_points = 0;
$func_name_points = 0;
$func_para_points = 0;
$func_categ_points = 0;
$test_case_points = 0;

$has_func_def = false;
$has_func_name = false;
$has_parameters = false;
$has_category = false;

if($category == 'Conditional')
	$category = 'if';

$line_lst = array();
foreach($student_answers as $i){
$line_lst[] = strtok($i, $seperator);
}


//check for file definition line, if present, check for the correct function name and paraemeters

foreach($line_lst as $a){
 while($a !== false) {
	//try to find the function definition attempt
	if(stripos($a, "def") !== false){
    $has_func_def = true;
    //echo "has_func_def true \n";
    break;
  }
  // works but causes an infinite loop
  else{
    //echo "has_func_def is false \n";
    break;
  }
 }
} 
foreach($line_lst as $b){  
  while($b !== false){
    foreach($func_name as $c){
		//then check if the definition contains the correct function name and syntax
		if (preg_match("/def ".$c."\(.*\)\:/", $b)){
       $has_func_name = true;
      //echo "has_func_name true\n";
      break;
   }
    else{
     // echo "has_func_name is false\n";
    }
   }break;
  }
} 

foreach($line_lst as $c){
  while($c !== false){
   foreach($func_name as $e){
    foreach($parameters as $f){
     $parameter_string = implode(",",$f) . "|" . implode(", ",$f);
     $parameter_string = str_replace(' ','',$parameter_string);
     $parameter_match = "/def ".$e."\( ?".$parameter_string." ?\)\:/";
      if (preg_match($parameter_match, $c)){
          $has_parameters = true;
         // echo "has_parameters is true\n";         
      }  
      else{
      //echo "has_parameters is false\n";
      }
    }break;   
  }	break;	
 }
}
 
foreach($line_lst as $l)
{ 
  while($l !== false){ 
  foreach($category as $r){
	// match category - check for if statement or for or while loop
	if(stripos($l, $r))
   {
		$has_category = true;
    //echo "has_category is true\n";
   }
  else
   // echo "has_category is false\n";  

	 $l = strtok("\r\n");
  }
 }  
}

foreach($test_cases as $t){
$test_case_successes = count($t);
echo "$test_case_successes \n";
$total = count($t);
$test_case_points = .5/$total;
//print_r($test_cases);
//echo $total;
}

foreach($func_name as $h){
foreach($student_answers as $p)
{
  foreach($test_cases as $input => $output)
 {   
	//save student response with test function call to a temp file
	$function_call = "print($h($input), end='')";
	file_put_contents("test2.py", $p."\n". $function_call);

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
}
}

//grading
// if stderr then deduct
// checks and deducts points if the function is defined incorrectly
$comments_lst = array();
foreach($total_points as $s){

if(!$has_func_def){
   $func_def_points = .1*$total_points;
    array_push($comment_lst,"function not defined correctly you lost $func_def_points points");
}
// checks and deducts points if the function is name incorrect
if(!$has_func_name){
  $func_name_points = .1*$total_points;
  array_push($comment_lst,"function name is incorrect you lost $func_name_points points");
}
// checks and deducts points if the function's parameters are coorect
if(!$has_parameters){
   $func_para_points =.1*$total_points;
   array_push($comment_lst,"fucntion parameters entered incorrectly you lost $func_para_points points");
}
// checks and deducts points if missing a loop or if statements within function body
if(!$has_category){
 $func_categ_points =.2*$total_points;
  array_push($comment_lst,"missing either if statement,for loop,or while loop with the body of the function you lost $func_categ_points points");
}
$test_case_points = (.5 - .5*($test_case_successes/$total))*$s;

$grade[] = $s - $func_def_points - $func_name_points - $func_para_points - $func_categ_points - $test_case_points;
}
print_r($grade); 

// curl to send grades to the database
$data = array("user_id" => "vc259", "exam_name" => $exam_name,"grades" => $grade);
$url ="https://web.njit.edu/~vc259/insert_grades.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
$response = curl_exec($ch);
curl_close($ch);
echo $response; 

// curl to send the auto grades point deduction messages
$data1 = array("user_id" => "vc259", "exam_name" => $exam_name,"comments" => $comments);
$url ="https://web.njit.edu/~vc259/insert_comments.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data1));
$response1 = curl_exec($ch);
curl_close($ch);
echo $response1; 
?>