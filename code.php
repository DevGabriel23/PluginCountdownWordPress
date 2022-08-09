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
$date = date('2022-08-09');
$time = date('13:16:00');
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
echo '<p id="demo" style="font-size:30px;"></p>'
?>