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
 * Plugin Name:       CountdownIDS
 * Description:       Description of the plugin.
 * Version:           1.0.0
 */

/*** Countdown Timer  ***/

include 'connect.php';
$con = connect_db();
$result = get_data($con);
//$result = mysqli_query($con,"SELECT * FROM `plugin-countdown`");
while($res = mysqli_fetch_array($result)){
    $datetime = $res['datetime'];
    $h = $res['hours'];
    $m = $res['minutes'];
    $s = $res['sec'];
}

//se supone que es la fecha guardada en la base de datos a la que se realiza el conteo

$date = date($datetime); 
$time = date($h.':'.$m.':'.$s);

// $date = date('2022-08-09');
// $time = date('13:16:00');
$date_today = $date . ' ' . $time;
echo "it will run until " .$date_today;
?>
<script type="text/javascript">
    //set date we are counting down to
    var count_id = "<?php echo $date_today; ?>";
    var countDownDate = new Date(count_id).getTime();
    //update the count down every 1 second
    var x = setInterval(function() {
        //get today date and time
        var now = new Date().getTime();
        //find distance between today and the count down date
        var distance = countDownDate - now;
        //calculate time
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60))/1000);
        //Output results
        document.getElementById("demo").innerHTML = days + "D " + hours + "H " + minutes + "M " + seconds + "S";
        //if the count down over
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
<?php
    //Se debe guardar la nueva fecha en la base de datos 
    $date = date('2022-08-14');
    $h = 2;
    $m = 30;
    $s = 24;
    insert($con, $date, $h, $m, $s);


    echo '<p id="demo" style="font-size:30px;"></p>'
?>