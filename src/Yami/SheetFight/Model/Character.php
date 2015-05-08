<?php

namespace Yami\SheetFight\Model;

use InvalidArgumentException;
use RangeException;

class Character implements CharacterInterface
{
    private $name;
    private $health;
    private $moves;

    public function __construct($name, $health, $moves)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('The name should be a string');
        }

        if (!is_integer($health)) {
            throw new InvalidArgumentException('The health should be an integer');
        }

        if ($health < 1) {
            throw new RangeException('The health should be positive');
        }

        foreach ($moves as $move) {
            if (!($move instanceof MoveInterface)) {
                throw new InvalidArgumentException('The moves should contain only move');
            }
        }

        $this->name = $name;
        $this->health = $health;
        $this->moves = $moves;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function getMoves()
    {
        return $this->moves;
    }
}
