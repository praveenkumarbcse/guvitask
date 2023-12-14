// Connect to the MongoDB server
$mongo = new MongoDB\Client("mongodb://localhost:27017");

// Select the database
$db = $mongo->mydatabase;

// Select the collection
$collection = $db->users;

// Insert a new document into the collection
$insertResult = $collection->insertOne([
    'username' => 'johndoe',
    'email' => 'johndoe@example.com',
    'password' => '$2y$10$hB4Pp5E6S8C67xD5U6l5UOzNRgIKcb0mkgdQZ9X08ZrkldmckrO8i' // hashed password
]);

// Update a document in the collection
$updateResult = $collection->updateOne(
    ['username' => 'johndoe'],
    ['$set' => ['email' => 'johndoe@gmail.com']]
);

// Delete a document from the collection
$deleteResult = $collection->deleteOne(['username' => 'johndoe']);

// Find documents in the collection
$cursor = $collection->find(['username' => 'johndoe']);
foreach ($cursor as $document) {
    var_dump($document);
}
