<?php
/* 
Gabriel Meran
CS490 
Middle End Alpha
*/

// Recieve json post from frontend
  
   /* $str_json = file_get_contents('php://input'); 
    $response = json_decode($str_json, true); // decoding received JSON to
    $user_id="none";$password="none";
    if(isset($response['user_id'])) $user_id = $response['user_id'];
    if(isset($response['password'])) $password = $response['password'];
   */

if ((isset($_POST['user_id']) && isset($_POST['password'])) == false)
{
  die("Did not recieve login info");
}
else
{
  $user_id = $_POST["user_id"];
  $password = $_POST["password"];
}
  $res_project = login_project($user_id,$password);
 // $res_njit  = login_njit($user_id,$password);
  echo $res_project;

// curl and json post to the backend 
function login_project($user_id, $password){
    $data = array('user_id' => $user_id, 'password' => $password);
    $url = "https://web.njit.edu/~vc259/verify.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
/*
// Curl and json to Njit login    
function login_njit($user_id,$password){
  $data = array('ucid' => $user_id, 'pass' => $password);
  $url = "https://aevitepr2.njit.edu/myhousing/login.cfm";
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
  //curl_setopt($ch,CURLOPT_COOKIESESSION,TRUE);
  //curl_setopt($ch,CURLOPT_COOKIEFILE, "");
  $response = curl_exec($ch);
  curl_close($ch);
  if(strpos($response, "Residence") == false) return  json_encode("NJIT Accepts You");
  return json_encode("NJIT Rejects You");
}
*/

?>



