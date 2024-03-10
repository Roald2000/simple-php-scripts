<?php



$conn = new mysqli("localhost", "root", null, "test", 3306);

$params = ["username" => "user", "password" => "userpass", "account_type" => "user"];
$keys = implode(", ", array_keys($params));
// $values_p = implode(", ", array_fill(0, count(array_values($params)), "?"));
$values = implode(",", array_values($params));

// $conn->query("INSERT INTO tbl_users($keys) VALUES($values)");

$users = $conn->query("SELECT * FROM tbl_users")->fetch_all(MYSQLI_ASSOC);
print_r($users);
// $result = "";
// foreach ($users as $user) {
//     $result .= $user . "\n";
// }
// echo $result;


// $conn->prepare($stmt)->execute();

$conn->close();