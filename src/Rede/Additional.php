<?php

namespace Rede;

class Additional implements RedeSerializable
{
    use SerializeTrait;
    use CreateTrait;

    /**
     * @var int|null
     */
    private ?int $gateway = null;

    /**
     * @var int|null
     */
    private ?int $module = null;

    /**
     * @return int|null
     */
    public function getGateway(): ?int
    {
        return $this->gateway;
    }

    /**
     * @param int $gateway
     *
     * @return $this
     */
    public function setGateway(int $gateway): static
    {
        $this->gateway = $gateway;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getModule(): ?int
    {
        return $this->module;
    }

    /**
     * @param int $module
     *
     * @return $this
     */
    public function setModule(int $module): static
    {
        $this->module = $module;
        return $this;
    }
}
