<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
{
    /**
     * @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotBlank(message="vul een datum in")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     *
     * @Assert\NotBlank(message="vul een tijd in")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=ActivityType::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank
     */
    private $activityType;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="activities")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getActivityType(): ?ActivityType
    {
        return $this->activityType;
    }

    public function setActivityType(?ActivityType $activityType): self
    {
        $this->activityType = $activityType;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addActivity($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeActivity($this);
        }

        return $this;
    }
}

