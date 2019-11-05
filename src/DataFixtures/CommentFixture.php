<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CommentFixture
 * @package App\DataFixtures
 */
class CommentFixture extends BaseFixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 100, function (Comment $comment) {
            /** @var Article $article */
            $article = $this->getRandomReference(Article::class);
            $comment->setContent($this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true))
                ->setAuthorName($this->faker->name)
                ->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'))
                ->setArticle($article);
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     * @return array
     */
    public function getDependencies()
    {
        return [ArticleFixtures::class];
    }
}
