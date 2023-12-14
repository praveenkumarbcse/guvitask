<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // retrieve the session ID from the request headers
  $sessionId = $_SERVER['HTTP_SESSION_ID'];

  // check if the session ID is valid
  if (empty($sessionId)) {
    http_response_code(401);
    echo json_encode(array('message' => 'Session ID is missing'));
    return;
  }

  // create a Redis instance for session storage
  $redis = new Redis();
  $redis->connect('localhost', 6379);

  // retrieve the user ID from Redis using the session ID
  $userId = $redis->get('session:' . $sessionId);

  // check if the user ID is valid
  if (empty($userId)) {
    http_response_code(401);
    echo json_encode(array('message' => 'Invalid session ID'));
    return;
  }

  // retrieve the profile data from the request body
  $name = $_POST['name'];
  $age = $_POST['age'];
  $dob = $_POST['dob'];
  $contact = $_POST['contact'];

  // perform server-side validation on the profile data
  if (empty($name) || empty($age) || empty($dob) || empty($contact)) {
    http_response_code(400);
    echo json_encode(array('message' => 'All fields are required'));
    return;
  }

  // create a MongoDB instance and select the users collection
  $mongo = new MongoDB\Client('mongodb://localhost:27017');
  $collection = $mongo->mydatabase->users;

  // update the user's profile in MongoDB
  $collection->updateOne(
    array('_id' => new MongoDB\BSON\ObjectID($userId)),
    array('$set' => array(
      'name' => $name,
      'age' => $age,
      'dob' => $dob,
      'contact' => $contact
    ))
  );

  // return a success message to the client
  echo json_encode(array('message' => 'Profile updated successfully'));
}
