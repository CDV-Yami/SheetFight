<?php

namespace Yami\SheetFight\Model;

use InvalidArgumentException;
use RangeException;

/**
 * Represents an action done by the character in the game.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
class Move implements MoveInterface
{
    private $type;
    private $name;
    private $initialPosition;
    private $inputs;
    private $damage;
    private $meterGain;
    private $hitLevel;
    private $cancelAbilities;
    private $frameData;

    public function __construct(
        $type,
        $name,
        $initialPosition,
        $inputs,
        $damage,
        $meterGain,
        $hitLevel,
        $cancelAbilities,
        FrameDataInterface $frameData
    ) {
        if (!is_string($name)) {
            throw new InvalidArgumentException('The name should be a string');
        }

        switch (false) {
            case is_string($initialPosition):
                throw new InvalidArgumentException('The initial position should be a string');
            case in_array($initialPosition, ['standing', 'crouching', 'airborne']):
                throw new InvalidArgumentException('Invalid initial position');
        }

        if (!is_array($inputs)) {
            throw new InvalidArgumentException('The inputs should be an array');
        }

        if (0 === count($inputs)) {
            throw new InvalidArgumentException('The inputs should not be empty');
        }

        foreach ($inputs as $input) {
            if (!($input instanceof InputInterface)) {
                throw new InvalidArgumentException('The inputs should contain only input');
            }
        }

        if ($damage < 0) {
            throw new RangeException('The damage should not be negative');
        }

        switch (false) {
            case is_string($hitLevel):
                throw new InvalidArgumentException('The hit level should be string');
            case in_array($hitLevel, ['low', 'mid', 'high']):
                throw new InvalidArgumentException('Invalid hit level');
        }

        if (!is_array($cancelAbilities)) {
            throw new InvalidArgumentException('The cancel abilities should be an array');
        }

        foreach ($cancelAbilities as $cancelAbility) {
            if (!($cancelAbility instanceof MoveInterface)) {
                throw new InvalidArgumentException('The cancel abilities should contain only moves');
            }
        }

        $this->type = $type;
        $this->name = $name;
        $this->initialPosition = $initialPosition;
        $this->inputs = $inputs;
        $this->damage = $damage;
        $this->meterGain = $meterGain;
        $this->hitLevel = $hitLevel;
        $this->cancelAbilities = $cancelAbilities;
        $this->frameData = $frameData;
    }
    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isNormal()
    {
        return MoveInterface::TYPE_NORMAL === $this->type;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isSpecial()
    {
        return MoveInterface::TYPE_SPECIAL === $this->type;
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isSuper()
    {
        return MoveInterface::TYPE_SUPER === $this->type;
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
     * @return string standing, crouching or jumping
     */
    public function getInitialPosition()
    {
        return $this->initialPosition;
    }

    /**
     * {@inheritdoc}
     *
     * @return Yami\SheetFight\Model\InputInterface[]
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getMeterGain()
    {
        return $this->meterGain;
    }

    /**
     * {@inheritdoc}
     *
     * @return string low, mid or high
     */
    public function getHitLevel()
    {
        return $this->hitLevel;
    }

    /**
     * {@inheritdoc}
     *
     * @return Yami\SheetFight\Model\MoveInterface[]
     */
    public function getCancelAbilities()
    {
        return $this->cancelAbilities;
    }

    /**
     * {@inheritdoc}
     *
     * @return Yami\SheetFight\Model\FrameDataInterface
     */
    public function getFrameData()
    {
        return $this->frameData;
    }

    /**
     * {@inheritdoc}
     *
     * @param MoveInterface $otherMove
     *
     * @return bool
     */
    public function equals(MoveInterface $otherMove)
    {
        if (count($this->inputs) !== count($otherMove->getInputs())) {
            return false;
        }

        foreach ($this->inputs as $index => $input) {
            if ($otherMove->getInputs()[$index] !== $input) {
                return false;
            }
        }

        return true;
    }
}
