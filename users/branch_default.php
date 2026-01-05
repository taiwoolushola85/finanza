<html>
<head>
<!--Load the AJAX API-->
<script type="text/javascript" src="jss/load.min.js"></script>
<script type="text/javascript" src="jss/chart.min.js"></script>
<script type="text/javascript">
// Load the Visualization API and the piechart package.
google.charts.load('current', {'packages':['corechart']});
// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(column_chart);
function column_chart() {
var jsonData = $.ajax({
url: 'bra_de.php',
dataType:"json",
async: false,
success: function(jsonData)
{
var data = new google.visualization.arrayToDataTable(jsonData);	
var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_values'));
chart.draw(data);
}	
}).responseText;
}
</script>
</head>
<body>
<div class="row">
<div class="col-sm-12">
<!--Div that will hold the pie chart-->
<div ><b>Branch Default Chart</b></div>
<div id="columnchart_values" style="width:100%"></div>
</div>
</div>
</body>
</html>
