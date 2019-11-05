<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CommentFixture
 * @package App\DataFixtures
 */
class CommentFixture extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 100, function(Comment $comment) {
            /** @var Article $article */
            $article = $this->getReference(Article::class . '_0');
            $comment->setContent($this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true))
                ->setAuthorName($this->faker->name)
                ->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'))
                ->setArticle($article);
        });

        $manager->flush();
    }
}
