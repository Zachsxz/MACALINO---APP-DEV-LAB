<?php
$result = "";
if (isset($_POST['convert'])) {
   $value = $_POST['value'];
   $from = $_POST['from'];
   $to = $_POST['to'];
   // convert to meters first
   if ($from == "cm") $meters = $value / 100;
   if ($from == "m") $meters = $value;
   if ($from == "km") $meters = $value * 1000;
   if ($from == "in") $meters = $value * 0.0254;
   if ($from == "ft") $meters = $value * 0.3048;
   if ($from == "yd") $meters = $value * 0.9144;
   // convert meters to target
   if ($to == "cm") $result = $meters * 100;
   if ($to == "m") $result = $meters;
   if ($to == "km") $result = $meters / 1000;
   if ($to == "in") $result = $meters / 0.0254;
   if ($to == "ft") $result = $meters / 0.3048;
   if ($to == "yd") $result = $meters / 0.9144;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Length Converter</title>
<link rel="stylesheet" href="stylephpop.css">
</head>
<body>
<div class="container">
<h2>Length Conversion</h2>
<form method="post">
<input type="number" name="value" placeholder="Enter value" required>
<select name="from">
<option value="cm">Centimeter</option>
<option value="m">Meter</option>
<option value="km">Kilometer</option>
<option value="in">Inch</option>
<option value="ft">Foot</option>
<option value="yd">Yard</option>
</select>
<span>to</span>
<select name="to">
<option value="cm">Centimeter</option>
<option value="m">Meter</option>
<option value="km">Kilometer</option>
<option value="in">Inch</option>
<option value="ft">Foot</option>
<option value="yd">Yard</option>
</select>
<button type="submit" name="convert">Convert</button>
</form>
<?php if ($result !== ""): ?>
<div class="result">
           Result: <?php echo round($result, 4); ?>
</div>
<?php endif; ?>
<h3>Common Conversions</h3>
<table>
<tr>
<th>Metric</th>
<th>Equivalent</th>
</tr>
<tr><td>1 meter</td><td>100 centimeters</td></tr>
<tr><td>1 kilometer</td><td>1000 meters</td></tr>
<tr><td>1 inch</td><td>2.54 centimeters</td></tr>
<tr><td>1 foot</td><td>12 inches</td></tr>
<tr><td>1 yard</td><td>3 feet</td></tr>
</table>
</div>
</body>
</html>