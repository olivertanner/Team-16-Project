<!-- PHP code for admin page (admin.php) allowing the operator to add new operator/specialist/problem type 
Contributors - Ollie Tanner, Eoghan Burke -->

<html>
  <head>
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">

    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">

$(document).ready(function(){
    $.ajax({
      url: 'get_problem_types.php',
      data: {},
      type: 'GET',
      success: function(response){
        $("#broadidselect").append(response);
      }
    });

});

  function addProblemType(){
    var ptname = $("#in-pt-name").val();
    var broad = $("#broadidselect option:selected").text();
    var broadtypeid = "";
    if (broad.length > 0){
      var broadParts = broad.split(' ');
      broadtypeid = broadParts[0];
    }
    $.ajax({
      url: 'add_problem_types.php',
      data: {
        name: ptname,
        broadid: broadtypeid
      },
      type: 'POST',
      success: function(response){
        if (response.success){
          alert("New problem type added");
          $("#in-pt-name").val("");
          location.reload();
        } else {
          alert(response.msg);
        }
      }
    });
  }

  function addOperatorOrSpecialist(option){
    var username, name;
    if (option == 0){
      username = $("#operatorUsernameInput").val();
      name = $("#operatorNameInput").val();
    } else {
      username = $("#specialistUsernameInput").val();
      name = $("#specialistNameInput").val();
    }
    $.ajax({
      url: 'add_operator_or_specialist.php',
      data: {
        option: option,
        name: name,
        username: username
      },
      type: 'POST',
      success: function(response){
        if (response.success){
          alert("Account created\nUsername: "+response.username+"\nPassword: "+response.password);
        } else {
          alert("Error: "+response.msg);
        }
      }
    });
  }

	function openModalDialog(dialog){
        dialog.attr("style","display:inline-block");
      }

	function closeModalDialog(dialog){
        dialog.removeAttr("style");
        dialog.attr("style","display:none;")
      }

	function openAddNewProblemTypeModalDialog(){
      	openModalDialog($("#addProblemTypeModal"));
      }

	function openAddOperatorModalDialog(){
      	openModalDialog($("#addOperatorModal"));
      }

	function openAddSpecialistModalDialog(){
      	openModalDialog($("#addSpecialistModal"));
      }

    function addTextArea(){
            var div = document.getElementById('spec.add');
            div.innerHTML += "<label class='col-md-4 control-label' for='selectbasic'>Select Specialist </label>";
            div.innerHTML += "<select>      <option>Specialist 1</option><option>Specialist 2</option><option>Specialist 3</option><option>Specialist 4</option><option>Specialist 5</option><option>Specialist 6</option><option>Specialist 7</option>";
            div.innerHTML += "</select>";
            div.innerHTML += "</br>";
        }
    </script>
  </head>
<body>

<div id="main">
    <div id=homeButtons>
    </div>
    <div class="admin-page">
    <input id="btn-home" type="button" value="Home" onclick="window.location.href='call_log.php'"/><br><br>
       <div class="form">
        <h1 id="admin-title">ADMIN</h1>
          <input id="btn-addProblemType" class="button" type="submit" value="Add New Problem Type" onclick="openAddNewProblemTypeModalDialog();"/><br><br>
          <input id="btn-addNewOperator" class="button" type="submit" value="Add New Operator" onclick="openAddOperatorModalDialog();"/><br><br>
          <input id="btn-addNewSpecialist" class="button" type="submit" value="Add New Specialist" onclick="openAddSpecialistModalDialog();"/><br><br>
        </div>
    </div>
</div>



<div id="addProblemTypeModal" class="modal">
      <div id="addProblemTypeModal" class="modal-content">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#addProblemTypeModal'));" />
        </div>

        <div class="modal_container">
        	<h1 style="width:100%;">Add New Problem Type</h1>
        	<p class="lab">Enter the appropriate details below:</p>
		<div class="modal_wrapper">

		<form method="post">

		<!--Text input-->
		<div class="typeInput">
  			<label class="col-md-4 control-label" for="textinput">Problem Type Name:</label>
  			<input id="in-pt-name" name="textinput" type="text" placeholder="" class="form-control input-md" />
		</div>

  		<div class="broadSelect">

  			<label>Select Broad Problem Type:</label>

    			<select id="broadidselect">
      				<option></option>

    			</select>


  		</div>
		</div>
		<div class="typeButtons">
			<input type="button" class="btnCancel" value="Cancel" onClick="closeModalDialog($('#addProblemTypeModal'));">
			<input type="button" class="btnSubmit"  value="Add Problem Type" onclick="addProblemType();">
		</div>
		</div>

		</form>

      </div>
    </div>

<div id="addOperatorModal" class="modal">
      <div id="addOperatorModal" class="modal-content">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#addOperatorModal'));" />
        </div>

		<form method="post">

		<div class="modal_container">
		        <h1 style="width:100%;">Add New Operator</h1>
		<div class="modal_wrapper">
		<div class="typeInput">
  			<label class="col-md-4 control-label" for="textinput">Enter New Operator's Name:</label>
  			<input id="operatorNameInput" name="textinput" type="text" class="form-control input-md">
		</div>

		<div class="typeInput">
  			<label class="col-md-4 control-label" for="textinput">Job Title:</label>
  			<input id="operatorJobTitleInput" name="textinput" type="text" class="form-control input-md" value="Operator" disabled>
		</div>


  		<div class="typeInput">
  			<label class="col-md-4 control-label" for="textinput">Department:</label>
  			<input id="operatorDeptInput" name="textinput" type="text" class="form-control input-md" value="Helpdesk" disabled>
		</div>

  		<div class="typeInput">
  			<label class="col-md-4 control-label" for="textinput">Create Operator Username:</label>
  			<input id="operatorUsernameInput" name="textinput" type="text" class="form-control input-md">
		</div>
		</div>

		<div class="typeButtons">
			<input type="button" class="btnCancel" value="Cancel" onClick="closeModalDialog($('#addOperatorModal'));">
			<input type="button" class="btnSubmit" value="Add Operator" onClick="addOperatorOrSpecialist(0);">
		</div>
		</div>
		</form>
      </div>
    </div>

<div id="addSpecialistModal" class="modal">
      <div id="addSpecialistModal" class="modal-content">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#addSpecialistModal'));" />
        </div>
		<form method="post">

		<div class="modal_container">
				        <h1 style="width:100%;">Add New Specialist</h1>
		<div class="modal_wrapper">
		<div class="typeInput">
  			<label class="" for="textinput">Enter New Specialist's Name:</label>
  			<input id="specialistNameInput" name="textinput" type="text" class="form-control input-md">
		</div>

		<div class="typeInput">
  			<label class="" for="textinput">Job Title:</label>
  			<input id="specialistJobTitleInput" name="textinput" type="text" class="form-control input-md" value="Specialist" disabled>
		</div>


  		<div class="typeInput">
  			<label class="" for="textinput">Department:</label>
  			<input id="specialistDeptInput" name="textinput" type="text" class="form-control input-md" value="Helpdesk" disabled>
		</div>

  		<div class="typeInput">
  			<label class="" for="textinput">Create Specialist Username:</label>
  			<input id="specialistUsernameInput" name="textinput" type="text" class="form-control input-md">
		</div>

		</div>
		<div class="typeButtons">
			<input type="button" class="btnCancel" value="Cancel" onClick="closeModalDialog($('#addSpecialistModal'));">
			<input type="button" class="btnSubmit" value="Add Specialist" onClick="addOperatorOrSpecialist(1);">
		</div>
		</div>
		</form>

      </div>
    </div>

</body>
</html>
