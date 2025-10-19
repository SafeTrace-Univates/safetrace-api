<?php

namespace App\Traits;

trait Latin1ToUtf8Trait
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (is_string($value) && $this->needsConversion($value)) {
            return mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
        }

        return $value;
    }

    public function getAttributes()
    {
        $attributes = parent::getAttributes();

        foreach ($attributes as $key => $value) {
            if (is_string($value) && $this->needsConversion($value)) {
                $attributes[$key] = mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
            }
        }

        return $attributes;
    }

    public function toArray()
    {
        $array = parent::toArray();

        foreach ($array as $key => $value) {
            if (is_string($value) && $this->needsConversion($value)) {
                $array[$key] = mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
            }
        }

        return $array;
    }

    private function needsConversion($value)
    {
        return !mb_check_encoding($value, 'UTF-8');
    }
}
