<?php

namespace Yami\SheetFight\Model;

use InvalidArgumentException;

/**
 * Represents a person playing the game
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
class Player implements PlayerInterface
{
    private $nickname;
    private $main;
    private $sub;

    /**
     * Creates a new player
     *
     * @param string $nickname, CharacterInterface $main and CharacterInterface $sub
     */
    public function __construct($nickname, CharacterInterface $main, CharacterInterface $sub)
    {
        if (!is_string($nickname)) {
            throw new InvalidArgumentException('The nickname should be a string');
        }
        $this->nickname = $nickname;
        $this->main = $main;
        $this->sub = $sub;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * {@inheritdoc}
     *
     * @return CharacterInterface
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * {@inheritdoc}
     *
     * @return CharacterInterface
     */
    public function getSub()
    {
        return $this->sub;
    }
}
