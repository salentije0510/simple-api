<?php

if (getenv('SEED_DATABASE') !== 'true') {
    return;
}

$connection = new \Frontify\ColorApi\DbConnection();
$connection->getConnection()->query("INSERT INTO colors(id, name, hex) VALUES (1, 'blue', '#0000ff')");
$connection->getConnection()->query("INSERT INTO colors(id, name, hex) VALUES (2, 'red', '#ff0000')");
$connection->getConnection()->query("INSERT INTO colors(id, name, hex) VALUES (3, 'yellow', '#ffff00')");

$id = 1;
$username = getenv('DATABASE_DEFAULT_USER');
$password = password_hash(getenv('DATABASE_DEFAULT_USER_PASSWORD'), PASSWORD_DEFAULT);

$query = $connection
    ->getConnection()
    ->prepare('INSERT INTO users(id, username, token) VALUES (:userId, :username, :password)');
$query->bindParam('userId', $id, PDO::PARAM_INT);
$query->bindParam('username', $username);
$query->bindParam('password', $password);

$query->execute();
