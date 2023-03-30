<?php
namespace App\Model\Entity;

class User{
    public string $id;
    public string $email;
	public string $password;
	public string $first_name;
	public string $last_name;
	public \DateTime $registration_date;
    public string $admin;
}