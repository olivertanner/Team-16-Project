<?php
session_start();
?>
<html>
  <head>
    <title>Change Password</title>
    <link rel="stylesheet" href="changepassword.css">
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
      function changePassword(){
        if($("#in-new").val() == $("#in-confirm").val()){
          var currpass = $("#in-old").val();
          var newpass = $("#in-confirm").val();
          $.ajax({
            url: 'passwordhandler.php',
            data: {
              curr_pass: currpass,
              new_pass: newpass
            },
            type: 'POST',
            dataType: 'json',
            success: function(response){
              if(response.success){
                alert("Password changed.");
                $.ajax({
                  url: 'logouthandler.php',
                  data: {},
                  type: 'GET',
                  success: function(response){
                    window.location.href = "/";
                  }
                })

              } else {
                if (response.error == 0){
                  $("#in-old").css("border","1px solid red");
                } else {
                  alert("Error: "+response.msg);
                }
              }
            }
          });
        } else {
          $("#in-new").css("border","1px solid red");
          $("#in-confirm").css("border","1px solid red");
        }
      }
    </script>
  </head>
<body>

    <div class="changePassword-page">
       <div class="form">
        <h1 id="changePassword-title">Change Password</h1>
          <form class="changePassword-form" method="post">
          <input id="in-old" type="password" placeholder="Old Password" name="OldPassword"/>
          <input id="in-new" type="password" placeholder="New Password" name="NewPassword"/>
          <input id="in-confirm" type="password" placeholder="Confirm New Password" name="ConfirmPassword"/>
          <input id="btn-changePassword" class="button" type="button" value="Submit" onclick="changePassword();" />
          </form>
        </div>
    </div>

</body>
</html>
