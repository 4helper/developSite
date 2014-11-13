<?php

$br = "</br>";
echo "phone test".$br;

$phoneNumber = "8618611697407";
$phoneNumber1 = "+8618611697407";
$phoneNumber2 = "18611697407";
$phoneNumber3 = "15304059998";

echo $phoneNumber.$br;
echo $phoneNumber1.$br;
echo $phoneNumber2.$br;



$pattern = '/^((\+86)|(86))/';
$out = preg_replace($pattern, '', $phoneNumber);
echo $phoneNumber."--".$out.$br;
$out = preg_replace($pattern, '', $phoneNumber1);
echo $phoneNumber1."--".$out.$br;
$out = preg_replace($pattern, '', $phoneNumber2);
echo $phoneNumber2."--".$out.$br;
$out = preg_replace($pattern, '', $phoneNumber3);
echo $phoneNumber3."--".$out.$br;
