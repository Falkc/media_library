<?php

namespace App\Model\Entity;

class Game
{
	public string $id;
	public string $name;
	public string $slug;
	public string $description;
	public string $image;
	public Category $category;
	public string $nb_copies;
}
