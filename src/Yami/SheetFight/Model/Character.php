<?php

namespace Yami\SheetFight\Model;

use InvalidArgumentException;
use RangeException;

/**
 * Represents a character in the game.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
class Character implements CharacterInterface
{
    protected $name;
    protected $health;
    protected $moves;

    public function __construct($name, $health, $moves)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('The name should be a string');
        }

        if (!is_int($health)) {
            throw new InvalidArgumentException('The health should be an integer');
        }

        if ($health < 1) {
            throw new RangeException('The health should be positive');
        }

        $uniqueMoves = [];
        foreach ($moves as $move) {
            if (!($move instanceof MoveInterface)) {
                throw new InvalidArgumentException('The moves should contain only move');
            }
            if (isset($uniqueMoves[$move->getInputs(true)])) {
                throw new InvalidArgumentException('The moves should contain only unique move');
            }
            $uniqueMoves[$move->getInputs(true)] = true;
        }
        unset($uniqueMoves);

        $this->name = $name;
        $this->health = $health;
        $this->moves = $moves;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * {@inheritdoc}
     *
     * @return Yami\SheetFight\Model\MoveInterface[]
     */
    public function getMoves()
    {
        return $this->moves;
    }
}
