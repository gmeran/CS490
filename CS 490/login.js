function ajaxLoginFunction()
  {
	  var ajaxRequest new XMLHttpRequest();
  
  	ajaxRequest.onreadystatechange = function()
    {
  		if(ajaxRequest.readyState == 4)
      {
  			var ajaxDisplay = document.getElementById('ajaxDiv');
  			ajaxDisplay.innerHTML = ajaxRequest.responseText;
  
  		}
  	}
  	var name = document.getElementById('login:username').value;
  	var pass = document.getElementById('login:password').value;
  	var myJSONObject = {"username":name,"password":pass};
  	ajaxRequest.open("POST", "http://web.njit.edu/~gm247/middle_end_login.php", true);
  	ajaxRequest.send(JSON.stringify(myJSONObject));
  }