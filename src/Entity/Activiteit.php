<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Activiteit
 *
 * @ORM\Table(name="activiteiten")
 * @ORM\Entity(repositoryClass="App\Repository\ActiviteitRepository")
 */
class Activiteit
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     *
     * @Assert\NotBlank(message="vul een datum in")
     */
    private $datum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="time")
     *
     * @Assert\NotBlank(message="vul een tijd in")
     */
    private $tijd;

    /**
     * @ORM\ManyToOne(targetEntity="Soortactiviteit", inversedBy="activiteiten")
     * @ORM\JoinColumn(name="soort_id", referencedColumnName="id")
     *
     * @Assert\NotBlank
     */

    private $soort;

    /**
     * Many Activiteiten have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="activiteiten")
     *
     * @Assert\NotBlank
     */

    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datum
     *
     * @param \DateTime $datum
     *
     * @return Activiteit
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;

        return $this;
    }

    /**
     * Get datum
     *
     * @return \DateTime
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Set tijd
     *
     * @param \DateTime $tijd
     *
     * @return Activiteit
     */
    public function setTijd($tijd)
    {
        $this->tijd = $tijd;

        return $this;
    }

    /**
     * Get tijd
     *
     * @return \DateTime
     */
    public function getTijd()
    {
        return $this->tijd;
    }

    public function getSoort()
    {
        return $this->soort;
    }

    public function setSoort($soort)
    {
        $this->soort = $soort;
    }
}

