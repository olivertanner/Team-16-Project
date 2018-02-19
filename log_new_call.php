<?php
session_start();
 ?>
<html>
  <head>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Log new call</title>
    <style type="text/css">
	   @import url("stylesheet.css");
    </style>
    <?php
    include 'dblogin.php';
    include 'problem.php';


    function populateFields(){
      $db = dblogin();
      $sql = "SELECT * FROM hardware;";
      $result = mysqli_query($db,$sql) or die("Error");
      while ($row = mysqli_fetch_array($result)) {
       echo '<option>' . $row['id'] . ' ' . $row['type'] . ' ' . $row['serial_no'] . ' ' . $row['make'] . '</option>' .'<br />';
      }
    }
     ?>
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){ //on page open
      var userid;
      var user;
      $.ajax({
        url: "sessionhandler.php",
        data: {},
        type: "GET",
        dataType: "json",
        success: function(response){
          user = response.username;
          $("#operatorInput").val(user);
        }
      });
      var date = new Date();
      var currentDate = ('0' + date.getDate()).slice(-2)+"/"
      +("0" + (date.getMonth()+1)).slice(-2)+"/"
      +date.getFullYear();
      var currentTime = ("0" + date.getHours()).slice(-2)+":"
      +("0" + date.getMinutes()).slice(-2)+":"
      +("0" + date.getSeconds()).slice(-2);
      $("#dateInput").val(currentDate);
      $("#timeInput").val(currentTime);
      $.ajax({
        url: 'get_problem_types.php',
        data: {},
        type: 'GET',
        success: function(response){
          $("#addProblemTypeSel").append(response);
        }
      });

    });

    $(document).on("click", "table tbody tr", function(e) {
      $(this).addClass("selected").siblings().removeClass("selected");
    });

    function openAddProblemDialog(){
      $("#addProblemModal").attr("style","display:inline-block");
    }

    function closeAddProblemDialog(){
      $("#addProblemModal").removeAttr("style");
      $("#addProblemModal").attr("style","display:none");
    }

    function lookupCaller(){
      if ($("#callerLookupTableWrapper:visible").length == 0){
        $("#callerTable > tbody").html("");
        $.ajax({
          url: 'lookup_caller.php',
          data: {search: $("#nameInput").val()},
          type: 'POST',
          dataType: 'json',
          success: function(response){
            if (response.length > 0){
              for (var i = 0; i < response.length; i++) {
                var id = response[i].id;
                var name = response[i].name;
                var job = response[i].job;
                var dept = response[i].dept;
                var row = "<tr><td id='callerIdtd'>"+id+"</td>";
                row+="<td id='callerNametd'>"+name+"</td>";
                row+="<td id='callerJobtd'>"+job+"</td>";
                row+="<td id='callerDepttd'>"+dept+"</td></tr>";
                $("#callerTable tbody").append(row);
              }
            }
          }
        });
        $("#lookupCallerBtn").val("Back");
        $("#callerLookupTableWrapper").attr("style","display:inline-block;");
      } else {
        $("#lookupCallerBtn").val("Lookup");
        $("#callerLookupTableWrapper").attr("style","display:none;");
      }
    }

    function lookupSpecialists(){
      $.ajax({
        url: 'get_specialists.php',
        data: {},
        type: 'POST',
        dataType: 'json',
        success: function(response){
          if (!response.success){
            alert(response.msg);
          }
        }
      })
      /*var problemType = $("#addProblemTypeSel option:selected").text();
      if (problemType !== ""){
        $("#specialistTable tbody").html("");
        var rows = "";
        var row = '<tr><td>'+problemType+'</td><td>Alan</td><td>0</td></tr>';
        rows = row + row + row + row + row + row + row + row + row + row;
        $("#specialistTable tbody").append(rows);
      }*/
    }

    function addProblem(){
      var problemID = Math.floor(Math.random()*1000);
      var problemType = $("#addProblemTypeSel option:selected").text();
      var specialistName = $("#specialistTable tr.selected").length ? $("#specialistTable tr.selected td:first").next().text() : "None";
      var problemPriority = $("#addProblemPriority option:selected").text();
      var row = '<tr><td>'+problemID+'</td><td>'+problemType+'</td><td>'+specialistName+'</td><td>'+problemPriority+'</td></tr>';
      $("#problemTable tbody").append(row);
      closeAddProblemDialog();
    }

    $(document).on("dblclick", "#callerTable tbody tr", function(e) {
      $("#idNoInput").val($("#callerTable tbody tr.selected td#callerIDtd").html());
      $("#nameInput").val($("#callerTable tbody tr.selected td#callerNametd").html());
      $("#jobTitleInput").val($("#callerTable tbody tr.selected td#callerJobtd").html());
      $("#deptInput").val($("#callerTable tbody tr.selected td#callerDepttd").html());
      $("#lookupCallerBtn").val("Lookup");
      $("#callerLookupTableWrapper").attr("style","display:none;")
    });
    </script>
  </head>
  <body>
    <div id="main">
      <header><h3>Log New Call</h3></header>
      <div id="content">
    	   <div id="contentLeft">
            <div id="operator">
            <h2>HELPDESK OPERATOR</h2>
            <label class="sectionHeader">Operator Name:</label></br>
            <input type="text" id="operatorInput"/></br>
            <label class="operatorLabels">Date:</label></br>
            <input type="text" id="dateInput" /></br>
            <label class="operatorLabels">Time:</label></br>
            <input type="text" id="timeInput" />
          </div><br/>

          <div id="caller">
            <header><h2>CALLER</h2></header>
            <label>Caller Name:</label></br>
            <input id="nameInput" type="text" size="20"/>
            <input style="" type="button" id="lookupCallerBtn" value="Lookup" onclick="lookupCaller();" /></br>
            <div style="position:relative;">
              <label >ID No:</label></br>
              <input type="text" id="idNoInput"/></br>
              <label >Job Title:</label></br>
              <input type="text" id="jobTitleInput" /></br>
              <label >Department:</label></br>
              <input type="text" id="deptInput" /></br>
              <div id="callerLookupTableWrapper" style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:#e0e0e0;overflow:auto;">
                <table id="callerTable" class="noselect">
                  <thead>
                    <tr>
                      <td>ID</td>
                      <td>Name</td>
                      <td>Job</td>
                      <td>Dept</td>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          <label>Reason for call:</label>
          <textarea rows="4"  style= resize:none ></textarea></br></br>
        </div>
      </div>

	    <div id="contentright">
        <h2>PROBLEMS</h2></br>
        <div id="contentright_buttons">
        <input type="button" id="addProblemBtn" value="Add Problem" onclick="openAddProblemDialog();" />
        <input type="button" id="rmvProblemBtn" value="Remove Problem" onclick="$('#problemTable tr.selected').remove();" />
        </br>
        </br>
        </div>
        <table id="problemTable" style="width: 80%;">
          <thead>
            <tr>
              <th>Problem ID</th>
              <th>Problem Type</th>
              <th>Specialist Assigned</th>
              <th>Priority</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table></br>
      </div>
    </div>
      <div style="display: inline-block; text-align:left;">
        <input type="button" id="cancelCallBtn" value="Cancel" onclick="location.href='call_log.php';" />
        <input type="button" id="logCallBtn" value="Log Call" onclick="location.href='call_log.php';" />
      </div>
    </div>
    <div id="left2"></div>
    <div id="right2"></div>
    <div  id="addProblemModal" class="modal">
      <div id="addProblemModalContent" class="modal-content">
        <div>
      	   <input type="button" id="exitBtn" value="&times" onclick="closeAddProblemDialog();" />
         </div>
        <h1 style="width:100%;">Add Problem</h1>
        <div class="modal-content-wrapper">
        <div class="modal-content-left">
          <div>
            <div>
            <div>
              <div style="display:inline-block;">
                <label class="sectionHeader">Problem Type:</label></br>
                <select id="addProblemTypeSel" class="problemTypeSel">
                </select>
              </div>
              <input type="button" id="lookupSpecialistsBtn" value="Lookup Specialists" onclick="lookupSpecialists();" />
            </div>
            </br>
            <label class="sectionHeader">Problem Description:</label></br>
            <textarea id="addProblemTxtArea"></textarea><br>
        <label class="sectionHeader">Problem Priority:</label></br>
          <select id="addProblemPriority" class="problemPrioritySel">
          	<option value='empty'></option>
            <option value='Networking'>Low</option>
            <option value='Printing'>Medium</option>
            <option value='Operating System'>High</option>
          </select>
          </div>
          </div>
          <div>
            <h2>Hardware</h2>
            <datalist id="hardwareTypeList"></datalist>
            <label class="sectionHeader">Serial No.:</label></br>
   			<select id="addHardware" class="problemPrioritySel">
          </select>
          </div>
          <div>
            <h2>Software</h2>
            <label class="sectionHeader">Operating System:</label></br>
            <select id="addOS" class="problemPrioritySel">
          </select></br>
            <label class="sectionHeader">Software:</label></br>
            <select id="addSoftware" class="problemPrioritySel">
          </select></br>
            <input type="button" id="checkLicenceBtn" value="Check Licence" onclick=""/></br>
          </div>
        </div>
        <div class="modal-content-right">
          <h1>Specialists</h1>
          <div style="height:300px;overflow:auto;">
            <table id="specialistTable">
              <thead>
                <tr>
                  <th>Specialist ID</th>
                  <th>Name</th>
                  <th>Related Speciality</th>
                  <th>Workload</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          </br></br>
        <input type="button" id="cancelProblemBtn" value="Cancel" onclick="closeAddProblemDialog();" />
        <input type="button" id="finishAddProblemBtn" value="Add" onclick="addProblem();" />
      </div>
    </div>
      </div>
    </div>
  </body>
</html>
