<?php
include("Database.php");
Class FoodTruckController {
    
    private $db;
    
    function __construct() {
        $this->db = Database::connect();
    } 
    /**
     * getFoodTruckNearestLocation -- This method returns JSON data of all foodtrucks
                                    in a partular Latitude/Longitude retrieved from csv
     *
     * @param lat   Input Latitude
     * @param lon   Input Longitude
       @param countofloc Input number of min records want to show on UI.
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Monkey Coder <mcoder@facebook.com>
     * @return Status
     */ 
    public function getFoodTruckNearestLocation($lat, $lon ,$countOfLoc) {
         try {
            $rows   = array_map('str_getcsv', file('../Mobile_Food_Facility_Permit.csv'));
            $header = array_shift($rows);
            $csv    = array();
            $counter = 1;
            $myJSON = array();
            foreach($rows as $row) {
                $a = $lat - $row[14];
                $b = $lon -  $row[15];
                $distance = sqrt(($a**2) + ($b**2));
                $distances[$row[0]] = $distance;
                $array[$row[0]] = $row;
                $csv[$row[0]] = array_combine($header, $row);
            }
            asort($distances);
            $counter = 1;
            $myJSON = array();
            foreach($distances as $id=>$value) {
                
                $foodTruck[] = array('name'=>$csv[$id]['Applicant'], 
                                     "address"=>$csv[$id]['LocationDescription'],
                                     "facilityType"=>$csv[$id]['FacilityType']);
                if($counter++ >$countOfLoc) break;
            }
         } catch (Exception $e) {
             return json_encode(array("error"=>"true","description"=>"Exception"));
         }
        return json_encode($foodTruck);
    }
        /**
     * getFoodTruckNearestLocationDB -- This method returns JSON data of all foodtrucks
                                         in a partular Latitude/Longitude retrieved from MYSQL db.
     *
     * @param lat   Input Latitude
     * @param lon   Input Longitude
       @param countofloc Input number of min records want to show on UI.
     * 
     * @throws Some_Exception_Class If something interesting cannot happen
     * @author Monkey Coder <mcoder@facebook.com>
     * @return Status
     */ 
    public function getFoodTruckNearestLocationDB($lat, $lon ,$countOfLoc) {
        try{
            $query = "
                    SELECT * FROM (
                        SELECT *, 
                            (
                                (
                                    (
                                        acos(
                                            sin(( $lat * pi() / 180))
                                            *
                                            sin(( `Latitude` * pi() / 180)) + cos(( $lat * pi() /180 ))
                                            *
                                            cos(( `Latitude` * pi() / 180)) * cos((( $lon - `Longitude`) * pi()/180)))
                                    ) * 180/pi()
                                ) * 60 * 1.1515 * 1.609344
                            )
                        as distance FROM mobile_food_facility_permit
                    ) markers order by distance asc 
                    
                    LIMIT $countOfLoc;";
                    //echo $query;
            $result = $this->db->query($query);
            $foodTruck = array();
            if ($result->num_rows > 0) {
                // output data of each row
                $counter = 1;
                while($row = $result->fetch_assoc()) {
                    $foodTrucks[] = array(  "name"=>$row["Applicant"], 
                                          "address"=>$row["LocationDescription"],
                                          "facilityType"=>$row["FacilityType"]);
                    if($counter++ >$countOfLoc) break;
                }
            }
        } catch (Exception $e) {
             return json_encode(array("error"=>"true","description"=>"Exception"));
         }
    return json_encode($foodTrucks);
    }

}
?>