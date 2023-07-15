<?php

namespace App\Model\Entity;

use App\Model\Entity\FreeBorrowDemands;

class FreeBorrowDemandsAndUserName
{
    public string $first_name;
    public string $last_name;
    public string $user_id;
    public array $fbd_array; // fbd= freeBorrowDemands
}
