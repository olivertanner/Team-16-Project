<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Call Log</title>
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){ //on page open
      var calls = [
        ["Alex","01-01-2017","13:00:00","Networking","Tom","No"],
        ["Ben","01-01-2017","13:00:00","Networking","Tom","No"],
        ["Charles","01-01-2017","13:00:00","Networking","Tom","No"]
      ];
      var rows = "";
      for (var i = 0; i < calls.length; i++) {
        var row = "<tr>";
        for (var j = 0; j < calls[i].length; j++) {
          row += "<td>"+calls[i][j]+"</td>";
        }
        row += "</tr>";
        rows += row;
      };
      $("#callLogTable > tbody:last-child").append(rows);
    })
    </script>
  </head>
  <body>
    <header><h1>Call Log</h1></header>
    <div>
      <input type='button' id='logCallButton' value='Log Call' onclick='' />
      <table id='callLogTable' border=1;>
        <tbody>
          <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Problem Type</th>
            <th>Specialist Assigned</th>
            <th>Closed</th>
          </tr>
        </tbody>
      </table>
    </div>
    <div style="inline-block">
      <input type='button' id='editProblemButton' value='Edit Problem' onclick='' />
      <input type='button' id='checkDetailsButton' value='Check Details' onclick='' />
      <input type='button' id='checkSolutionButton' value='Check Solution' onclick='' />
      <input type='button' id='closeProblemButton' value='Close Problem' onclick='' />
    </div>
  </body>
</html>
