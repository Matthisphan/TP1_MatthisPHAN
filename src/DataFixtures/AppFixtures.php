<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    //définis les limites pour la génération des données :
    public const MAX_USERS = 10;
    public const PLAYLISTS_PER_USER = 5;
    public const MAX_SUBSCRIPTIONS = 3;
    public const MAX_MEDIA = 100;
    public const MAX_MEDIA_PER_PLAYLIST = 3;

    //La méthode load() est appelée lorsque les fixtures sont exécutées. Elle utilise un objet ObjectManager pour interagir avec la base de données.
    public function load(ObjectManager $manager): void
    {
        //Initialisation des tableaux vides pour stocker les utilisateurs ($users), les médias ($medias), et les playlists ($playlists).
        $users = [];
        $medias = [];
        $playlists = [];

        for ($i = 0; $i < self::MAX_USERS; $i++) {
            $user = $this->createUser($i, $manager);
            $users[] = $user;

            for ($k = 0; $k < random_int(1, self::PLAYLISTS_PER_USER); $k++) {
                $playlists = $this->createPlaylists($user, $manager, $playlists);
            }
        }

        $this->createMediaAndLinkToPlaylists($manager, $playlists);
        $this->createSubscriptions($manager, $users);

        $manager->flush();
    }
}
