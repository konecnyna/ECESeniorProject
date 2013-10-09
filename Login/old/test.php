<?php

echo "boobs\n";


$db = new SQLite3('/home/pi/all/homework/ece331/proj2/temperature.db');
$numresults = $db->query('SELECT * FROM Temperature');
//echo $numresults->Array();

while ($row = $numresults->fetchArray()) {
    //var_dump($row);
    echo "Time: ". $row['time'] ." || Temp: ".$row['temperature']."</br>";
}



?>
