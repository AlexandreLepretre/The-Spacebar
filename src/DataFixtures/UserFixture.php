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
        $this->createUsers(10, 'main', 'spacebar%d@example.com');
        $this->createUsers(3, 'admin', 'admin%d@thespacebar.com', true);

        $manager->flush();
    }

    /**
     * @param int $count
     * @param string $type
     * @param string $emailFormat
     * @param bool $admin
     */
    protected function createUsers($count, $type, $emailFormat, $admin = false)
    {
        $this->createMany(
            $count,
            $type . '_users',
            function ($i) use ($emailFormat, $admin) {
                $user = (new User())->setEmail(sprintf($emailFormat, $i))
                    ->setFirstName($this->faker->firstName);

                if ($admin) {
                    $user->setRoles(['ROLE_ADMIN']);
                }

                if ($this->faker->boolean) {
                    $user->setTwitterUsername($this->faker->userName);
                }

                $user->setPassword($this->passwordEncoder->encodePassword($user, 'engage'));
                return $user;
            }
        );
    }
}
