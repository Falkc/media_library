<?php

namespace App\Controller;

use App\Model\UserRepository;
use App\Lib\DatabaseConnection;
use App\Model\InformationRepository;

class UserController
{
    public function register()
    {
        if ($_SESSION['admin'] == 1) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $userRepository = new UserRepository();
                $database = new DatabaseConnection();
                $userRepository->connection = $database;
                $informationRepository = new InformationRepository();
                $informationRepository->connection = $database;

                $phase = $informationRepository->getPhase();
                if (
                    empty($_POST['last_name']) || empty($_POST['first_name']) || empty($_POST['email']) ||
                    empty($_POST['password']) || empty($_POST['password_verification'])
                ) {

                    $errorMsg = "Veuillez remplir tout les champs";
                } else {

                    $errorMsg = $this->checkRegistrationInfo($_POST['last_name'], $_POST['first_name'], $_POST['email']);

                    if (!empty($errorMsg)) {;
                    } else {

                        if (!$userRepository->checkRegistrationEmail($_POST['email'])) {

                            $errorMsg = "E-mail déjà utilisé";
                        } else {

                            if ($_POST['password'] != $_POST['password_verification']) {

                                $errorMsg = "Les mots de passes ne correspondent pas";
                            } else {

                                $userRepository->registerAndLogin(
                                    $_POST['last_name'],
                                    $_POST['first_name'],
                                    $_POST['email'],
                                    $_POST['password']
                                );
                            }
                        }
                        // $errorMsg = $userRepository->checkRegistration(
                        //     $_POST['last_name'],$_POST['first_name'],$_POST['email'],$_POST['password'],$_POST['password_verification']
                        // );
                    }
                }
                if (empty($errorMsg)) {
                    header("Location:" . SITE);
                }
            }

            require('View/register.php');
        } else {
            header('Location:' . SITE);
        }
    }

    public function login()
    {
        $userRepository = new UserRepository();
        $database = new DatabaseConnection();
        $informationRepository = new InformationRepository();
        $userRepository->connection = $database;
        $informationRepository->connection = $database;

        $phase = $informationRepository->getPhase();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (empty($_POST['email']) || empty($_POST['password'])) {
                $errorMsg = "Veuillez remplir tout les champs";
            } else {
                $errorMsg = $userRepository->checkLogin($_POST['email'], $_POST['password']);
            }
            if (empty($errorMsg)) {
                header("Location:" . SITE);
            }
        }

        require('View/login.php');
    }

    public function logout()
    {
        $database = new DatabaseConnection();
        $informationRepository = new InformationRepository();
        $informationRepository->connection = $database;

        $phase = $informationRepository->getPhase();

        session_unset();
        session_destroy();
        header("Location:" . SITE);
    }

    private function checkRegistrationInfo(string $last_name, string $first_name, string $email)
    {
        if (strlen($last_name) > 255) return "Votre nom de famille est trop long";
        if (strlen($first_name) > 255) return "Votre prénom est trop long";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Votre e-mail n'est pas valide";
        if (strlen($email) > 255) return "Votre e-mail est trop long";
        return "";
    }
}
