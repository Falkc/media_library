<?php

namespace App\Entity;

class Game
{
	public string $id;
	public string $name;
	public string $description;
	public string $image;
	public string $nb_copies;
	public \DateTime $release_date;
}
