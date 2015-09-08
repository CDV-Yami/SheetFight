<?php

namespace Yami\SheetFight\Model;

use InvalidArgumentException;
use RangeException;

/**
 * Provides accurate frame data for a move.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
class FrameData implements FrameDataInterface
{
    /**
     * @var int Positive integer
     */
    protected $startup;

    /**
     * @var int Positive integer
     */
    protected $active;

    /**
     * @var int Positive integer
     */
    protected $recovery;

    /**
     * @var int integer
     */
    protected $guardAdvantage;

    /**
     * @var int integer
     */
    protected $hitAdvantage;

    public function __construct($startup, $active, $recovery, $guardAdvantage, $hitAdvantage)
    {
        if (!is_int($startup)) {
            throw new InvalidArgumentException('The startup frames should be integer');
        }

        if ($startup < 0) {
            throw new RangeException('The startup frames should not be negative');
        }

        if (!is_int($active)) {
            throw new InvalidArgumentException('The active frames should be integer');
        }

        if ($active < 0) {
            throw new RangeException('The active frames should not be negative');
        }

        if (!is_int($recovery)) {
            throw new InvalidArgumentException('The recovery frames should be integer');
        }

        if ($recovery < 0) {
            throw new RangeException('The recovery frames should not be negative');
        }

        if (!is_int($guardAdvantage)) {
            throw new InvalidArgumentException('The guard advantage should be integer');
        }

        if (!is_int($hitAdvantage)) {
            throw new InvalidArgumentException('The hit advantage should be integer');
        }

        $this->startup = $startup;
        $this->active = $active;
        $this->recovery = $recovery;
        $this->guardAdvantage = $guardAdvantage;
        $this->hitAdvantage = $hitAdvantage;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getStartup()
    {
        return $this->startup;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getRecovery()
    {
        return $this->recovery;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getGuardAdvantage()
    {
        return $this->guardAdvantage;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function getHitAdvantage()
    {
        return $this->hitAdvantage;
    }

    /**
     * {@inheritdoc}
     *
     * @param FrameDataInterface $otherFrameData
     *
     * @return bool
     */
    public function equals(FrameDataInterface $otherFrameData)
    {
        return
            $this->startup === $otherFrameData->getStartup() &&
            $this->active === $otherFrameData->getActive() &&
            $this->recovery === $otherFrameData->getRecovery() &&
            $this->guardAdvantage === $otherFrameData->getGuardAdvantage() &&
            $this->hitAdvantage === $otherFrameData->getHitAdvantage()
        ;
    }
}
