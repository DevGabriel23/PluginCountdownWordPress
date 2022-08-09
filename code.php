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

/*** Countdown Timer Shortcode ***/
$day = localtime();

$waiting_day = 1660056724;
$time_left = $waiting_day - time();

$days = floor($time_left / (60*60*24));
$time_left %= (60 * 60 * 24);

$hours = floor($time_left / (60 * 60));
$time_left %= (60 * 60);

$min = floor($time_left / 60);
$time_left %= 60;

$sec = $time_left;

echo "DAY: $day[3]";
echo "Remaing time: $days days and $hours hours and $min min and $sec sec left";
?>
