<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use Faker;
use App\Entity\Category;
use App\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)

    {
$faker= Faker\Factory::create('fr_FR');

// creer 3 category fakes
        for($i=1; $i<=3;$i++) {
            $category = new Category();
            $category->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());
            $manager->persist($category);

            // créer 4 et 6 articles

$content= '<p>'.join($faker->paragraphs(5),'</p><p>'). '</p>';


            for($J=1; $J<= mt_rand(4,6);$J++){
                $article = new Article();
                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);
                $manager->persist($article);
                //créer plusieurs commentaires

             $content= '<p>'.join($faker->paragraphs(2),'<p></p>').'</p>';
             $date2= new \DateTime();
                $date1=($article->getCreatedAt());
                $interval= $date2->diff($date1);
                $days= $interval->format('days');
                $minimum= '-'.$days.'days'; // -100 days



           for($k=1; $k<= mt_rand(6,10);$k++){
               $comment= new Comment();
               $comment->setAuthor($faker->name)
                   ->setContent($content)
                   ->setCreatedAt($faker->dateTimeBetween($minimum))
                   ->setArticle($article);
               $manager->persist($comment);


           }

        }

    }
        $manager->flush();
    }
}

