<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SortiesRepository")
 */
class Sortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entre un nom pour la sortie")
     * @Assert\Length(
     *     min="5",
     *     max="150",
     *     minMessage="{{ limit }} caractères minimum !",
     *     maxMessage="{{ limit }} caractères maximum !"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Veuillez entrer une date de sortie")
     * @Assert\DateTime(message="This value is not valid!")
     * @Assert\GreaterThanOrEqual("today", message="On ne peut pas créer une sortie avant la date du jour")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez préciser combien de temps va durer la sortie")
     * @Assert\Range(
     *     min="60",
     *     minMessage="{{ limit }} minutes minimum"
     * )
     */
    private $duree;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Veuillez entrer une date limite pour clôturer les inscriptions")
     * @Assert\GreaterThanOrEqual(propertyPath="dateDebut", message="Les inscriptions doivent se clôturer avant le début de la sortie")
     */
    private $dateCloture;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez préciser un nombre maximum de participants pour la sortie")
     * @Assert\Range(
     *     min="1",
     *     minMessage="{{ limit }} participant minimum")
     */
    private $nbInscriptionsMax;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *     min="10",
     *     minMessage="{{ limit }} caractères minimum !"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlPhoto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="sorties")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="sorties")
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="sorties")
     */
    private $site;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sorties")
     */
    private $organisateur;

    /**
     * @var User[]
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     *
     */
    private $users;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->dateCloture;
    }

    public function setDateCloture(\DateTimeInterface $dateCloture): self
    {
        $this->dateCloture = $dateCloture;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): self
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrlPhoto(): ?string
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto(?string $urlPhoto): self
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param mixed $lieu
     */
    public function setLieu($lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site): void
    {
        $this->site = $site;
    }

    /**
     * @return mixed
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param mixed $organisateur
     */
    public function setOrganisateur($organisateur): void
    {
        $this->organisateur = $organisateur;
    }

    /**
     * @return User[]
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }

    /**
     * @param User[] $participants
     */
    public function setParticipants(array $participants): void
    {
        $this->participants = $participants;
    }

}
