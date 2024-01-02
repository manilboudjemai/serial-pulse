<?php

namespace App\Model\Enum\Interface;

interface Choosable {
    /**
     * Returns a filtered array of all the enum instances; as options to be selected.
     *
     * @return array
     */
    public static function choices(): array;
}
