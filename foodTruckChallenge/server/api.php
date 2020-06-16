<?php

include("FoodTruckController.php");
$foodTruck = new FoodTruckController();
if($_REQUEST['option']=="csv")
    echo $foodTruck->getFoodTruckNearestLocation((isset($_REQUEST['lat'])?$_REQUEST['lat']:37.78069438), (isset($_REQUEST['lon'])!=''?$_REQUEST['lon']:-122.4096688), $_REQUEST['records']);
else
    echo $foodTruck->getFoodTruckNearestLocationDB((isset($_REQUEST['lat'])?$_REQUEST['lat']:37.78069438), (isset($_REQUEST['lon'])!=''?$_REQUEST['lon']:-122.4096688), $_REQUEST['records']);

?>