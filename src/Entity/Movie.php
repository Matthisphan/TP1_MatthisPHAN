<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: Movie::class)]
class Movie extends Media
{

}
