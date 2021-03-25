<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\IndividualDataRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=IndividualDataRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"read:data"}},
 *      denormalizationContext={"groups"={"write:data"}},
 *      collectionOperations={
 *          "GET",
 *      },
 *      itemOperations={
 *          "GET",
 *          "PATCH",
 *      }
 * )
 * @ApiFilter(SearchFilter::class, properties={"individual": "exact", })
 */
class IndividualData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:data", "individual:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Individual::class, inversedBy="individualData")
     * @Groups({"read:ads", "read:data"})
     */
    private $individual;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"write:data", "read:data", "individual:read"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity=ProfilModelData::class, inversedBy="IndividualData")
     * @Groups({"read:data", "individual:read"})
     */
    private $profilModelData;

    /**
     * @ORM\ManyToOne(targetEntity=IndividualDataCategory::class, inversedBy="individualData")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIndividual(): ?Individual
    {
        return $this->individual;
    }

    public function setIndividual(?Individual $individual): self
    {
        $this->individual = $individual;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getProfilModelData(): ?ProfilModelData
    {
        return $this->profilModelData;
    }

    public function setProfilModelData(?ProfilModelData $profilModelData): self
    {
        $this->profilModelData = $profilModelData;

        return $this;
    }

    public function getCategory(): ?IndividualDataCategory
    {
        return $this->category;
    }

    public function setCategory(?IndividualDataCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
