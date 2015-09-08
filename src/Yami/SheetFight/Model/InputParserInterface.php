<?php

namespace Yami\SheetFight\Model;

/**
 * Defines an input parser
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
interface InputParserInterface
{
    /**
     * Transform a string to a collection of Input.
     *
     * @param string $string
     *
     * @return InputInterface[]
     */
    public function transforms($string);
}
