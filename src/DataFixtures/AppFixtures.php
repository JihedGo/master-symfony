<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private const USERS = [
        [
            'username' => 'john_doe',
            'email'    => 'john_doe@gmail.com',
            'password' => 'john123',
            'fullName' => 'John Doe',
            'roles' => [User::ROLE_USER]
        ],
        [
            'username' => 'rob_smith',
            'email'    => 'rob_smith@gmail.com',
            'password' => 'rob12345',
            'fullName' => 'Rob Smith',
            'roles' => [User::ROLE_USER]
        ],
        [
            'username' => 'marry_gold',
            'email'    => 'marry_gold@gmail.com',
            'password' => 'marray123',
            'fullName' => 'Marry Gold',
            'roles' => [User::ROLE_USER]
        ],
        [
            'username' => 'super_admin',
            'email'    => 'super_admin@gmail.com',
            'password' => '12345678',
            'fullName' => 'ADMIN ROLE',
            'roles' => [User::ROLE_ADMIN]
        ],
    ];

    private const POSTS = [
        "Hello how are you ?",
        "It's nice sunny weather today",
        "I need to buy some nice icecream",
        "I wanna buy a new car",
        "There is a problem with my phone",
        "I need to go to the doctor",
        "What are you up to today?",
        "Did you watch the game yesterday?",
        "How was your day?"
    ];

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadMicroPosts($manager);
    }

    private function loadMicroPosts(ObjectManager $manager)
    {
        for ($i = 0; $i < 30; $i++) {
            $microPost = new MicroPost();
            $microPost->setText(self::POSTS[rand(0, count(self::POSTS) - 1)]);
            $date = new \DateTime();
            $date->modify('-' . rand(0, 10) . ' day');
            $microPost->setTime($date);
            $user = $this->getReference(self::USERS[rand(0, count(self::USERS) - 1)]['username']);
            $microPost->setUser($user);
            $manager->persist($microPost);
        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userData) {

            $user = new User();
            $user->setUsername($userData['username']);
            $user->setFullname($userData['fullName']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->encoder->encodePassword($user, $userData['password']));
            $this->addReference($userData['username'], $user);
            $user->setRoles($userData['roles']);
            $manager->persist($user);
        }
        $manager->flush();
    }
}