<?php

namespace Rede;

class Item implements RedeSerializable
{
    use SerializeTrait;

    const PHYSICAL = 1;
    const DIGITAL = 2;
    const SERVICE = 3;
    const AIRLINE = 4;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $discount;

    /**
     * @var int
     */
    private $freight;

    /**
     *
     * @var string
     */
    private $id;

    /**
     *
     * @var int
     */
    private $quantity;

    /**
     *
     * @var string
     */
    private $shippingType;

    /**
     *
     * @var int
     */
    private $type;

    /**
     * Item constructor.
     *
     * @param $id
     * @param $quantity
     * @param int $type
     */
    public function __construct($id, $quantity, $type = Item::PHYSICAL)
    {
        $this->setId($id);
        $this->setQuantity($quantity);
        $this->setType($type);
    }

    /**
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return Item
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param int $discount
     *
     * @return Item
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getFreight()
    {
        return $this->freight;
    }

    /**
     * @param int $freight
     *
     * @return Item
     */
    public function setFreight($freight)
    {
        $this->freight = $freight;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $id
     *
     * @return Item
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return Item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getShippingType()
    {
        return $this->shippingType;
    }

    /**
     * @param string $shippingType
     *
     * @return Item
     */
    public function setShippingType($shippingType)
    {
        $this->shippingType = $shippingType;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param int $type
     *
     * @return Item
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}