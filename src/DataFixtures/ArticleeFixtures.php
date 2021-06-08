<?php

namespace App\DataFixtures;

use App\Entity\Articlee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\ArticleeRepository;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $article = new Articlee();
            $article->setNomArticle("article n° $i");
            $article->setDescArticle("type n°$i");
            $article->setImgArticle("https://medias.go-sport.com/media/resized/1300x/catalog/product/01/43/24/76/railway-19_1_v1.jpg");
            $article->setPrixArticle(50);
            $article->setContactArticle(25896314);
            $article->setLocationArticle("tunis");
            $article->setNbPersonne(2);
            $article->setCreatedAt(new \DateTime('now'));
            $manager->persist($article);
        }
        $manager->flush();
    }
}
