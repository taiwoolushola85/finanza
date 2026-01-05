<html>
<head>
<script type="text/javascript" src="jss/loader.js"></script>
<script type="text/javascript" src="jss/jquerys.min.js"></script>
<script type="text/javascript">
// Load the Visualization API and the piechart package.
google.charts.load('current', {'packages':['corechart']});
// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(line_chart);
function line_chart() 
{
var jsonData = $.ajax({
url: 'lim.php',
dataType:"json",
async: false,
success: function(jsonData)
{
var options = 
{
legend: 'none',
hAxis: { minValue: 0, maxValue: 9 },
curveType: 'function',
pointSize: 7,
dataOpacity: 0.3
};
var data = new google.visualization.arrayToDataTable(jsonData);	
var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
chart.draw(data, options);
}	
}).responseText;
}
</script>
</head>
<body>
<div class="row">
<div class="col-sm-12">
<!--Div that will hold the pie chart-->
<div><b>Product Default Chart</b></div>
<div id="line_chart" style="width:100%"></div>
</div>
</div>
</body>
</html>