<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Commande;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création d'utilisateurs
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@example.com');
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'password123')); 
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        // Création de produits
        for ($i = 0; $i < 50; $i++) {
            $produit = new Produit();
            $produit->setName('produit' . $i)
                    ->setPrice(mt_rand(0, 100))
                    ->setType('produit' . $i)
                    ->setImage('image ' . $i);
            $manager->persist($produit);
            $this->addReference('produit_' . $i, $produit);
        }

        // Création de paniers
        for ($i = 0; $i < 50; $i++) {
            $panier = new Panier();
            $panier->setNameProduit($faker->word);
            $panier->setQuantity($faker->numberBetween(1, 10));
            $panier->setPricePanier($faker->randomFloat(2, 1, 100));
            $panier->setUser($this->getReference('user_' . $faker->numberBetween(0, 9))); 
            $panier->setProduit($this->getReference('produit_' . $faker->numberBetween(0, 49))); 
            $manager->persist($panier);
            $this->addReference('panier_' . $i, $panier);
        }

        // Création de commandes
        for ($i = 0; $i < 50; $i++) {
            $commande = new Commande();
            $commande->setStatut('CMD' . $i)
                ->setDate($faker->dateTimeThisYear())
                ->setUser($this->getReference('user_' . $faker->numberBetween(0, 9)));

            // Ajoutez des articles à la commande (vous devez avoir des paniers dans la base de données)
            for ($j = 0; $j < $faker->numberBetween(1, 10); $j++) {
                $commande->addPanier($this->getReference('panier_' . $faker->numberBetween(0, 49))); 
            }

            $manager->persist($commande);
        }

        $manager->flush();
    }
}

