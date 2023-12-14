<?php
session_start();

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // perform server-side validation on the email and password
  if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(array('message' => 'Email and password fields are required'));
    return;
  }

  // create a PDO instance for MySQL database connection
  $dsn = 'mysql:host=localhost;dbname=mydatabase';
  $username = 'myusername';
  $password = 'mypassword';
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
  );
  $pdo = new PDO($dsn, $username, $password, $options);

  // prepare the SQL statement to retrieve the user's data from MySQL
  $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = :email');
  $stmt->execute(array('email' => $email));
  $user = $stmt->fetch();

  // check if the user with the given email exists and the password is correct
  if (!$user || !password_verify($password, $user['password_hash'])) {
    http_response_code(401);
    echo json_encode(array('message' => 'Invalid email or password'));
    return;
  }

  // create a Redis instance for session storage
  $redis = new Redis();
  $redis->connect('localhost', 6379);

  // generate a unique session ID and store it in Redis
  $sessionId = uniqid();
  $redis->setex('session:' . $sessionId, 3600, $user['id']);

  // return the session ID to the client
  echo json_encode(array('sessionId' => $sessionId));
}
// Insert user data into the database
$insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($insert_query);
$stmt->execute([$username, $email, $password]);

// Redirect the user to the login page
header("Location: signup.php");
exit();

