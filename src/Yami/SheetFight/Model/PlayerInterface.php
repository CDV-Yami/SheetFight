<?php

namespace Yami\SheetFight\Model;

/**
 * Represents a person playing the game
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
interface PlayerInterface
{
    /**
     * Return the user's name
     *
     * @return string
     */
    public function getNickname();

    /**
     * Return the main character
     *
     * @return Yami\SheetFight\Model\CharacterInterface
     */
    public function getMain();

    /**
     * Return the sub character
     *
     * @return Yami\SheetFight\Model\CharacterInterface
     */
    public function getSub();
}
