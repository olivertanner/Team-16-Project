<?php
 session_start();
 ?>
<html>
  <head>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Call Log</title>
    <style type="text/css">
	   @import url("stylesheet.css");
    </style>
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">

      var log = {};
      $(document).ready(function(){ //on page open
        var options = `<option value='empty'></option>
        <option value='Networking'>Networking</option>
        <option value='Printing'>Printing</option>
        <option value='Operating System'>Operating System</option>
        <option value='Mouse'>Mouse</option>
        <option value='Keyboard'>Keyboard</option>`;
        $(".problemTypeSel").append(options);

        log.calls = [
          ["1","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned","High"],
          ["2","Ben","01-01-2017","13:00:00","Networking","None","Pending","N/A"],
          ["3","Charles","01-01-2017","13:00:00","Networking","Tom","Closed","N/A"],
          ["4","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["5","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["6","Charles","01-01-2017","13:00:00","Networking","Tom","Closed"],
          ["7","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["8","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["9","Charles","01-01-2017","13:00:00","Networking","Tom","Closed"],
          ["10","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["11","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["12","Charles","01-01-2017","13:00:00","Networking","Tom","Closed"],
          ["13","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["14","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["15","Charles","01-01-2017","13:00:00","Networking","Tom","Closed"],
          ["16","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["17","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["18","Charles","01-01-2017","13:00:00","Networking","Tom","Closed"],
          ["19","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["20","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["21","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["22","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["23","Charles","01-01-2017","13:00:00","Networking","Tom","Closed"],
          ["24","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["25","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["26","Charles","01-01-2017","13:00:00","Networking","Tom","Closed"],
          ["27","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["28","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["29","Charles","01-01-2017","13:00:00","Networking","Tom","Closed"]
        ];
        var rows = "";
        for (var i = 0; i < log.calls.length; i++) {
          var row = "<tr>";
          for (var j = 0; j < log.calls[i].length; j++) {
            if (j == 4){
              row += "<td class='typetd'>"+log.calls[i][j]+"</td>";
            } else if (j == 5) {
              row += "<td class='specialisttd'>"+log.calls[i][j]+"</td>";
            } else if (j == 6) {
              row += "<td class='statustd'>"+log.calls[i][j]+"</td>";
            } else {
              row += "<td>"+log.calls[i][j]+"</td>";
            }

          }
          row += "</tr>";
          rows += row;
        };
        $("#callLogTable > tbody:last-child").append(rows);

      var userid;
      var user;
      $.ajax({
        url: "sessionhandler.php",
        data: {},
        type: "GET",
        dataType: "json",
        success: function(response){
          user = response.username;
          name = response.name;
          $("#username_details").val(user);
          $("#name_details").val(name);
        }
      });


        $(document).on("click", "table tbody tr", function(e) {
          if($(this).hasClass("selected")){
            $(this).removeClass("selected");
          } else {
            $(this).addClass("selected").siblings().removeClass("selected");
          }
          if ($(this).hasClass("selected")) {
            showProblemDetails();
            buttonRename();
          } else {
            clearProblemDetails();
          }
        });

        $("#detailsProblemType").on("change", function(){
          $("#cancelEditBtn").prop("disabled", false);
          $("#saveEditBtn").prop("disabled", false);
        });
      });

      function showProblemDetails(){
        var row = Number($("#callLogTable tr.selected td:first").html()) - 1;
        $("#detailsID").val(log.calls[row][0]);
        $("#detailsCaller").val(log.calls[row][1]);
        $("#detailsDate").val(log.calls[row][2]);
        $("#detailsTime").val(log.calls[row][3]);
        $("#detailsProblemType").val(log.calls[row][4]).change();
        $("#detailsSpecialist").val(log.calls[row][5]);
        $("#detailsStatus").val(log.calls[row][6]);
        $("#detailsPriority").val(log.calls[row][7]);
      }

      function clearProblemDetails(){
        $("#detailsID").val("");
        $("#detailsCaller").val("");
        $("#detailsDate").val("");
        $("#detailsTime").val("");
        $("#detailsProblemType").val("").change();
        $("#detailsSpecialist").val("");
        $("#detailsStatus").val("");
        $("#detailsPriority").val("");
      }

      function cancelEdit(){
        var row = Number($("#callLogTable tr.selected td:first").html()) - 1;
        $("#detailsProblemType").val(log.calls[row][4]).change();
      }

      function saveEdit(){
        var row = Number($("#callLogTable tr.selected td:first").html()) - 1;
        var problemType = $("#detailsProblemType").val();
        log.calls[row][4] = problemType;
        $("#callLogTable tr.selected td.typetd").text(problemType).change();
      }

      function filter(){
        $("#callLogTable > tbody").html("");
        var onID = false,
          onName = false,
          onType = false,
          onAssigned = false,
          onPending = false,
          onClosed = false;

        if ($.trim($("#filterID").val()).length > 0){
          onID = true;
        }
        if ($.trim($("#filterName").val()).length > 0){
          onName = true;
        }
        if ($("#filterType option:selected").text() != ""){
          onType = true;
        }
        if ($("#filterAssigned").is(':checked')){
          onAssigned = true;
        }
        if ($("#filterPending").is(':checked')){
          onPending = true;
        }
        if ($("#filterClosed").is(':checked')){
          onClosed = true;
        }
        var rows = "";
        for (var i = 0; i < log.calls.length; i++) {
          if ((onID ? $("#filterID").val() == log.calls[i][0] : true) &&
            (onName ? $("#filterName").val() == log.calls[i][1] : true) &&
            (onType ? $("#filterType option:selected").text() == log.calls[i][4] : true) &&
            ((onAssigned == onClosed && onAssigned == onPending && onAssigned != null) ? true :
            (onAssigned ? "Assigned" == log.calls[i][6] : false) ||
            (onPending ? "Pending" == log.calls[i][6] : false) ||
            (onClosed ? "Closed" == log.calls[i][6] : false))){
              var row = "<tr>";
              for (var j = 0; j < log.calls[i].length; j++) {
                if (j == 4){
                  row += "<td class='typetd'>"+log.calls[i][j]+"</td>";
                } else if (j == 5) {
                  row += "<td class='specialisttd'>"+log.calls[i][j]+"</td>";
                } else if (j == 6) {
                  row += "<td class='statustd'>"+log.calls[i][j]+"</td>";
                } else {
                  row += "<td>"+log.calls[i][j]+"</td>";
                }

              }
              row += "</tr>";
              rows += row;
            }
      }
        $("#callLogTable > tbody:last-child").append(rows);
      }

      function openModalDialog(dialog){
        dialog.attr("style","display:inline-block");
      }

      function closeModalDialog(dialog){
        dialog.removeAttr("style");
        dialog.attr("style","display:none;")
      }

      function openAssignSpecialistDialog(){
        if  ($("#callLogTable tbody tr.selected").length){
          if ($("#callLogTable tbody tr.selected td.statustd").html() != "Closed"){
            $("#assignSpecialistTypeSel").val($("#callLogTable tr.selected td.typetd").html()).change();
            openModalDialog($("#assignSpecialistModal"));
          }else {
            $("#errorTitle").html("Cannot Assign Specialist");
            $("#errorMsg").html("Problem is already closed.");
            openModalDialog($("#errorModal"));
          }
        } else {
          $("#errorTitle").html("No Problem Selected");
          $("#errorMsg").html("Select a problem to assign a specialist.");
          openModalDialog($("#errorModal"));
        }
      }

      function buttonRename(){
        if ($("#callLogTable tbody tr.selected td.statustd").html() == "Closed"){
            $("#closeProblemButton").val("Reopen Problem");
      } else {
        $("#closeProblemButton").val("Close Problem");
          }
      }

      function openProblemDialog(){
        if  ($("#callLogTable tbody tr.selected").length){
          if ($("#callLogTable tbody tr.selected td.statustd").html() != "Closed"){
            var probID = $("#callLogTable tbody tr.selected td:first").html();
            $("#closeProblemID").html("Problem ID: "+probID);
            openModalDialog($("#closeProblemModal"));
          }else {
            $("#errorTitle").html("Reopen Problem");
            $("#errorMsg").html("Problem has been reopened.");
            openModalDialog($("#errorModal"));
          }
        } else {
          $("#errorTitle").html("No Problem Selected");
          $("#errorMsg").html("Select a problem to close.");
          openModalDialog($("#errorModal"));
        }
      }

      function openViewSolutionDialog(){
        if  ($("#callLogTable tbody tr.selected").length){
          if ($("#callLogTable tbody tr.selected td.statustd").html() == "Closed"){
            var probID = $("#callLogTable tbody tr.selected td:first").html();
            $("#viewSolutionProblemID").html("Problem ID: "+probID);
            openModalDialog($("#viewSolutionModal"));
          } else {
            $("#errorTitle").html("No Solution");
            $("#errorMsg").html("Problem is not closed. No solution found.");
            openModalDialog($("#errorModal"));
          }
        } else {
          $("#errorTitle").html("No Problem Selected");
          $("#errorMsg").html("Select a problem to view the solution.");
          openModalDialog($("#errorModal"));
        }
      }

      function openProblemDetailsDialog(){
      	openModalDialog($("#problemDetailsModal"));
      }

      function openLinkSpecialityDialog(){
      	openModalDialog($("#linkSpecialityModal"));
      }

      function lookupSpecialists(){
        var problemType = $("#assignSpecialistTypeSel option:selected").text();
        if (problemType !== ""){
          $("#specialistTable tbody").html("");
          var rows = "";
          var row = '<tr><td>'+problemType+'</td><td>Alan</td><td>0</td></tr>';
          rows = row + row + row + row + row + row + row + row + row + row;
          $("#specialistTable tbody").append(rows);
        }
      }

      function assignSpecialistToProblem(){
        var row = Number($("#callLogTable tr.selected td:first").html()) - 1;
        var specialist = $("#specialistTable tr.selected td:first").next().html();
        var priority = $( "#myselect addProblemPriority:selected" ).text();
        log.calls[row][5] = specialist;
        log.calls[row][6] = "Assigned";
        log.calls[row][7] = priority;
        $("#callLogTable tr.selected td.specialisttd").text(specialist).change();
        $("#callLogTable tr.selected td.statustd").text("Assigned").change();
        $("#callLogTable tr.selected td.prioritytd").text(priority).change();
        showProblemDetails();
        closeModalDialog($('#assignSpecialistModal'));
      }

      function logout(){
        $.ajax({
          url: 'logouthandler.php',
          data: {},
          type: 'GET',
          success: function(response){
            window.location.href = "/";
          }
        });
      }


    </script>
  </head>
  <body>
    <div id="main">
      <header>
      <img  src="images/logo.png" width="110" height="90" id="logoLeft"/>
      <img  src="images/banner.png" width="300" height="100" id="banner"/>
      <img  src="images/logo.png" width="110" height="90" id="logoRight"/>
      </header>
      <div><input id= "logCallButton" type="button" class="table" value="Log Call" onclick="location.href='log_new_call.php';" /><br/>
      </div>


      <div style="position:relative;clear:both;">
        <div style="height:60%;overflow-y:scroll;border:1px solid black;">
          <table id="callLogTable" class="noselect">
            <thead>
              <tr>
                <th>Problem ID</th>
                <th>Caller</th>
                <th>Date</th>
                <th>Time</th>
                <th>Problem Type</th>
                <th>Specialist</th>
                <th>Status</th>
                <th>Priority</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div>
        <input type="button" id="assignSpecialistButton" value="Assign Specialist" onclick="openAssignSpecialistDialog();" />
        <input type="button" id="checkProblemDetailsButton" value="Problem Details" onclick="openProblemDetailsDialog();" />
        <input type="button" id="checkSolutionButton" value="View Solution" onclick="openViewSolutionDialog();" />
        <input type="button" id="closeProblemButton" value="Close Problem" onclick="openProblemDialog();" />
      </div>
    </div>

    <div id="left">

    <div id="user_details">
    <label>Username:</label>
    <input type="text" id="username_details" class="detailsText"/><br>
    <label>Name:</label>
    <input type="text" id="name_details" class="detailsText"/><br>
    </div>

      <div id="filter">
        <h2>Filter</h2>
        <div class="filterElement">
          <label>Problem ID</label><br/>
          <input type="text" id="filterID" class="filterText"/><br><br>
        </div>
        <div class="filterElement">
          <label>Caller Name</label><br/>
          <input type="text" id="filterName" class="filterText"/><br><br>
        </div>
        <div class="filterElement">
          <label>Problem Type</label><br/>
          <select class="problemTypeSel" id="filterType" class="filterText" style="width: 100%;"></select><br><br>
        </div>
        <div class="filterElement">
          <label>Status</label><br/>
          <input type= "checkbox" name= "Assigned" value= "Assigned" id= "filterAssigned"> Assigned </input> <br>
          <input type= "checkbox" name= "Pending" value= "Pending" id= "filterPending"> Pending </input> <br>
          <input type= "checkbox" name= "Closed" value= "Closed" id= "filterClosed"> Closed </input> <br>
        </div>
        <div class="lastfilterElement">
        <input type="button" id="applyFiltersBtn" value="Apply" onclick="filter();" />
        </div>
      </div></br>
    </div>

    <div id="right">
      <div>
        <input type="button" id="logoutBtn" class="utilityBtn" value="Log out" onclick="logout();"/>
        <input type="button" id="settingsBtn" class="utilityBtn" value="Password" onclick="window.location.href='change_password.php'"/>
        <input type="button" id="adminBtn" class="utilityBtn" value="Admin" onclick="window.location.href='admin.php'"/>
        <!--<input type="button" id="specialitiesBtn" class="utilityBtn" value="Specialities" onclick="openLinkSpecialityDialog();"/>-->

      </div>
    </div>

    <div id="problemDetailsModal" class= "problemModal">
      <div id="problemDetailsModalContent" class="problemModal-content">
      <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#problemDetailsModal'));" />
        </div>
        <h2>PROBLEM DETAILS</h2>

        <div class="modal-content-wrapper">

        <div class="problemModal-content-left">
        <div style="display: inline-block; text-align:left;">
          <label>Problem ID</label><br/>
          <input type="text" id="detailsID" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Helpdesk Operator</label><br/>
          <input type="text" id="detailsOperator" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Caller</label><br/>
          <input type="text" id="detailsCaller" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Status</label><br/>
          <input type="text" id="detailsStatus" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Date</label><br/>
          <input type="text" id="detailsDate" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Time</label><br/>
          <input type="text" id="detailsTime" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Problem Type</label><br/>
          <select class="problemTypeSel" id="detailsProblemType">
          </select>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Description</label><br/>
          <textarea rows=4 id="detailsDesc" disabled></textarea>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Specialist</label><br/>
          <input type="text" id="detailsSpecialist" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Problem Priority</label><br/>
          <select id="detailsProblemPriority">
          </select>
          </div>
        </div><br/>

        <div class="problemModal-content-right">
        <strong>Hardware</strong><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Serial No.</label><br/>
          <input type="text" id="detailsSerialNo" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Make</label><br/>
          <input type="text" id="detailsMake" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Model</label><br/>
          <input type="text" id="detailsModel" disabled/>
        </div><br/><br>
        <strong>Software</strong><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Operating System</label><br/>
          <input type="text" id="detailsSoftware" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Software</label><br/>
          <input type="text" id="detailsSoftware" disabled/>
        </div></div></br></br>
        <div id="problemDetailsButtons">
          <input type="button" id="cancelEditBtn" value="Cancel" onclick="cancelEdit();" />
          <input type="button" id="saveEditBtn" value="Save" onclick="saveEdit();" />
        </div>
      </div>
    </div>
    </div>

    <div  id="assignSpecialistModal" class="modal">
      <div id="assignSpecialistModalContent" class="modal-content">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#assignSpecialistModal'));" />
        </div>
        <h1 style="width:100%;">Assign Specialist</h1>
        <div class="modal-content-wrapper">
          <div class="modal-content-left">
            <div>
              <div>
              	<div>
                <div style="display:inline-block;">
                  <label class="sectionHeader">Problem Type:</label></br>
                  <select id="assignSpecialistTypeSel" class="problemTypeSel">
                  </select>
                </div>
                <input type="button" id="lookupSpecialistsBtn" value="Lookup Specialists" onclick="lookupSpecialists();" />
              </div>
              </br>
              <label class="sectionHeader">Problem Description:</label></br>
              <textarea id="addProblemTxtArea" disabled></textarea><br/>
            </div>
            <label class="sectionHeader">Problem Priority:</label></br>
          <select id="addProblemPriority" class="problemPrioritySel">
          	<option value='empty'></option>
            <option value='Networking'>Low</option>
            <option value='Printing'>Medium</option>
            <option value='Operating System'>High</option>
        	</select>
        </div>

            <div>
              <h2>Hardware</h2>
              <label class="sectionHeader">Serial No.:</label></br>
              <input type="text" disabled /></br>
              <label class="sectionHeader">Type:</label></br>
              <input type="text" disabled /></br>
              <label class="sectionHeader">Make:</label></br>
              <input type="text" disabled /></br>
            </div>
            <div>
              <h2>Software</h2>
              <label class="sectionHeader">Operating System:</label></br>
              <input type="text" disabled /></br>
              <label class="sectionHeader">Software:</label></br>
              <input type="text" disabled/></br>
            </div>
          </div>
          <div class="modal-content-right">
            <div style="height:300px;overflow:auto;">
              <table id="specialistTable">
                <thead>
                  <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Count</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
            </br></br>
            <input type="button" id="cancelProblemBtn" value="Cancel" onclick="closeModalDialog($('#assignSpecialistModal'));" />
            <input type="button" id="finishAddProblemBtn" value="Assign" onclick="assignSpecialistToProblem();" />
          </div>
        </div>
      </div>
    </div>

    <div  id="closeProblemModal" class="modal">
      <div id="closeProblemModalContent" class="modal-content" style="width:20%;">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#closeProblemModal'));" />
        </div>
        <h1 style="width:100%;">Close Problem</h1>
          <div class="modal-content-left" style="margin:auto;border:none;width:100%;">
            <h2 id="closeProblemID">Problem ID</h2>
            <label class="sectionHeader">Solution:</label></br>
            <textarea id="closeProblemSolTxtArea"></textarea>
            <label class="sectionHeader">Specialist:</label></br>
            <input type="text" /></br>
            <label class="sectionHeader">Date:</label></br>
            <input type="text" /></br>
            <label class="sectionHeader">Time:</label></br>
            <input type="text" /></br>
          </div>
          <div style="display:inline-block;margin:auto;">
            <input type="button" id="cancelProblemBtn" value="Cancel" onclick="closeModalDialog($('#closeProblemModal'));" />
            <input type="button" id="finishAddProblemBtn" value="Save" onclick="closeModalDialog($('#closeProblemModal'));" />
          </div>

      </div>
    </div>

    <div  id="viewSolutionModal" class="modal">
      <div id="viewSolutionModalContent" class="modal-content" style="width:20%;">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#viewSolutionModal'));" />
        </div>
        <h1 style="width:100%;">View Solution</h1>
          <div class="modal-content-left" style="margin:auto;border:none;width:100%;">
            <h2 id="viewSolutionProblemID">Problem ID</h2>
            <label class="sectionHeader">Solution:</label></br>
            <textarea id="closeProblemSolTxtArea" disabled ></textarea>
            <label class="sectionHeader">Specialist:</label></br>
            <input type="text" disabled /></br>
            <label class="sectionHeader">Date:</label></br>
            <input type="text" disabled /></br>
            <label class="sectionHeader">Time:</label></br>
            <input type="text" disabled /></br>
          </div>
          <div style="display:inline-block;margin:auto;">
            <input type="button" id="cancelProblemBtn" value="Exit" onclick="closeModalDialog($('#viewSolutionModal'));" />
          </div>
      </div>
    </div>

    <div  id="errorModal" class="modal">
      <div id="errorModalContent" class="modal-content" style="width:20%;">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#errorModal'));" />
        </div>
        <h1 id="errorTitle"></h1>
          <div class="modal-content-left" style="margin:auto;border:none;width:100%;">
            <label id="errorMsg" class="sectionHeader"></label></br>
          </div>
          <div style="display:inline-block;margin:auto;float:right;">
            <input type="button" id="cancelProblemBtn" value="OK" onclick="closeModalDialog($('#errorModal'));" />
          </div>
      </div>
    </div>

    <div id="linkSpecialityModal" class="modal">
      <div id="linkSpecialityModal" class="modal-content">
        <div>
          <input type="button" id="exitBtn" value="&times" onclick="closeModalDialog($('#linkSpecialityModal'));" />
        </div>
        <h1 style="width:100%;">Add Speciality</h1>


		<div class="typeInput">
  			<label class="" for="textinput">Speciality:</label>
			<select id="addSpeciality" class="problemPrioritySel">
          		<option value='empty'></option>
        	</select>
        	<input type="button" class="btnAddSpeciality" value="Add"><br><br>


  			<label class="" for="textinput">Current Specialities:</label><br><br>
  			<textarea id="currentSpecialitiesTxtArea" rows="4" cols="50"></textarea>
		</div>


		<div class="typeButtons">
			<input type="button" class="btnCancel" value="Cancel" onClick="closeModalDialog($('#linkSpecialityModal'));">
			<input type="button" class="btnAddProblemType" value="Save">
		</div>

      </div>
    </div>

  </body>
</html>
