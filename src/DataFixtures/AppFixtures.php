<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this ->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        
        $adminUser = new User();
        $adminUser -> setFirstName('Maximino')
                ->setLastName('Gutierrez Mantione')
                ->setEmail('emzakh@gmail.be')
                ->setPassword($this -> passwordEncoder->encodePassword($adminUser,'password'))
                ->setRoles(['ROLE_ADMIN']);
        $manager->persist($adminUser);
   

        $manager->persist($adminUser);

       
        for($c=0 ; $c < 10 ; $c++)
        {
            $category = new Category();
            $category->setTitle($faker->word());
            $manager->persist($category);

          
            for($p=0 ; $p < rand(2,8) ; $p++){
                $product = new Product();
                $product->setTitle($faker->sentence(rand(2,5), true))
                    ->setPrice(rand(50,5000)/100)
                    ->setDescription($faker->paragraph(4, true))
                    ->setCategory($category)
                ;
                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}