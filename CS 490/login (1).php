<html lang = 'en'>
<form id='login' method='post' accept-charset='UTF-8'>
<fieldset >
  <legend>Alpha Login</legend>
  <input type='hidden' name='submitted' id='submitted' value='1'/>
  <label for='username' >User:</label>
  <input type='text' name='username' id='username' />
  <label for='password' >Pass:</label>
  <input type='password' name='password' id='password' />
  <input type='submit' name='login'; value='Login' />
</fieldset>
</form>
</html>

<?php
if (isset($_POST['username']) && isset($_POST['password']))
{
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  $forward = json_encode($username, $password);
  
  curl_setopt(curl_init(), CURLOPT_URL, "http://web.njit.edu/~gm247/CS490/middle_end_login.php");
  curl_setopt(curl_init(), CURLOPT_POST, 1);
  curl_setopt(curl_init(), CURLOPT_POSTFIELDS, $forward);
  curl_setopt(curl_init(), CURLOPT_RETURNTRANSFER, TRUE);
  
  $c = curl_exec(curl_init());
  curl_close(curl_init());
}
else
{
  die("Did not recieve login info from login.js");
}
?>