<?php
    /**
     * Plugin Name
     *
     * @package           CountdownPluginIDS
     * @author            Alejandro Mota, Gabriel Ramon, Cesar Sanchez, Marisol Solis
     * @copyright         2022 HighBits
     *
     * @wordpress-plugin
     * 
     * Plugin Name:       CountdownIDS ⏲
     * Description:       Description of the plugin.
     * Version:           1.0.0
     */
    include 'config.php';

    add_shortcode( 'countdown', function($atts, $content){    
        
        // Attributes
        $atts = shortcode_atts(
            array(
                'date' => '',
                'time' => '12:00:00',
            ),
            $atts
        );
        //create a DateTime object
        $datetime = new DateTime($atts['date']);
        $date = $datetime->format('Y-m-d'); //format DateTime object to 'yyyy-mm-dd'
        $dateArray = explode("-",$date);
        $year = $dateArray[0]; 
        $month = $dateArray[1]; 
        $day = $dateArray[2];  
        $time = date($atts['time']);
        $timeArray = explode(":",$time); 
        $h = $timeArray[0];
        $m = $timeArray[1];
        $s = $timeArray[2];
        
        $con = connect_db();
        if (checkdate((int) $month, (int)$day, (int)$year)) { //Valid date 
            if ((int)$h < 24 && (int)$h >= 0) {
                if ((int)$m < 60 && (int)$m >= 0) {
                    if ((int)$s < 60 && (int)$s >= 0) {
                        insert($con, $date, $h, $m, $s);
                    } else {
                        echo "<script>console.log('Valor inválido para segundos')</script>";
                    }
                } else {
                    echo "<script>console.log('Valor inválido para minutos')</script>";
                }
            } else {
                echo "<script>console.log('Valor inválido para horas')</script>";
            }
        }else{
            echo "<script>console.log('Valor inválido para fecha')</script>";
        }

        $result = get_data($con);
        while($res = mysqli_fetch_array($result)){
            $datetime = $res['datetime'];
            $h = $res['hours'];
            $m = $res['minutes'];
            $s = $res['sec'];
        }

        $dateDB = date($datetime); 
        $timeDB = date($h.':'.$m.':'.$s);
        /*** Countdown Timer  ***/
        $date_today = $dateDB . ' ' . $timeDB;
        
        $result = '
        <script type="text/javascript">
            //set date we are counting down to
            let count_id ="'.$date_today.'";
            let countDownDate = new Date(count_id).getTime();
            //update the count down every 1 second
            let strDays, strHours, strMinutes, strSeconds,countdown;
            let x = setInterval(function() {
            //get today date and time
            let now = new Date().getTime();
            //find distance between today and the count down date
            let distance = countDownDate - now;
            //calculate time
            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
            //Output results
            if (days < 10) {
                strDays = "0" + days;
            } else {
                strDays = days;
            }
            if (hours < 10) {
                strHours = "0" + hours;
            } else {
                strHours = hours
            }
            if (minutes < 10) {
                strMinutes = "0" + minutes;
            } else {
                strMinutes = minutes;
            }
            if (seconds < 10) {
                strSeconds = "0" + seconds;
            } else {
                strSeconds = seconds;
            }
            document.getElementById("d").innerHTML = strDays + "<br>Days";
            document.getElementById("dpuntos").innerHTML = ":";
            document.getElementById("h").innerHTML = strHours + "<br>Hours";
            document.getElementById("hpuntos").innerHTML = ":";
            document.getElementById("m").innerHTML = strMinutes + "<br>Minutes";
            document.getElementById("mpuntos").innerHTML = ":";
            document.getElementById("s").innerHTML = strSeconds + "<br>Seconds";
            //if the count down over
            if (Math.floor(distance / 1000) < 0) {
                clearInterval(x);
                document.getElementById("d").innerHTML = "";
                document.getElementById("dpuntos").innerHTML = "";
                document.getElementById("h").innerHTML = "COUNTDOWN";
                document.getElementById("hpuntos").innerHTML = "";    
                document.getElementById("m").innerHTML = "EXPIRED";
                document.getElementById("mpuntos").innerHTML = "";
                document.getElementById("s").innerHTML = "";
            }
        }, 1000);
        </script>
        <div style="background-color:#D9D9D9;text-align: center; align-content: center; display: grid; grid-template-columns: repeat(7, 1fr);">
            <p id="d" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="dpuntos" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="h" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="hpuntos" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="m" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="mpuntos" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="s" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
        </div>';

        return $result;
    });
?>