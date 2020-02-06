<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ArticleVoter
 * @package App\Security\Voter
 */
class ArticleVoter extends Voter
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * ArticleVoter constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param string $attribute
     * @param object $subject
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        return $attribute == 'MANAGE' && $subject instanceof Article;
    }

    /**
     * @param string $attribute
     * @param Article $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        return $subject->getAuthor() == $user || $this->security->isGranted('ROLE_ADMIN_ARTICLE');
    }
}
