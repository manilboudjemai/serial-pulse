<?php

namespace App\Model\Enum\Interface;

interface Queryable {
    /**
     * Returns an array of all the enum instances.
     *
     * @return array
     */
    public static function instances(): array;

    /**
     * Get an enum instance by name.
     *
     * @param string $name
     * @return self
     */
    public static function getByName(string $name): self;
}
