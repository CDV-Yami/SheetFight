<?php

namespace Yami\SheetFight\Model;

/**
 * Provides accurate frame data for a move
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
interface FrameDataInterface
{
    /**
     * Return the amount of frames displaying the preparation of the move
     *
     * @return int
     */
    public function getStartup();

    /**
     * Return the amount of frames displaying the move
     *
     * @return int
     */
    public function getActive();

    /**
     * Return the amount of frames required to get back to the neutral state
     *
     * @return int
     */
    public function getRecovery();

    /**
     * Return the difference of frame with the target on guard to get back to the neutral state
     *
     * @return int
     */
    public function getOnGuardAdvantage();

    /**
     * Return the difference of frame when the target gets hit to get back to the neutral state
     *
     * @return int
     */
    public function getOnHitAdvantage();
}
