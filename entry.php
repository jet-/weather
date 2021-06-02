<?php

#require_once("menu.php");
require_once("conf.php");


if (!isset($_POST['send']) ) {

    if (isset($_GET['id']) ) {
        $query="SELECT * from temperatures  WHERE id=" . $_GET['id'];
	$result = $mysqli->query($query);
	$row = $result->fetch_assoc();
    }
?>

<br><br><br>
<form name="form" action="<?php echo $PHP_SELF;?>" method="post" enctype="multipart/form-data">

<fieldset>
<legend>Edit Notes</legend>

<table> 
<br><br><br><br><br>

<tr style="background: #C1FF69;" align="center"> 
  <th> Date </th>  
  <th> Hour </th> 
  <th> Temperture </th> 
  <th> Humidity </th> 
  <th> Air Pressure </th>  
  <th> Notes </th> 
</tr>

    <tr align="center" valign="top" > 
    <td> <?php echo $row['dateMeasured']; ?> </td>
    <td> <?php echo $row['hourMeasured']; ?> </td>
    <td> <?php echo $row['temperature']; ?> </td>
    <td> <?php echo $row['humidity']; ?> </td>
    <td> <?php echo $row['pressure']; ?> </td>

    <td> 
	<textarea 
		name=note  rows=4 cols=70 wrap=physical style="background: #FFFFCC;" ><?php echo (isset($row['text'])) ? stripslashes($row['text']) : NULL; ?></textarea> 
    </td>

    <td> 
    <td>
</tr>

<tr> </tr>
<tr>	<td>    	<input type="submit" name="send" value="Proceed"> </td> </tr>

</fieldset> 
</form>

</table>
<?php

}else{

$query= "UPDATE temperatures set text=\"" . mysqli_real_escape_string($mysqli,$_POST['note']) . "\" WHERE id=" . $_GET['id'];


$result = $mysqli->query($query);
}

$mysqli->close();
?>
