<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_group")
 */
class UserGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="group")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",
     * nullable=false, onDelete="CASCADE")
     */
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="user")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id",
     * nullable=false, onDelete="CASCADE")
     */
    protected $groups;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $added_on;

    public function __construct()
    {
        try {
            $this->added_on = new \DateTime('now');
        } catch (\Exception $e) {
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddedOn(): ?\DateTimeInterface
    {
        return $this->added_on;
    }

    public function setAddedOn(\DateTimeInterface $added_on): self
    {
        $this->added_on = $added_on;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getGroups(): ?Group
    {
        return $this->groups;
    }

    public function setGroups(?Group $groups): self
    {
        $this->groups = $groups;

        return $this;
    }
}
