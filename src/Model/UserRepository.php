<?php

namespace App\Model;

use App\Model\Entity\User;
use App\Lib\DatabaseConnection;

class UserRepository
{
    public DatabaseConnection $connection;

    public function getUsers(): array
    {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM users WHERE admin=0 ORDER BY id ASC"
        );
        $users = [];
        while (($row = $statement->fetch())) {
            $user = new User();
            $user->id = $row['id'];
            $user->email = $row['email'];
            $user->password = $row['password'];
            $user->first_name = $row['first_name'];
            $user->last_name = $row['last_name'];
            $user->registration_date = new \DateTime($row['registration_date']);
            $user->admin = $row['admin'];

            $users[] = $user;
        }
        return $users;
    }

    public function checkLogin(string $email, string $password): string
    {

        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);

        $check = $this->connection->getConnection()->prepare(
            "SELECT * FROM users WHERE email=?"
        );
        $check->execute([$email]);

        if ($check->rowCount() == 0) return "E-mail incorrect";

        $password = hash('sha256', $password); // code le mot de passe
        $row =  $check->fetch();

        if ($password !== $row['password']) return "Mot de passe incorrect";

        $this->logUser($row);

        return "";
    }

    public function checkRegistrationEmail(string $email): bool
    {
        $check = $this->connection->getConnection()->prepare(
            "SELECT * FROM users WHERE email=?"
        );
        $check->execute([$email]);

        if ($check->rowCount() == 1) return false;

        return true;
    }

    public function registerAndLogin(string $last_name, string $first_name, string $email, string $password): void
    {

        $last_name = htmlspecialchars($last_name);
        $first_name = htmlspecialchars($first_name);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);

        $password = hash('sha256', $password);

        $insert = $this->connection->getConnection()->prepare(
            "INSERT INTO users(email, password, first_name, last_name) VALUES(:email, :password, :first_name, :last_name)"
        );
        $insert->execute([
            'email' => $email,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name,
        ]);

        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, registration_date FROM users WHERE email=?"
        );
        $statement->execute([$email]);
        $row = $statement->fetch();

        $this->logUser([
            'id' => $row['id'],
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'registration_date' => $row['registration_date'],
            'admin' => 0
        ]);
    }

    private function logUser(array $data): void
    {
        $_SESSION['id'] = $data['id'];
        $_SESSION['first_name'] = $data['first_name'];
        $_SESSION['last_name'] = $data['last_name'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['registration_date'] = $data['registration_date'];
        $_SESSION['admin'] = $data['admin'];
    }
}
