<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $encoder;

    private $manager;

    public function __construct(RegistryInterface $registry, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {
        parent::__construct($registry, User::class);
        $this->encoder = $encoder;
        $this->manager = $manager;
    }

    public function createUser(array $inputs): User
    {
        $user = new User();
        $user->setUsername(strtolower($inputs['username']));
        $password = $this->encoder->encodePassword($user, $inputs['password']);
        $user->setPassword($password);

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}
