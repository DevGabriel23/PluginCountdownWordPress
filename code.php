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
date_default_timezone_set('America/Mexico_City');

//localtime();

$date = strtotime("August 28, 2022 4:00 PM");
$remaining = $date - time();

$days_remaining = floor($remaining / 86400);
$hours_remaining = floor(($remaining % 86400) / 3600);
$minutes_remaining = floor(($remaining % 3600) / 60);

echo "There are $days_remaining days and $hours_remaining hours and $minutes_remaining minutes left";
?>

