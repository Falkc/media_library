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

    public function register(string $last_name, string $first_name, string $email, string $password, string $admin): bool
    {

        $last_name = htmlspecialchars($last_name);
        $first_name = htmlspecialchars($first_name);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        $admin = htmlspecialchars($admin);

        $insert = $this->connection->getConnection()->prepare(
            "INSERT INTO users(email, password, first_name, last_name, admin) VALUES(:email, :password, :first_name, :last_name, :admin)"
        );
        $insert->execute([
            'email' => $email,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'admin' => $admin,
        ]);

        return true;
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

    public function getAllUsers(): array
    {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM users ORDER BY last_name ASC"
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

    public function getUserById(string $user_id): User
    {

        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM users WHERE id=?"
        );
        $statement->execute([$user_id]);
        $row = $statement->fetch();
        $user = new User();
        $user->id = $row['id'];
        $user->email = $row['email'];
        $user->password = $row['password'];
        $user->first_name = $row['first_name'];
        $user->last_name = $row['last_name'];
        $user->registration_date = new \DateTime($row['registration_date']);
        $user->admin = $row['admin'];
        
        return $user;
    }

    public function modifyUserById(string $id, string $email, string $password, string $first_name, string $last_name, string $admin): bool
    {
        $id = htmlspecialchars($id);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        $first_name = htmlspecialchars($first_name);
        $last_name = htmlspecialchars($last_name);
        $admin = htmlspecialchars($admin);
        $update = $this->connection->getConnection()->prepare(
            "UPDATE users
            SET email = :email, password = :password, first_name = :first_name, last_name = :last_name, admin = :admin
            WHERE id = :id"
        );
        $update->execute([
            'id' => $id,
            'email' => $email,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'admin' => $admin

        ]);

        return true;
    }
}
