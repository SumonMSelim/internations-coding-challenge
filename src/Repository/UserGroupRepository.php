<?php

namespace App\Repository;

use App\Entity\Group;
use App\Entity\User;
use App\Entity\UserGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroup[]    findAll()
 * @method UserGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(RegistryInterface $registry, ObjectManager $manager)
    {
        parent::__construct($registry, UserGroup::class);

        $this->manager = $manager;
    }

    public function checkIfAssigned(int $user_id, int $group_id)
    {
        return $this->findOneBy(['users' => $user_id, 'groups' => $group_id]);
    }

    public function assign(User $user, Group $group): UserGroup
    {
        $user_group = new UserGroup();
        $user_group->setUsers($user);
        $user_group->setGroups($group);

        $this->manager->persist($user_group);
        $this->manager->flush();

        return $user_group;
    }

    public function remove(UserGroup $user_group): bool
    {
        $this->manager->remove($user_group);
        $this->manager->flush();

        return true;
    }
}
