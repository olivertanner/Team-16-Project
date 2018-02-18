<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<title>Login Page</title>
	<link rel="stylesheet" href="login-stylesheet.css">
	<script type="text/javascript" src="jquery.js"></script>

	<script type="text/javascript">
  $(document).ready(function(){
		$(".login-form input").keypress(function(e){
			if(e.which == 13){
				login();
			}
		});
	});
		function login(){
			var usr = $("#in-user").val();
			var pw = $("#in-pw").val();
			$.ajax({
				url: 'loginhandler.php',
				data: {user : usr, password : pw},
				type: 'post',
				success: function(result) {
					if (result.success) {
						window.location.href = 'call_log.php';
					} else {
						if(result.msg == "Invalid username or password"){
							$("#in-pw").css("border", "1px solid red");
							$("#in-user").css("border", "1px solid red");
						} else {
							alert(result.msg);
						}

					}
				}
			});
		}
	</script>
</head>
<body>
<div class="login-page">
  <div class="form">
	<h1 id="login-title">LOGIN</h1>
    <form class="login-form" action="" method="post">
      <input id="in-user" type="text" placeholder="Username" name="user"/>
      <input id="in-pw" type="password" placeholder="Password" name="password"/>
      <input id="btn-login" class="noselect button" type="button" onclick="login();" value="Login" />
    </form>
  </div>


</div>

</body>
</html>
