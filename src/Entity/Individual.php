<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\IndividualRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=IndividualRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"individual:read"}},
 *      denormalizationContext={"groups"={"individual:write"}},
 *      collectionOperations={
 *          "GET",
 *          "POST",
 *      },
 *      itemOperations={
 *          "GET",
 *          "PATCH",
 *          "DELETE",
 *      }
 * )
 */
class Individual
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"individual:read", "individual:write"})
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="individual", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"individual:read", "individual:write"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=IndividualData::class, mappedBy="individual")
     * @Groups({"individual:read", "individual:write", "user:read", "user:read"})
     */
    private $individualData;

    /**
     * @ORM\ManyToMany(targetEntity=Individual::class, inversedBy="individuals")
     * @Groups({"individual:read", "individual:write", "user:read"})
     */
    private $garant;

    /**
     * @ORM\ManyToMany(targetEntity=Individual::class, mappedBy="garant")
     * @Groups({"individual:read", "individual:write", "user:read"})
     */
    private $individuals;

    /**
     * @ORM\ManyToMany(targetEntity=Profiles::class, inversedBy="individuals")
     * @Groups({"individual:read", "individual:write", "user:read"})
     */
    private $profiles;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="individual", orphanRemoval=true)
     * @Groups({"individual:read", "individual:write", "user:read"})
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="individual")
     * @Groups({"individual:read", "individual:write", "user:read"})
     */
    private $invitations;

    /**
     * @ORM\OneToMany(targetEntity=Income::class, mappedBy="individual", orphanRemoval=true)
     * @Groups({"individual:read", "individual:write", "user:read"})
     */
    private $incomes;

    /**
     * @ORM\OneToMany(targetEntity=IncomeYear::class, mappedBy="individual")
     * @Groups({"individual:read", "individual:write", "user:read"})
     */
    private $incomeYears;

    /**
     * @ORM\OneToMany(targetEntity=Ads::class, mappedBy="individual")
     * @Groups({"individual:read", "individual:write", "user:read"})
     */
    private $ads;

    public function __construct()
    {
        $this->individualData = new ArrayCollection();
        $this->garant = new ArrayCollection();
        $this->individuals = new ArrayCollection();
        $this->profiles = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->incomes = new ArrayCollection();
        $this->incomeYears = new ArrayCollection();
        $this->ads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|IndividualData[]
     */
    public function getIndividualData(): Collection
    {
        return $this->individualData;
    }

    public function addIndividualData(IndividualData $individualData): self
    {
        if (!$this->individualData->contains($individualData)) {
            $this->individualData[] = $individualData;
            $individualData->setIndividual($this);
        }

        return $this;
    }

    public function removeIndividualData(IndividualData $individualData): self
    {
        if ($this->individualData->removeElement($individualData)) {
            // set the owning side to null (unless already changed)
            if ($individualData->getIndividual() === $this) {
                $individualData->setIndividual(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getGarant(): Collection
    {
        return $this->garant;
    }

    public function addGarant(self $garant): self
    {
        if (!$this->garant->contains($garant)) {
            $this->garant[] = $garant;
        }

        return $this;
    }

    public function removeGarant(self $garant): self
    {
        $this->garant->removeElement($garant);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getIndividuals(): Collection
    {
        return $this->individuals;
    }

    public function addIndividual(self $individual): self
    {
        if (!$this->individuals->contains($individual)) {
            $this->individuals[] = $individual;
            $individual->addGarant($this);
        }

        return $this;
    }

    public function removeIndividual(self $individual): self
    {
        if ($this->individuals->removeElement($individual)) {
            $individual->removeGarant($this);
        }

        return $this;
    }

    /**
     * @return Collection|profiles[]
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function addProfile(profiles $profile): self
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles[] = $profile;
        }

        return $this;
    }

    public function removeProfile(profiles $profile): self
    {
        $this->profiles->removeElement($profile);

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setIndividual($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getIndividual() === $this) {
                $document->setIndividual(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->setIndividual($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getIndividual() === $this) {
                $invitation->setIndividual(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Income[]
     */
    public function getIncomes(): Collection
    {
        return $this->incomes;
    }

    public function addIncome(Income $income): self
    {
        if (!$this->incomes->contains($income)) {
            $this->incomes[] = $income;
            $income->setIndividual($this);
        }

        return $this;
    }

    public function removeIncome(Income $income): self
    {
        if ($this->incomes->removeElement($income)) {
            // set the owning side to null (unless already changed)
            if ($income->getIndividual() === $this) {
                $income->setIndividual(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|IncomeYear[]
     */
    public function getIncomeYears(): Collection
    {
        return $this->incomeYears;
    }

    public function addIncomeYear(IncomeYear $incomeYear): self
    {
        if (!$this->incomeYears->contains($incomeYear)) {
            $this->incomeYears[] = $incomeYear;
            $incomeYear->setIndividual($this);
        }

        return $this;
    }

    public function removeIncomeYear(IncomeYear $incomeYear): self
    {
        if ($this->incomeYears->removeElement($incomeYear)) {
            // set the owning side to null (unless already changed)
            if ($incomeYear->getIndividual() === $this) {
                $incomeYear->setIndividual(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ads[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ads $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setIndividual($this);
        }

        return $this;
    }

    public function removeAd(Ads $ad): self
    {
        if ($this->ads->removeElement($ad)) {
            // set the owning side to null (unless already changed)
            if ($ad->getIndividual() === $this) {
                $ad->setIndividual(null);
            }
        }

        return $this;
    }
}
