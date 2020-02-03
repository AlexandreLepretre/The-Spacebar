<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApiTokenRepository")
 * Class ApiToken
 * @package App\Entity
 */
class ApiToken
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @var int
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $token;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTimeInterface
     */
    private DateTimeInterface $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="apiTokens")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private User $user;

    /**
     * ApiToken constructor.
     * @param User $user
     * @throws Exception
     */
    public function __construct(User $user)
    {
        $this->token = bin2hex(random_bytes(60));
        $this->user = $user;
        $this->expiresAt = new DateTime('+1 hour');
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getExpiresAt(): ?DateTimeInterface
    {
        return $this->expiresAt;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}
