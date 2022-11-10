<?php

namespace App\Entity;

use App\Repository\AdvertisementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdvertisementRepository::class)
 */
class Advertisement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contract;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domain;

    /**
     * @ORM\Column(type="text")
     */
    private $post;

    /**
     * @ORM\Column(type="date")
     */
    private $createdDate;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="advertisement")
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity=UserAdvertisement::class, mappedBy="advertisement", cascade={"remove"})
     */
    private $advertisementUser;

    /**
     * @ORM\OneToMany(targetEntity=NotUserApply::class, mappedBy="advertisement")
     */
    private $notUserApply;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    public function __construct()
    {
        $this->advertisementUser = new ArrayCollection();
        $this->notUserApply = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(string $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, UserAdvertisement>
     */
    public function getAdvertisementUser(): Collection
    {
        return $this->advertisementUser;
    }

    public function addAdvertisementUser(UserAdvertisement $advertisementUser): self
    {
        if (!$this->advertisementUser->contains($advertisementUser)) {
            $this->advertisementUser[] = $advertisementUser;
            $advertisementUser->setAdvertisement($this);
        }

        return $this;
    }

    public function removeAdvertisementUser(UserAdvertisement $advertisementUser): self
    {
        if ($this->advertisementUser->removeElement($advertisementUser)) {
            // set the owning side to null (unless already changed)
            if ($advertisementUser->getAdvertisement() === $this) {
                $advertisementUser->setAdvertisement(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return Collection<int, NotUserApply>
     */
    public function getNotUserApply(): Collection
    {
        return $this->notUserApply;
    }

    public function addNotUserApply(NotUserApply $notUserApply): self
    {
        if (!$this->notUserApply->contains($notUserApply)) {
            $this->notUserApply[] = $notUserApply;
            $notUserApply->setAdvertisement($this);
        }

        return $this;
    }

    public function removeNotUserApply(NotUserApply $notUserApply): self
    {
        if ($this->notUserApply->removeElement($notUserApply)) {
            // set the owning side to null (unless already changed)
            if ($notUserApply->getAdvertisement() === $this) {
                $notUserApply->setAdvertisement(null);
            }
        }

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
}
