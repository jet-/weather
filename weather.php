<html>

<style>
body, html {
  height: 100%;
  margin: 0;
}

.bg {
  /* The image used */
  background-image: url("picam.jpg");

  /* Full height */
  height: 100%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: 100% 100vh;
}
</style>
<head>
<title>Temperature</title>
<link href="css/udd.css" rel="stylesheet" type="text/css">


<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([

<?php
if ($_POST['parameter']=='temperature') { echo "['Time', 'Temperature'],"; }
if ($_POST['parameter']=='humidity'   ) { echo "['Time', 'Humidity'],"; }
if ($_POST['parameter']=='pressure'   ) { echo "['Time', 'Air Pressure'],"; }

require_once("conf.php");

$query = "SELECT * FROM temperatures WHERE dateMeasured >=\"". $_POST['from']."\" and dateMeasured <=\"". $_POST['to']."\" ";
$result = $mysqli->query($query); 
 
while ($row = $result->fetch_assoc() )
{
$time = $row['dateMeasured'] . ' | ' . $row['hourMeasured'] .'h';
$temp = $row['temperature'];
$hum = $row['humidity'];
$press = $row['pressure'];
if ($_POST['parameter']=='temperature') { echo "['$time', $temp],"; }
if ($_POST['parameter']=='humidity'   ) { echo "['$time', $hum],"; }
if ($_POST['parameter']=='pressure'   ) { echo "['$time', $press],"; }
}
?>
]);
 
var options = {
curveType: 'function',


<?php
if ($_POST['parameter']=='temperature') { ?> title: 'Temperature' ,vAxis: { title: "Degrees Celsius" }<?php }
if ($_POST['parameter']=='humidity'   ) { ?> title: 'Humidity'    ,vAxis: { title: "%" }<?php }
if ($_POST['parameter']=='pressure'   ) { ?> title: 'Air Pressure',vAxis: { title: "HPa" }<?php }
?>

};
 
var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
chart.draw(data, options);
}
</script>
</head>
<body>
<?php #<div class="bg"> ?>


<br><br><br>
<form name="form" action="<?php echo $PHP_SELF;?>" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Report</legend>
    &nbsp;&nbsp;&nbsp;
   <b> From date</b>:   <input type="text"   name="from" value= "<?= date("Y-m-d"); ?>" size=10 maxlength=10  style="background: #FFFFCC;" > &nbsp;&nbsp;&nbsp;
   <b> To date</b>:     <input type="text"   name="to"   value= "<?= date("Y-m-d"); ?>" size=10 maxlength=10  style="background: #FFFFCC;" >
   <input type="radio"   name="parameter"   value= "temperature" checked> Temperature
   <input type="radio"   name="parameter"   value= "humidity" > Humidity
   <input type="radio"   name="parameter"   value= "pressure" > Air Pressure
   <input type="checkbox" name="dw" value="yes" > Double window size &nbsp;&nbsp;

                        <input type="submit" name="send" value="Generate" autofocus>
<br><br>

</fieldset>
</form>


<?php 

if ($_POST['dw'] <> "yes" ) { 
		echo '<div id="chart_div" style="width: 900px; height: 500px;"></div>';
	} else {
		echo '<div id="chart_div" style="width: 1800px; height: 1000px;"></div>';
}

echo "<font size=14> &nbsp &nbsp $temp º -- $hum % -- $press HPa </font>";

$query = "SELECT min(temperature) as min, max(temperature) as max, avg(temperature) as avg, count(*) as count  
            FROM temperatures 
            WHERE dateMeasured >=\"". $_POST['from']."\" and dateMeasured <=\"". $_POST['to']."\" ";

#$result = mysqli_query($con, $query);
$result = $mysqli->query($query);
while ($row = $result->fetch_assoc() )
{
    $min = $row['min'];
    $max = $row['max'];
    $avg = $row['avg'];
    $count = $row['count'];
}

echo "Min: $min -- Max: $max -- Avg: " . number_format($avg,2) . " -- for $count measures";


?>
<p>

<table class="table table-bordered tablesorter">
<caption> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;from: <? echo $_POST['from']; ?>  to:  <? echo $_POST['to']; ?> </caption>
<thead><tr> 
                <th> # </th> 
                <th>Index  </th> 
                <th> Date </th> 
                <th> Hour</th>  
                <th> Temp </th> 
                <th> Humidity</th> 
                <th> Pressure</th> 
                <th> Time stamp</th> 
                <th> Text</th> 
              </tr></thead>
<?php
$query = "SELECT * 
            FROM temperatures 
            WHERE dateMeasured >=\"". $_POST['from']."\" and dateMeasured <=\"". $_POST['to']."\" ";

$result = $mysqli->query($query);
$i=0;

$output = fopen('data.csv', 'w');

// output the column headings
fputcsv($output, array('#', 'Temp', 'Humidity', 'Date', 'Hour', 'Pressure', 'Timestamp', 'Text'));


while ($row = $result->fetch_assoc())
{
    fputcsv($output, $row);
    $time = $row['dateMeasured'];
    $hour = $row['hourMeasured'];
    $temp = $row['temperature'];
    $humid = $row['humidity'];
    $press = $row['pressure'];    
    $timestamp = $row['time'];



    if ($i%2 ==0 ) {
                         echo '<tr style="background: #eeeeee;" >';
                  } else {
                         echo '<tr style="background: #cccccc;" >';
                }
                $i++;
                echo "<td width=\"20\"> <a href=\"entry.php?id=" . $row['id'] . "\">". $row['id'] .               "</a></td>";
                echo " <td> $i </td> <td> $time </td> <td> $hour </td> <td>  $temp </td>  <td align=right> $humid </td> <td align=right> $press </td> <td> $timestamp </td>";
                echo "<td width=\"400\"> " . ($row['text']=="" ? ".": stripslashes($row['text'])) . " </td>";
                echo "</tr>";


}

$mysqli->close();
fclose($output);
?>
</table>
<br><br>
<a href="data.csv" target="_blank">
<input type="button" class="button" value="Export CSV" />
</a>

</div>

</body>
</html>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="js/dmd.js"></script>

    
