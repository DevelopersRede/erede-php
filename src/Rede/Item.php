<?php

namespace Rede;

class Item implements RedeSerializable
{
    use SerializeTrait;

    public const PHYSICAL = 1;
    public const DIGITAL = 2;
    public const SERVICE = 3;
    public const AIRLINE = 4;

    /**
     * @var int|null
     */
    private ?int $amount = null;

    /**
     * @var string|null
     */
    private ?string $description = null;

    /**
     * @var int|null
     */
    private ?int $discount = null;

    /**
     * @var int|null
     */
    private ?int $freight = null;

    /**
     * @var string|null
     */
    private ?string $shippingType = null;

    /**
     * Item constructor.
     *
     * @param string $id
     * @param int    $quantity
     * @param int    $type
     */
    public function __construct(private string $id, private int $quantity, private int $type = Item::PHYSICAL)
    {
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return $this
     */
    public function setAmount(int $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    /**
     * @param int $discount
     *
     * @return $this
     */
    public function setDiscount(int $discount): static
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFreight(): ?int
    {
        return $this->freight;
    }

    /**
     * @param int $freight
     *
     * @return $this
     */
    public function setFreight(int $freight): static
    {
        $this->freight = $freight;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id): static
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingType(): ?string
    {
        return $this->shippingType;
    }

    /**
     * @param string $shippingType
     *
     * @return $this
     */
    public function setShippingType(string $shippingType): static
    {
        $this->shippingType = $shippingType;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function setType(int $type): static
    {
        $this->type = $type;
        return $this;
    }
}
