<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
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
        $this->createUsers($manager, 10, 'main', 'spacebar%d@example.com');
        $this->createUsers($manager, 3, 'admin', 'admin%d@thespacebar.com', true);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param int $count
     * @param string $type
     * @param string $emailFormat
     * @param bool $admin
     */
    protected function createUsers($manager, $count, $type, $emailFormat, $admin = false)
    {
        $this->createMany(
            $count,
            $type . '_users',
            function ($i) use ($manager, $emailFormat, $admin) {
                $user = (new User())->setEmail(sprintf($emailFormat, $i))
                    ->setFirstName($this->faker->firstName);

                if ($admin) {
                    $user->setRoles(['ROLE_ADMIN']);
                }

                if ($this->faker->boolean) {
                    $user->setTwitterUsername($this->faker->userName);
                }

                $user->setPassword($this->passwordEncoder->encodePassword($user, 'engage'));

                $apiToken1 = new ApiToken($user);
                $apiToken2 = new ApiToken($user);
                $manager->persist($apiToken1);
                $manager->persist($apiToken2);

                return $user;
            }
        );
    }
}
