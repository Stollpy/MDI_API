<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Services\UploadFilesHelper;
use App\Repository\DocumentRepository;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 */
class Document
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Individual::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $individual;

    /**
     * @ORM\ManyToOne(targetEntity=IndividualDataCategory::class, inversedBy="documents")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mime_type;

    /**
     * @ORM\ManyToOne(targetEntity=Profiles::class, inversedBy="documents")
     */
    private $profile;

    /**
     * @ORM\ManyToOne(targetEntity=Income::class, inversedBy="document")
     */
    private $income;

    /**
     * @ORM\ManyToOne(targetEntity=IncomeYear::class, inversedBy="document")
     */
    private $incomeYear;

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

    public function getCategory(): ?IndividualDataCategory
    {
        return $this->category;
    }

    public function setCategory(?IndividualDataCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
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

    public function getMimeType(): ?string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mime_type): self
    {
        $this->mime_type = $mime_type;

        return $this;
    }

    public function getFilePath(): string
    {
    return UploadFilesHelper::UPLOAD_REFERENCE_PRIVATE. '/' . $this->data;
    }

    public function getProfile(): ?Profiles
    {
        return $this->profile;
    }

    public function setProfile(?Profiles $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getIncome(): ?Income
    {
        return $this->income;
    }

    public function setIncome(?Income $income): self
    {
        $this->income = $income;

        return $this;
    }

    public function getIncomeYear(): ?IncomeYear
    {
        return $this->incomeYear;
    }

    public function setIncomeYear(?IncomeYear $incomeYear): self
    {
        $this->incomeYear = $incomeYear;

        return $this;
    }

}
