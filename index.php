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
          ["1","Alex","01-01-2017","13:00:00","Networking","Tom","Assigned"],
          ["2","Ben","01-01-2017","13:00:00","Networking","None","Pending"],
          ["3","Charles","01-01-2017","13:00:00","Networking","Tom","Closed"],
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

        $(document).on("click", "table tbody tr", function(e) {
          if($(this).hasClass("selected")){
            $(this).removeClass("selected");
          } else {
            $(this).addClass("selected").siblings().removeClass("selected");
          }
          if ($(this).hasClass("selected")) {
            showProblemDetails();
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
      }

      function clearProblemDetails(){
        $("#detailsID").val("");
        $("#detailsCaller").val("");
        $("#detailsDate").val("");
        $("#detailsTime").val("");
        $("#detailsProblemType").val("").change();
        $("#detailsSpecialist").val("");
        $("#detailsStatus").val("");
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
          onStatus = false;
        if ($.trim($("#filterID").val()).length > 0){
          onID = true;
        }
        if ($.trim($("#filterName").val()).length > 0){
          onName = true;
        }
        if ($("#filterType option:selected").text() != ""){
          onType = true;
        }
        if ($("#filterStatus option:selected").val() != "All"){
          onStatus = true;
        }
        var rows = "";
        for (var i = 0; i < log.calls.length; i++) {
          if ((onID ? $("#filterID").val() == log.calls[i][0] : true) &&
            (onName ? $("#filterName").val() == log.calls[i][1] : true) &&
            (onType ? $("#filterType option:selected").text() == log.calls[i][4] : true) &&
            (onStatus ? $("#filterStatus option:selected").text() == log.calls[i][6] : true)){
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

      function openCloseProblemDialog(){
        if  ($("#callLogTable tbody tr.selected").length){
          if ($("#callLogTable tbody tr.selected td.statustd").html() != "Closed"){
            var probID = $("#callLogTable tbody tr.selected td:first").html();
            $("#closeProblemID").html("Problem ID: "+probID);
            openModalDialog($("#closeProblemModal"));
          }else {
            $("#errorTitle").html("Cannot Close Problem");
            $("#errorMsg").html("Problem is already closed.");
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
        log.calls[row][5] = specialist;
        log.calls[row][6] = "Assigned";
        $("#callLogTable tr.selected td.specialisttd").text(specialist).change();
        $("#callLogTable tr.selected td.statustd").text("Assigned").change();
        showProblemDetails();
        closeModalDialog($('#assignSpecialistModal'));
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
      <input id= "logCallButton" type="button" class="table" value="Log Call" onclick="location.href='log_new_call.php';" /><br/>
      <div style="position:relative;">
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
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
      <div>
        <input type="button" id="assignSpecialistButton" value="Assign Specialist" onclick="openAssignSpecialistDialog();" />
        <input type="button" id="checkSolutionButton" value="View Solution" onclick="openViewSolutionDialog();" />
        <input type="button" id="closeProblemButton" value="Close Problem" onclick="openCloseProblemDialog();" />
      </div>
    </div>

    <div id="left">
      <div style="margin:auto;">
        <h2>FILTER</h2>
        <div style="display: inline-block; text-align:left;">
          <label>Problem ID</label><br/>
          <input type="text" id="filterID"/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Caller Name</label><br/>
          <input type="text" id="filterName"/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Problem Type</label><br/>
          <select class="problemTypeSel" id="filterType">
          </select>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Status</label><br/>
          <select id="filterStatus">
            <option value="All">All</option>
            <option value="Assigned">Assigned</option>
            <option value="Pending">Pending</option>
            <option value="Closed">Closed</option>
          </select>
        </div><br/>
        <input type="button" id="applyFiltersBtn" value="Apply" onclick="filter();" />
      </div>
    </div>

    <div id="right">
      <div style="margin:0 auto;">
        <h2>PROBLEM DETAILS</h2>
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
        </div><br/>
        <strong>Software</strong><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Operating System</label><br/>
          <input type="text" id="detailsSoftware" disabled/>
        </div><br/>
        <div style="display: inline-block; text-align:left;">
          <label>Software</label><br/>
          <input type="text" id="detailsSoftware" disabled/>
        </div><br/>
        <div>
          <input type="button" id="cancelEditBtn" value="Cancel" onclick="cancelEdit();" disabled/>
          <input type="button" id="saveEditBtn" value="Save" onclick="saveEdit();" disabled/>
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
  </body>
</html>
