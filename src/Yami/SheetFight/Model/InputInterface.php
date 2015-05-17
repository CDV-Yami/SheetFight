<?php

namespace Yami\SheetFight\Model;

/**
 * Represents the inputs done by the player to perform a move.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
interface InputInterface
{
    /**
     * Return the value.
     *
     * @return string
     */
    public function getValue();

    /**
     * Compare input by value.
     *
     * @param InputInterface $input
     *
     * @return bool
     */
    public function equals(InputInterface $input);
}
