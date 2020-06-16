<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Food Truck Challenge</title>
    <link rel="stylesheet" href="client/foodtruck.css">
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
  

</head>
<body>
 
<form method="post">
  <div>
  Latitude: <input type="text"  name="lat" id="lat" /> <br/><br/>
  Longitude: <input type="text" name="lon" id="lon" value="" /><br/><br/>
  Min records:<select name="records"><option value="10">10</option><option value="15">15</option></select><br/><br/>
  Option:<select name="option"><option value="db">DB</option><option value="csv">CSV</option></select><br/><br/><br/>
<input type="submit" name="submit" value="Retrieve Food Trucks" />
    
  </div>
  <br/>
  <div class="container">
 
</div>
</form>
<span></span>
 
<script src="client/foodtruck.js"></script>
 
</body>
</html>