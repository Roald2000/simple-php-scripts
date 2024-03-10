<?php

class User
{
    private $id;
    private $name;
    private $email;

    public function __construct($id, $name, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }
}

class CrudOperations
{
    private $users = [];

    public function __construct()
    {
        // Initialize users array
        $this->users[] = new User(1, 'John Doe', 'john@example.com');
        $this->users[] = new User(2, 'Jane Smith', 'jane@example.com');
    }

    // Create operation
    public function createUser($name, $email)
    {
        $newUser = new User(count($this->users) + 1, $name, $email);
        $this->users[] = $newUser;
        return $newUser;
    }

    // Read operation
    public function getUsers()
    {
        return $this->users;
    }

    // Update operation
    public function updateUser($id, $name, $email)
    {
        foreach ($this->users as $index => $user) {
            if ($user->getId() === $id) {
                $this->users[$index] = new User($id, $name, $email);
                return true;
            }
        }

        return false;
    }

    // Delete operation
    public function deleteUser($id)
    {
        foreach ($this->users as $index => $user) {
            if ($user->getId() === $id) {
                unset($this->users[$index]);
                return true;
            }
        }

        return false;
    }
}

$crud = new CrudOperations();

// Create a new user
$newUser = $crud->createUser('Alice', 'alice@example.com');
echo "Created user: " . $newUser->getName() . " (" . $newUser->getEmail() . ")\n";

// Get all users
$users = $crud->getUsers();
echo "All users:\n";
foreach ($users as $user) {
    echo "- ID: " . $user->getId() . ", Name: " . $user->getName() . ", Email: " . $user->getEmail() . "\n";
}

// Update a user
$updated = $crud->updateUser(1, 'John Doe Updated', 'john_updated@example.com');
if ($updated) {
    echo "Updated user with ID 1\n";
} else {
    echo "User with ID 1 not found\n";
}

// Delete a user
$deleted = $crud->deleteUser(2);
if ($deleted) {
    echo "Deleted user with ID 2\n";
} else {
    echo "User with ID 2 not found\n";
}

$users = $crud->getUsers();
echo "All users:\n";
foreach ($users as $user) {
    echo "- ID: " . $user->getId() . ", Name: " . $user->getName() . ", Email: " . $user->getEmail() . "\n";
}