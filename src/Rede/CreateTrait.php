<?php

namespace Rede;

use stdClass;

trait CreateTrait
{
    /**
     * @param stdClass $data
     *
     * @return mixed
     */
    static public function create(stdClass $data)
    {
        $obj = new self();
        $vars = get_object_vars($obj);

        foreach ($data as $property => $value) {
            if (array_key_exists($property, $vars)) {
                $obj->$property = $value;
            }
        }

        return $obj;
    }
}