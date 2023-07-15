<?php

namespace App\Model\Entity;

class FreeBorrowDemands
{
    public string $id; //game_id
    public string $name;
    public string $slug;
    public string $description;
    public string $image;
    public Category $category;
    public string $nb_copies;
    public string $demandState;
}
