<?php

// configuration
$dbhost = 'localhost';
$dbname = 'usagi_RPG';

// Connect to 'localhost' and select 'usagiRPG' DATABASE
$connect = new MongoClient("mongodb://$dbhost");
$database = $connect->$dbname;

?>