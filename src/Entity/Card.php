<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 */
class Card
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_cards"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"show_cards"})
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show_cards"})
     */
    private $centerCode;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show_cards"})
     */
    private $cardCode;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"show_cards"})
     */
    private $activatedAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show_cards"})
     */
    private $checksum;

    /**
     * @ORM\ManyToOne(targetEntity=CardOrder::class, inversedBy="cards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cardOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCenterCode(): ?int
    {
        return $this->centerCode;
    }

    public function setCenterCode(int $centerCode): self
    {
        $this->centerCode = $centerCode;

        return $this;
    }

    public function getCardCode(): ?int
    {
        return $this->cardCode;
    }

    public function setCardCode(int $cardCode): self
    {
        $this->cardCode = $cardCode;

        return $this;
    }

    public function getActivatedAt(): ?\DateTimeImmutable
    {
        return $this->activatedAt;
    }

    public function setActivatedAt(\DateTimeImmutable $activatedAt): self
    {
        $this->activatedAt = $activatedAt;

        return $this;
    }

    public function getChecksum(): ?int
    {
        return $this->checksum;
    }

    public function setChecksum(int $checksum): self
    {
        $this->checksum = $checksum;

        return $this;
    }

    public function getCardOrder(): ?CardOrder
    {
        return $this->cardOrder;
    }

    public function setCardOrder(?CardOrder $cardOrder): self
    {
        $this->cardOrder = $cardOrder;

        return $this;
    }

    public function calculateCheckSum(): int
    {
        $arrayCenterCode  = array_map('intval', str_split($this->centerCode));
        $arrayCardCode = array_map('intval', str_split($this->cardCode));

        $arraySum = array_merge($arrayCenterCode, $arrayCardCode);

        return array_sum($arraySum) % 9;
    }
}
