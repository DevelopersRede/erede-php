<?php

namespace Rede;

class Device implements RedeSerializable
{
    use CreateTrait;
    use SerializeTrait;

    /**
     * @param string|null $ColorDepth
     * @param string|null $DeviceType3ds
     * @param bool|null   $JavaEnabled
     * @param string      $Language
     * @param int|null    $ScreenHeight
     * @param int|null    $ScreenWidth
     * @param int|null    $TimeZoneOffset
     */
    public function __construct(
        private ?string $ColorDepth = null,
        private ?string $DeviceType3ds = null,
        private ?bool $JavaEnabled = null,
        private string $Language = 'BR',
        private ?int $ScreenHeight = null,
        private ?int $ScreenWidth = null,
        private ?int $TimeZoneOffset = 3,
    ) {
    }

    /**
     * @return string|null
     */
    public function getColorDepth(): ?string
    {
        return $this->ColorDepth;
    }

    /**
     * @param string $ColorDepth
     * @return $this
     */
    public function setColorDepth(string $ColorDepth): static
    {
        $this->ColorDepth = $ColorDepth;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceType3ds(): ?string
    {
        return $this->DeviceType3ds;
    }

    /**
     * @param string $DeviceType3ds
     * @return $this
     */
    public function setDeviceType3ds(string $DeviceType3ds): static
    {
        $this->DeviceType3ds = $DeviceType3ds;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getJavaEnabled(): ?bool
    {
        return $this->JavaEnabled;
    }

    /**
     * @param bool $JavaEnabled
     * @return $this
     */
    public function setJavaEnabled(bool $JavaEnabled = true): static
    {
        $this->JavaEnabled = $JavaEnabled;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->Language;
    }

    /**
     * @param string $Language
     * @return $this
     */
    public function setLanguage(string $Language): static
    {
        $this->Language = $Language;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getScreenHeight(): ?int
    {
        return $this->ScreenHeight;
    }

    /**
     * @param int $ScreenHeight
     * @return $this
     */
    public function setScreenHeight(int $ScreenHeight): static
    {
        $this->ScreenHeight = $ScreenHeight;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getScreenWidth(): ?int
    {
        return $this->ScreenWidth;
    }

    /**
     * @param int $ScreenWidth
     * @return $this
     */
    public function setScreenWidth(int $ScreenWidth): static
    {
        $this->ScreenWidth = $ScreenWidth;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTimeZoneOffset(): ?int
    {
        return $this->TimeZoneOffset;
    }

    /**
     * @param int $TimeZoneOffset
     * @return $this
     */
    public function setTimeZoneOffset(int $TimeZoneOffset): static
    {
        $this->TimeZoneOffset = $TimeZoneOffset;
        return $this;
    }
}
