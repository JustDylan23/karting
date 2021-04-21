<?php

namespace App\Entity;

use App\Entity\Interfaces\MaxCountInterface;
use App\Repository\ActivityRepository;
use App\Validator\MaxCount;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity implements MaxCountInterface
{
    /**
     * @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank(message="vul een datum in")
     */
    private $datetime;

    /**
     * @ORM\ManyToOne(targetEntity=ActivityType::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank
     */
    private $activityType;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="activities")
     *
     * @MaxCount
     */
    private $users;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxRegistrations;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

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

    public function getTotalUsers(): int
    {
        return $this->getUsers()->count();
    }

    public function __toString(): string
    {
        return $this->activityType . ' - ' . ($this->datetime === null ? 'no date set' : $this->datetime->format('Y-m-d H:i:s'));
    }

    public function getMaxRegistrations(): ?int
    {
        return $this->maxRegistrations;
    }

    public function setMaxRegistrations(int $maxRegistrations): self
    {
        $this->maxRegistrations = $maxRegistrations;

        return $this;
    }

    public function getMaxCount(): int
    {
        return $this->getMaxRegistrations();
    }
}

