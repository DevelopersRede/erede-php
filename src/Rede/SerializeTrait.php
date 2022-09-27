<?php

namespace Rede;

trait SerializeTrait
{
    /**
     * @return array<string,mixed>
     */
    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this), function ($value) {
            return $value !== null;
        });
    }
}
