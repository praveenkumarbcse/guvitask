<?php
// Connect to MongoDB
$mongo = new MongoClient();
$db = $mongo->selectDB("mydb");

// Retrieve user profile data from MongoDB
$collection = $db->users;
$user = $collection->findOne(array("_id" => new MongoId($_COOKIE["user_id"])));

// Return user profile data as JSON
header("Content-type: application/json");
echo json_encode($user["profile"]);
?>
