<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixture
 * @package App\DataFixtures
 */
class UserFixture extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserFixture constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(
            10,
            'main_users',
            function ($i) {
                $user = (new User())->setEmail(sprintf('spacebar%d@example.com', $i))
                    ->setFirstName($this->faker->firstName);
                $user->setPassword($this->passwordEncoder->encodePassword($user, 'engage'));
                return $user;
            }
        );

        $manager->flush();
    }
}
