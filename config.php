<?php
    function connect_db(){
        $dbHost= 'localhost';
        $dbName= 'wordpress';
        $dbUsername= 'root';
        $dbPassword= '';

        $mysqli = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
        return $mysqli;
    }

    function get_data($con){
        $query = "SELECT * FROM `plugin-countdown` ORDER by ID DESC";
        $result = mysqli_query($con, $query);
        if(!$result){
            die("Query failed: " . mysqli_error($con));
        }else{
            echo "<script>console.log('Query successful')</script>";
        }
        return $result;
    }
    
    function insert($con, $date, $h, $m, $s){
        $consult = get_data($con);
        while($res = mysqli_fetch_array($consult)){
            $datetime = $res['datetime'];
            $hour = $res['hours'];
            $minute = $res['minutes'];
            $second = $res['sec'];
        }
        if($date != $datetime || $h != $hour || $m != $minute || $s != $second){
            $result = mysqli_query($con,"INSERT INTO `plugin-countdown` (hours,minutes,sec,datetime) VALUES ('$h','$m','$s','$date')");
            if(!$result){
                $error = mysqli_error($con);
                echo "<script>console.log('Not updated '+'.(string)$error'.)</script>";
            }else{
                echo "<script>console.log('Timer updated')</script>";
            }
        }
    }
?>
