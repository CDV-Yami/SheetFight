<?php

namespace Yami\SheetFight\Model;

use InvalidArgumentException;

/**
 * Provides accurate frame data for a move.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
class FrameData implements FrameDataInterface
{
    private $startup;
    private $active;
    private $recovery;
    private $guardAdvantage;
    private $hitAdvantage;

    public function __construct($startup, $active, $recovery, $guardAdvantage, $hitAdvantage)
    {
        if (!is_int($startup)) {
            throw new InvalidArgumentException('The startup should be integer');
        }
        if (!is_int($active)) {
            throw new InvalidArgumentException('The active frames should be integer');
        }
        if (!is_int($recovery)) {
            throw new InvalidArgumentException('The recovery should be integer');
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
     * [@inheritdoc].
     *
     * @return int
     */
    public function getStartup()
    {
        return $this->startup;
    }

    /**
     * [@inheritdoc].
     *
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * [@inheritdoc].
     *
     * @return int
     */
    public function getRecovery()
    {
        return $this->recovery;
    }

    /**
     * [@inheritdoc].
     *
     * @return int
     */
    public function getGuardAdvantage()
    {
        return $this->guardAdvantage;
    }

    /**
     * [@inheritdoc].
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
