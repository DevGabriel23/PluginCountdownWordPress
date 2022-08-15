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
                'msg' => 'Countdown Expired',
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
        $pExpired = $atts['msg'];
        
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
            let strDaysCountdownPlugin, strHoursCountdownPlugin, strMinutesCountdownPlugin, strSecondsCountdownPlugin;
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
                strDaysCountdownPlugin = "0" + days;
            } else {
                strDaysCountdownPlugin = days;
            }
            if (hours < 10) {
                strHoursCountdownPlugin = "0" + hours;
            } else {
                strHoursCountdownPlugin = hours
            }
            if (minutes < 10) {
                strMinutesCountdownPlugin = "0" + minutes;
            } else {
                strMinutesCountdownPlugin = minutes;
            }
            if (seconds < 10) {
                strSecondsCountdownPlugin = "0" + seconds;
            } else {
                strSecondsCountdownPlugin = seconds;
            }
            document.getElementById("strDaysCountdownPlugin").innerHTML = strDaysCountdownPlugin + "<br>Days";
            document.getElementById("dpuntos").innerHTML = ":";
            document.getElementById("strHoursCountdownPlugin").innerHTML = strHoursCountdownPlugin + "<br>Hours";
            document.getElementById("hpuntos").innerHTML = ":";
            document.getElementById("strMinutesCountdownPlugin").innerHTML = strMinutesCountdownPlugin + "<br>Minutes";
            document.getElementById("mpuntos").innerHTML = ":";
            document.getElementById("strSecondsCountdownPlugin").innerHTML = strSecondsCountdownPlugin + "<br>Seconds";
            //if the count down over
            if (Math.floor(distance / 1000) < 0) {
                clearInterval(x);
                document.getElementById("countdownPlugin").style = "display: none";
                document.getElementById("fraseCountdownPlugin").style = "background-color:#D9D9D9;text-align: center; align-content: center;display:block";
                document.getElementById("countdownPluginExpired").innerHTML = "'.$pExpired.'";
                
            }
        }, 1000);
        </script>
        <div id="countdownPlugin" style="background-color:#D9D9D9;text-align: center; align-content: center; display: grid; grid-template-columns: repeat(7, 1fr);">
            <p id="strDaysCountdownPlugin" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="dpuntos" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="strHoursCountdownPlugin" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="hpuntos" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="strMinutesCountdownPlugin" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="mpuntos" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
            <p id="strSecondsCountdownPlugin" style="font-size:30px;padding: 10px 20px 10px 20px;"></p>
        </div>
        <div id="fraseCountdownPlugin" style="background-color:#D9D9D9;text-align: center; align-content: center;display:none;">
            <p style="font-size:30px;padding: 20px 20px 20px 20px;" id="countdownPluginExpired"></p>
        </div>';
        return $result;
    });
?>