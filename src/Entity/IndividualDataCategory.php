<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\IndividualDataCategoryRepository;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=IndividualDataCategoryRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"read:dataCategory"}},
 *      denormalizationContext={"groups"={"write:dataCategory"}},
 *      itemOperations={
 *          "GET"
 *      }
 * )
 * @ApiFilter(SearchFilter::class, properties={"code": "exact"})
 */
class IndividualDataCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:dataCategory"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:dataCategory"})
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:data", "read:dataCategory"})
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=ProfilModelData::class, mappedBy="individualDataCategory")
     * @Groups({"read:dataCategory"})
     */
    private $ProfilModelData;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="category")
     * @Groups({"read:dataCategory"})
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity=IndividualData::class, mappedBy="category")
     */
    private $individualData;

    public function __construct()
    {
        $this->ProfilModelData = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->individualData = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|ProfilModelData[]
     */
    public function getProfilModelData(): Collection
    {
        return $this->ProfilModelData;
    }

    public function addProfilModelData(ProfilModelData $profilModelData): self
    {
        if (!$this->ProfilModelData->contains($profilModelData)) {
            $this->ProfilModelData[] = $profilModelData;
            $profilModelData->setIndividualDataCategory($this);
        }

        return $this;
    }

    public function removeProfilModelData(ProfilModelData $profilModelData): self
    {
        if ($this->ProfilModelData->removeElement($profilModelData)) {
            // set the owning side to null (unless already changed)
            if ($profilModelData->getIndividualDataCategory() === $this) {
                $profilModelData->setIndividualDataCategory(null);
            }
        }

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
            $document->setCategory($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getCategory() === $this) {
                $document->setCategory(null);
            }
        }

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
            $individualData->setCategory($this);
        }

        return $this;
    }

    public function removeIndividualData(IndividualData $individualData): self
    {
        if ($this->individualData->removeElement($individualData)) {
            // set the owning side to null (unless already changed)
            if ($individualData->getCategory() === $this) {
                $individualData->setCategory(null);
            }
        }

        return $this;
    }
}
