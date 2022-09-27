<?php

namespace Rede;

interface RedeUnserializable
{
    /**
     * @param string $serialized
     *
     * @return $this
     */
    public function jsonUnserialize(string $serialized): static;
}
