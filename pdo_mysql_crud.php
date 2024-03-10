<?php

declare(strict_types=1);

class MySQLConnection
{

    private PDO|null $connection;
    protected $tablename;
    public function __construct(string|null $dsn = null, string|null $user = "root", string|null $password = null, array|null $options = [])
    {
        try {
            //code...
            $dsn = "mysql:host=localhost;dbname=test;port=3306;charset=utf8mb4";
            $this->connection = new PDO($dsn, $user, $password, array_merge([
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => false,
            ], $options));
        } catch (PDOException | Exception $e) {
            die($e->getMessage());
        }
    }

    public function getConnection(): ?PDO
    {
        return $this->connection;
    }


    public function setValue(array $params)
    {
        $setParams = [];
        foreach ($params as $paramKey => $paramValue) {
            $setParams[] = "$paramKey = ?";
        }
        return implode(", ", $setParams);
    }

    public function create(array $params): ?bool
    {
        try {
            $keys = implode(", ", array_keys($params));
            $values = array_values($params);
            $values_placeholder = implode(", ", array_fill(0, count($values), "?"));
            $stmt = $this->getConnection()->prepare("INSERT INTO $this->tablename($keys) VALUES($values_placeholder)");
            return $stmt->execute($values);
        } catch (PDOException | Exception $e) {
            die($e->getMessage());
        }
    }

    public function read()
    {
        try {
            $query = "SELECT * FROM $this->tablename";
            $data = $this->getConnection()->query($query);
            return ['count' => $data->rowCount(), "rows" => $data->fetchAll(PDO::FETCH_ASSOC)];
        } catch (PDOException | Exception $e) {
            die($e->getMessage());
        }
    }

    public function update(array $filter, array $params): ?bool
    {
        try {
            $filterParamsStr = $this->setValue($filter);
            $setParamsStr = $this->setValue($params);
            $values = array_merge(array_values($params), array_values($filter));
            $query = "UPDATE $this->tablename SET $setParamsStr WHERE $filterParamsStr";
            $stmt = $this->getConnection()->prepare($query);
            return $stmt->execute($values);
        } catch (PDOException | Exception $e) {
            die($e->getMessage());
        }
    }

    public function destroy(array $filter): ?bool
    {
        $filterParamsStr = $this->setValue($filter);
        try {
            $query = "DELETE FROM $this->tablename WHERE $filterParamsStr";
            $stmt = $this->getConnection()->prepare($query);
            return $stmt->execute(array_values($filter));
        } catch (PDOException | Exception $e) {
            die($e->getMessage());
        }
    }

    public function table(string $table)
    {
        $this->tablename = $table;
        return $this;
    }

    public function __destruct()
    {
        $this->connection = null;
    }

}

// Operations 

// Model
$conn = new MySQLConnection();
$conn->table("tbl_users");
// $conn->create(["username" => "roald", "password" => password_hash("roald", PASSWORD_BCRYPT), "account_type" => "admin"]); //! Create an item
// $conn->update(["username" => "roald"], ["account_type" => "User"]); //! Modify an existing item
// $conn->destroy(["id" => 2]); //! Removes an item
$users = $conn->read(); //! Retrieves all items
print_r($users);