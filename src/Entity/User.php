<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @Assert\Length(max=30)
     */
    public $plainPassword;

    /**
     * @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     *
     * @Assert\NotBlank(message="vul gebruikersnaam in")
     * @Assert\Length(max="25")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=false)
     *
     * @Assert\Email(message = "The email '{{ value }}' is geen geldig email adres")
     * @Assert\NotBlank(message="vul emailadres in")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @Assert\NotBlank(message="vul voorletters in")
     * @Assert\Length(max="10")
     */
    private $initials;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     *
     * @Assert\Length(max="10")
     */
    private $insertion;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(message="vul achternaam in")
     *
     * @Assert\Length(max="25")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=25)
     *
     * @Assert\NotBlank(message="vul adres in")
     * @Assert\Length(max="25")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=7)
     *
     * @Assert\NotBlank(message="vul postcode in")
     * @Assert\Length(max="7")
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=20)
     *
     * @Assert\NotBlank(message="vul woonplaats in")
     * @Assert\Length(max="20")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=15)
     *
     * @Assert\NotBlank(message="vul telfoonnummer in")
     * @Assert\Length(max="15")
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToMany(targetEntity=Activity::class, inversedBy="users")
     */
    private $activities;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->initials . ' ' . $this->insertion . ' ' . $this->lastName;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials(): void
    {
//        $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
//        $roles = $this->roles;
//        $roles[] = 'ROLE_USER';
//
//        return array_unique($roles);

        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getInitials(): ?string
    {
        return $this->initials;
    }

    public function setInitials(string $initials): self
    {
        $this->initials = $initials;

        return $this;
    }

    public function getInsertion(): ?string
    {
        return $this->insertion;
    }

    public function setInsertion(?string $insertion): self
    {
        $this->insertion = $insertion;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        $this->activities->removeElement($activity);

        return $this;
    }

    public function __toString(): string
    {
        return (string)$this->getUsername();
    }
}
