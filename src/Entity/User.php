<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Email existant")
 * @ApiResource(
 *      normalizationContext={"groups"={"user:read"}},
 *      denormalizationContext={"groups"={"user:write"}},
 *      collectionOperations={
 *          "GET",
 *          "POST",
 *      },
 *      itemOperations={
 *          "GET",
 *          "PATCH",
 *          "DELETE"
 *      },
 * )
 */
class User implements UserInterface
{

    public function __construct()
    {
        $this->createdAt = new DateTime('now', new \DateTimeZone('Europe/Paris'));
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read", "user:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Groups({"user:read", "user:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read", "user:write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user:read", "user:write"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $token_account;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user:read", "user:write"})
     */
    private $account_confirmation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $password_token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $password_requestedAt;

    /**
     * @ORM\OneToOne(targetEntity=Individual::class, mappedBy="user", cascade={"persist", "remove"})
     * @Groups({"user:read", "user:write"})
     */
    private $individual;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTokenAccount(): ?string
    {
        return $this->token_account;
    }

    public function setTokenAccount(?string $token_account): self
    {
        $this->token_account = $token_account;

        return $this;
    }

    public function getAccountConfirmation(): ?bool
    {
        return $this->account_confirmation;
    }

    public function setAccountConfirmation(bool $account_confirmation): self
    {
        $this->account_confirmation = $account_confirmation;

        return $this;
    }

    public function getPasswordToken(): ?string
    {
        return $this->password_token;
    }

    public function setPasswordToken(?string $password_token): self
    {
        $this->password_token = $password_token;

        return $this;
    }

    public function getPasswordRequestedAt(): ?\DateTimeInterface
    {
        return $this->password_requestedAt;
    }

    public function setPasswordRequestedAt(?\DateTimeInterface $password_requestedAt): self
    {
        $this->password_requestedAt = $password_requestedAt;

        return $this;
    }

    public function getIndividual(): ?Individual
    {
        return $this->individual;
    }

    public function setIndividual(Individual $individual): self
    {
        // set the owning side of the relation if necessary
        if ($individual->getUser() !== $this) {
            $individual->setUser($this);
        }

        $this->individual = $individual;

        return $this;
    }
}
