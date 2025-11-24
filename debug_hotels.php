<?php
require 'db.php';

echo "<h2>Hotels in Database:</h2>";
$hotels = $pdo->query("
    SELECT h.id, h.name, h.place_id, p.name as place_name 
    FROM hotels h 
    JOIN places p ON h.place_id = p.id 
    ORDER BY h.place_id, h.id
")->fetchAll();

foreach ($hotels as $hotel) {
    echo "ID: {$hotel['id']} | Hotel: {$hotel['name']} | Place: {$hotel['place_name']} (Place ID: {$hotel['place_id']})<br>";
}

echo "<h2>Places in Database:</h2>";
$places = $pdo->query("SELECT id, name FROM places ORDER BY id")->fetchAll();
foreach ($places as $place) {
    echo "ID: {$place['id']} | Place: {$place['name']}<br>";
}
?>