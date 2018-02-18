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
          location.reload();
        } else {
          alert(response.msg);
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
    <div class="admin-page">
       <div class="form">
        <h1 id="admin-title">ADMIN</h1>
          <input id="btn-addProblemType" class="button" type="submit" value="Add New Problem Type" onclick="openAddNewProblemTypeModalDialog();"/><br><br>
          <input id="btn-addNewOperator" class="button" type="submit" value="Add New Operator" onclick="openAddOperatorModalDialog();"/><br><br>
          <input id="btn-addNewSpecialist" class="button" type="submit" value="Add New Specialist" onclick="openAddSpecialistModalDialog();"/><br><br>
        </div>
    </div>
    <div id=homeButtons>
    <input id="btn-home" type="button" value="<- Home" onclick="window.location.href='call_log.php'"/><br><br>
    </div>
</div>



<div id="addProblemTypeModal" class="modal">
      <div id="addProblemTypeModal" class="modal-content">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#addProblemTypeModal'));" />
        </div>
        <h1 style="width:100%;">Add New Problem Type</h1>

		<p class="lab">Enter the appropriate details below:</p>

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

		<div class="typeButtons">
			<input type="button" class="btnCancel" value="Cancel" onClick="closeModalDialog($('#addProblemTypeModal'));">
			<input type="button" class="btnAddProblemType" value="Add Problem Type" onclick="addProblemType();">
		</div>

		</form>

      </div>
    </div>

<div id="addOperatorModal" class="modal">
      <div id="addOperatorModal" class="modal-content">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#addOperatorModal'));" />
        </div>
        <h1 style="width:100%;">Add New Operator</h1>
		<form method="post">

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

		<div class="typeButtons">
			<input type="button" value="Cancel" onClick="closeModalDialog($('#addOperatorModal'));">
			<input type="button" value="Add Operator" onClick="addTextArea();">
		</div>
		</form>
      </div>
    </div>

<div id="addSpecialistModal" class="modal">
      <div id="addSpecialistModal" class="modal-content">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#addSpecialistModal'));" />
        </div>
        <h1 style="width:100%;">Add New Specialist</h1>
		<form method="post">

		<div class="typeInput">
  			<label class="col-md-4 control-label" for="textinput">Enter New Specialist's Name:</label>
  			<input id="specialistNameInput" name="textinput" type="text" class="form-control input-md">
		</div>

		<div class="typeInput">
  			<label class="col-md-4 control-label" for="textinput">Job Title:</label>
  			<input id="specialistJobTitleInput" name="textinput" type="text" class="form-control input-md" value="Specialist" disabled>
		</div>


  		<div class="typeInput">
  			<label class="col-md-4 control-label" for="textinput">Department:</label>
  			<input id="specialistDeptInput" name="textinput" type="text" class="form-control input-md" value="Helpdesk" disabled>
		</div>

  		<div class="typeInput">
  			<label class="col-md-4 control-label" for="textinput">Create Specialist Username:</label>
  			<input id="specialistUsernameInput" name="textinput" type="text" class="form-control input-md">
		</div>

		<div class="typeButtons">
			<input type="button" value="Cancel" onClick="closeModalDialog($('#addSpecialistModal'));">
			<input type="button" value="Add Specialist" onClick="addTextArea();">
		</div>
		</form>

      </div>
    </div>

</body>
</html>
