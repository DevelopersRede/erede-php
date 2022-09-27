<?php

namespace Rede;

use DateTime;
use Exception;

trait CreateTrait
{
    /**
     * @param object $data
     *
     * @return object
     * @throws Exception
     */
    public static function create(object $data): object
    {
        $object = new self();
        $dataKeys = get_object_vars($data);
        $objectKeys = get_object_vars($object);

        foreach ($dataKeys as $property => $value) {
            if (array_key_exists($property, $objectKeys)) {
                if ($property == 'requestDateTime' || $property == 'dateTime' || $property == 'refundDateTime') {
                    $value = new DateTime($value);
                }

                $object->{$property} = $value;
            }
        }

        return $object;
    }
}
