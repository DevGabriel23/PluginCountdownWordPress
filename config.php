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
        $query = "SELECT * FROM `plugin-countdown`";
        $result = mysqli_query($con, $query);
        if(!$result){
            die("Query failed: " . mysqli_error($con));
        }else{
            echo("Query successful");
        }
        return $result;
    }

    function insert($con, $date, $h, $m, $s){
        $result = mysqli_query($con, "UPDATE `plugin-countdown` SET datetime='$date' WHERE id=1");
        $result = mysqli_query($con, "UPDATE `plugin-countdown` SET hours='$h' WHERE id=1");
        $result = mysqli_query($con, "UPDATE `plugin-countdown` SET minutes='$m' WHERE id=1");
        $result = mysqli_query($con, "UPDATE `plugin-countdown` SET sec='$s' WHERE id=1");	
        echo "Timer updated";
            
    }



?>