<?php

include_once("GetTelegramMembersCount.php");

include_once("GetTwitterFollowerCount.php");

//pass chatId of the group / channel here
//it will be the last part in the url i.e. example 
//https://t.me/fresherjobpage

$output = getTelegramMembersCount("MIRUTOKENCHAT");
echo "TELEGRAM COUNT -:" .$output . "\n";


$output = getTwitterFollowers("britneyspears");
echo "TWITTER FOLLOWERS -:" . $output;

?>