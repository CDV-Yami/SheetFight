<?php

namespace Yami\SheetFight\Model;

use InvalidArgumentException;

/**
 * Provides a parser to transform a string to a collection of Input
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
class InputParser
{
    /**
     * Transform a string to a collection of Input
     *
     * @param  string $string
     * 
     * @return InputInterface[]
     */
    public function transforms($string)
    {
        if (!is_string($string)) {
            throw new InvalidArgumentException('A string is required');
        }
        if (false == preg_match('#^[a-zA-Z0-9]+$#', $string)) {
            throw new InvalidArgumentException('A valid string is required');
        }
        $inputs = [];
        $splitted = str_split($string);

        foreach ($splitted as $value) {
            $inputs[] = new Input($value);
        }

        return $inputs;
    }
}
