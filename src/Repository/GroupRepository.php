<?php

namespace App\Repository;

use App\Entity\Group;
use App\Entity\UserGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(RegistryInterface $registry, ObjectManager $manager)
    {
        parent::__construct($registry, Group::class);

        $this->manager = $manager;
    }

    public function findByName(string $name)
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function create(array $inputs): Group
    {
        $group = new Group();
        $group->setName($inputs['name']);
        $group->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));

        $this->manager->persist($group);
        $this->manager->flush();

        return $group;
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function delete(Group $group): bool
    {
        $this->manager->remove($group);
        $this->manager->flush();

        return true;
    }

    public function getUsersCountByGroupId(int $group_id): bool
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('count(user_group.id)');
        $qb->where('user_group.groups = :group_id');
        $qb->from(UserGroup::class, 'user_group');
        $qb->setParameter('group_id', $group_id);
        $count = (int) $qb->getQuery()->getSingleScalarResult();

        return $count === 0;
    }
}
