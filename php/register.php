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

  // hash the password using bcrypt
  $hashed_password = password_hash($password, PASSWORD_BCRYPT);

  // create a PDO instance for MySQL database connection
  $dsn = 'mysql:host=localhost;dbname=mydatabase';
  $username = 'myusername';
  $password = 'mypassword';
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  );
  try {
    $pdo = new PDO($dsn, $username, $password, $options);
  } catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array('message' => 'Failed to connect to database: ' . $e->getMessage()));
    return;
  }

  // prepare the SQL statement for inserting new user into users table
  $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');

  // bind the parameters with values
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $hashed_password);

  // execute the statement to insert the new user
  try {
    $stmt->execute();
  } catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array('message' => 'Failed to insert new user: ' . $e->getMessage()));
    return;
  }

  // return success message to the client
  echo json_encode(array('message' => 'User registered successfully'));
}
?>
// Insert user data into the database
$insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($insert_query);
$stmt->execute([$username, $email, $password]);

// Redirect the user to the login page
header("Location: login.php");
exit();

