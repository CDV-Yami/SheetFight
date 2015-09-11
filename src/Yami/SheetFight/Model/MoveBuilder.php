<?php

namespace Yami\SheetFight\Model;

use LogicException;

/**
 * Provides a fluent interface to build a MoveInterface.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
class MoveBuilder
{
    protected $parser;
    protected $type;
    protected $name;
    protected $initialPosition;
    protected $inputs;
    protected $damage;
    protected $meterGain;
    protected $hitLevel;
    protected $cancelAbilities;
    protected $startFrames;
    protected $activeFrames;
    protected $recoveryFrames;
    protected $guardAdvantage;
    protected $hitAdvantage;

    public function __construct(InputParserInterface $parser)
    {
        $this->parser = $parser;
        $this->inputs = [];
        $this->cancelAbilities = [];

        return $this;
    }

    /**
     * Define the type.
     *
     * @param string $type
     *
     * @return static
     */
    public function is($type)
    {
        if (null !== $this->type) {
            throw new LogicException('Already typed');
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Define the name.
     *
     * @param string $name
     *
     * @return static
     */
    public function named($name)
    {
        if (null !== $this->name) {
            throw new LogicException('Already named');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Define the position.
     *
     * @param string $position
     *
     * @return static
     */
    public function start($position)
    {
        if (null !== $this->initialPosition) {
            throw new LogicException('Start already defined');
        }

        $this->initialPosition = $position;

        return $this;
    }

    /**
     * Define the damage.
     *
     * @param int $damage
     *
     * @return static
     */
    public function deal($damage)
    {
        if (null !== $this->damage) {
            throw new LogicException('Damage already defined');
        }

        $this->damage = $damage;

        return $this;
    }

    /**
     * Define the hit level.
     *
     * @param string $hitLevel
     *
     * @return static
     */
    public function aim($hitLevel)
    {
        if (null !== $this->hitLevel) {
            throw new LogicException('Hit level already defined');
        }

        $this->hitLevel = $hitLevel;

        return $this;
    }

    /**
     * Define the meter gain.
     *
     * @param int $value
     *
     * @return static
     */
    public function withMeterGain($value)
    {
        if (null !== $this->meterGain) {
            throw new LogicException('Meter gain already defined');
        }

        $this->meterGain = $value;

        return $this;
    }

    /**
     * Define the inputs.
     *
     * @param string $inputs
     *
     * @return static
     */
    public function withInputs($inputs)
    {
        if (0 < count($this->inputs)) {
            throw new LogicException('Inputs already defined');
        }

        $this->inputs = $this->parser->transforms($inputs);

        return $this;
    }

    /**
     * Add a cancel ability.
     *
     * @param MoveInterface $move
     *
     * @return static
     */
    public function addCancel(MoveInterface $move)
    {
        foreach ($this->cancelAbilities as $cancelAbility) {
            if ($cancelAbility->equals($move)) {
                throw new LogicException(
                    sprintf('Cancel ability "%s" already defined', $move->getName())
                );
            }
        }

        $this->cancelAbilities[] = $move;

        return $this;
    }

    /**
     * Define the frames required to start.
     *
     * @param int $frames
     *
     * @return static
     */
    public function startIn($frames)
    {
        if (null !== $this->startFrames) {
            throw new LogicException('Start frames already defined');
        }
        $this->startFrames = $frames;

        return $this;
    }

    /**
     * Define the frames displaying the move.
     *
     * @param int $frames
     *
     * @return static
     */
    public function activeDuring($frames)
    {
        if (null !== $this->activeFrames) {
            throw new LogicException('Active frames already defined');
        }
        $this->activeFrames = $frames;

        return $this;
    }

    /**
     * Define the frames required to recover.
     *
     * @param int $frames
     *
     * @return static
     */
    public function recoverIn($frames)
    {
        if (null !== $this->recoveryFrames) {
            throw new LogicException('Recovery frames already defined');
        }
        $this->recoveryFrames = $frames;

        return $this;
    }

    /**
     * Define the difference of frame with the target gets hit to get back to the neutral state.
     *
     * @param int $frames
     *
     * @return static
     */
    public function advantageOnHit($frames)
    {
        if (null !== $this->hitAdvantage) {
            throw new LogicException('Hit advantage already defined');
        }
        $this->hitAdvantage = $frames;

        return $this;
    }

    /**
     * Define the difference of frame with the target on guard to get back to the neutral state.
     *
     * @param int $frames
     *
     * @return static
     */
    public function advantageOnGuard($frames)
    {
        if (null !== $this->guardAdvantage) {
            throw new LogicException('Guard advantage already defined');
        }
        $this->guardAdvantage = $frames;

        return $this;
    }

    /**
     * Build the desired move.
     *
     * @return MoveInterface
     */
    public function build()
    {
        return new Move(
            $this->type,
            $this->name,
            $this->initialPosition,
            $this->inputs,
            $this->damage,
            $this->meterGain,
            $this->hitLevel,
            $this->cancelAbilities,
            new FrameData(
                $this->startFrames,
                $this->activeFrames,
                $this->recoveryFrames,
                $this->guardAdvantage,
                $this->hitAdvantage
            )
        );
    }
}
