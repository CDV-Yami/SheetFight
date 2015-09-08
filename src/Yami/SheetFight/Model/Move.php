<?php

namespace Yami\SheetFight\Model;

use InvalidArgumentException;
use LogicException;
use RangeException;

/**
 * Represents an action done by the character in the game.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
class Move implements MoveInterface
{
    /**
     * @var string normal|special|super
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string crouching|standing|airborne
     */
    private $initialPosition;

    /**
     * @var \Yami\SheetFight\Model\InputInterface
     */
    private $inputs;

    /**
     * @var int Positive integer
     */
    private $damage;

    /**
     * @var int integer
     */
    private $meterGain;

    /**
     * @var string low|mid|high
     */
    private $hitLevel;

    /**
     * @var \Yami\SheetFight\Model\MoveInterface[]
     */
    private $cancelAbilities;

    /**
     * @var \Yami\SheetFight\Model\FrameDataInterface
     */
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

        if (!is_int($damage)) {
            throw new InvalidArgumentException('The damage should be an integer');
        }

        if ($damage < 0) {
            throw new RangeException('The damage should not be negative');
        }

        if (!is_int($meterGain)) {
            throw new InvalidArgumentException('The meter gain should be an integer');
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

        $uniqueCancelAbilities = [];
        foreach ($cancelAbilities as $index => $cancelAbility) {
            if (!($cancelAbility instanceof MoveInterface)) {
                throw new InvalidArgumentException('The cancel abilities should contain only moves');
            }

            $serializedInputs = $cancelAbility->getInputs(true);

            if (isset($uniqueCancelAbilities[$serializedInputs])) {
                throw new LogicException('The cancel abilities should contain unique moves');
            }

            $uniqueCancelAbilities[$serializedInputs] = true;
        }
        unset($uniqueCancelAbilities);

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
     * @return Yami\SheetFight\Model\InputInterface[]|string
     */
    public function getInputs($asString = false)
    {
        if ($asString) {
            $inputs = '';
            foreach ($this->inputs as $input) {
                $inputs .= $input->getValue();
            }
        } else {
            $inputs = $this->inputs;
        }

        return $inputs;
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
        return $this->getInputs(true) === $otherMove->getInputs(true);
    }
}
