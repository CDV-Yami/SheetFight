<?php

namespace Yami\SheetFight\Model;

use InvalidArgumentException;

/**
 * Represents the inputs done by the player to perform a move.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
class Input implements InputInterface
{
    private $value;

    /**
     * Creates a new input.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('String expected');
        }

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     *
     * @param InputInterface $input
     *
     * @return bool
     */
    public function equals(InputInterface $input)
    {
        return $this->value === $input->getValue();
    }
}
