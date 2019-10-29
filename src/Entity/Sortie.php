<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @Assert\NotBlank(message="Veuillez entrer un nom pour la sortie")
     * @Assert\Length(
     *     min="5",
     *     max="150",
     *     minMessage="{{ limit }} caractères minimum !",
     *     maxMessage="{{ limit }} caractères maximum !"
     * )
     * @Assert\Regex(
     *     pattern="/([0-9_-]*[a-zA-Z][0-9_-]*){3}/",
     *     message="3 lettres minimum" )
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
     * @Assert\GreaterThanOrEqual("today", message="On ne peut pas clôturer les inscriptions avant la date du jour")
     * @Assert\LessThanOrEqual(propertyPath="dateDebut", message="Les inscriptions doivent se clôturer avant le début de la sortie")
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
     * @Assert\NotBlank(message="Veuillez préciser une description")
     * @Assert\Length(
     *     min="10",
     *     minMessage="{{ limit }} caractères minimum !"
     * )
     * @Assert\Regex(
     *     pattern="/([0-9_-]*[a-zA-Z][0-9_-]*){4}/",
     *     message="4 lettres minimum" )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(
     *     maxSize="1000K",
     *     maxSizeMessage="La taille du fichier dépasse la limite de 1000Ko",
     *     mimeTypes={"image/png","image/jpeg","image/jpg","image/svg+xml","image/gif"},
     *     mimeTypesMessage="Le format du fichier séléctionné n'est pas autorisé. Les formats autorisés sont: png, jpeg, jpg, svg, gif"
     * )
     */
    private $urlPhoto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="sorties")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="TEST")
     */
    private $lieu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="sorties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * Sortie constructor.
     * @param $users
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


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

    public function getOrganisateur(): ?User
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?User $organisateur): self
    {
        $this->organisateur = $organisateur;

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
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

}
