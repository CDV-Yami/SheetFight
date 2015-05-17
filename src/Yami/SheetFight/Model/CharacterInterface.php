<?php

namespace Yami\SheetFight\Model;

/**
 * Represents a character in the game.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
interface CharacterInterface
{
    /**
     * Return character's name.
     *
     * @return string
     */
    public function getName();

    /**
     * Return character's health gauge.
     *
     * @return int
     */
    public function getHealth();

    /**
     * Return the list of moves available.
     *
     * @return Yami\SheetFight\Model\MoveInterface[]
     */
    public function getMoves();
}
