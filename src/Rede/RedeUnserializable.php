<?php

namespace Rede;

interface RedeUnserializable
{
    /**
     * @param string $serialized
     *
     * @return mixed
     */
    public function jsonUnserialize($serialized);
}
