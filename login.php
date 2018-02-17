<?php
	if (isset($_POST['user'])){
		include 'dblogin.php';
		$db = dblogin();
		$username = $_POST["user"];
		$password = $_POST["password"];
		$sql = "SELECT * FROM `logins` WHERE username = '$username';";

		$result = $db->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$hash = $row["password"];
				if (password_verify($password, $hash)){
					session_start();
					$_SESSION["user"] = $username;
					$_SESSION["userid"] = $row["staffid"];
					$db-close();
					echo "TRUE";
					exit;
				}
			}
		}
		$db->close();
		echo "FALSE";
		exit;
	}
?>

<html lang="en">
<head>

	<title>Login Page</title>
	<link rel="stylesheet" href="login-stylesheet.css">
	<script type="text/javascript" src="jquery.js"></script>

	<script type="text/javascript">
		function login(){
			var usr = $("#in-user").val();
			var pw = $("#in-pw").val();
			$.ajax({
				url: 'loginrequest.php',
				data: {user : usr, password : pw},
				type: 'post',
				success: function(result) {
					if (result.success) {
						window.location.href = 'call_log.php';
					} else {
						$("#in-pw").css("border", "1px solid red");
						$("#in-user").css("border", "1px solid red");
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
	<h2 id="login-request">Please enter Username and Password</h2>


    <form class="login-form" action="" method="post">
      <input id="in-user" type="text" placeholder="username" name="user"/>
      <input id="in-pw" type="password" placeholder="password" name="password"/>
      <input id="btn-login" class="button" type="button" onclick="login();" value="Login" />
    </form>
  </div>


</div>

</body>
</html>
