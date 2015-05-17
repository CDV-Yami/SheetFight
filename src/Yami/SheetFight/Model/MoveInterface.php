<?php

namespace Yami\SheetFight\Model;

/**
 * Represents an action done by the character in the game.
 *
 * @author Kevin GITTENS <kgittens973@gmail.com>
 * @author Ludovic FLEURY <ludo.fleury@gmail.com>
 */
interface MoveInterface
{
    const TYPE_NORMAL = 'normal';

    const TYPE_SPECIAL = 'special';

    const TYPE_SUPER = 'super';

    /**
     * Return true if it's a normal move.
     *
     * @return bool
     */
    public function isNormal();

    /**
     * Return true if it's a special move.
     *
     * @return bool
     */
    public function isSpecial();

    /**
     * Return true if it's a super move.
     *
     * @return bool
     */
    public function isSuper();

    /**
     * Return the common name.
     *
     * @return string
     */
    public function getName();

    /**
     * Return the initial position of the character.
     *
     * @return string standing, crouching or jumping
     */
    public function getInitialPosition();

    /**
     * Return a collection of inputs required to accomplish the move.
     *
     * @return Yami\SheetFight\Model\InputInterface[]|string
     */
    public function getInputs($asString = false);

    /**
     * Return the damage value dealt to the target.
     *
     * @return int
     */
    public function getDamage();

    /**
     * Return the meter gain value earned by the dealer.
     *
     * @return int
     */
    public function getMeterGain();

    /**
     * Return the hit level on the target.
     *
     * @return string low, mid or high
     */
    public function getHitLevel();

    /**
     * Return the move able to cancel the active and recovery frames.
     *
     * @return Yami\SheetFight\Model\MoveInterface[]
     */
    public function getCancelAbilities();

    /**
     * Return the breakdown of frames.
     *
     * @return Yami\SheetFight\Model\FrameDataInterface
     */
    public function getFrameData();

    /**
     * Compares move by inputs.
     *
     * @param MoveInterface $otherMove
     *
     * @return bool
     */
    public function equals(MoveInterface $otherMove);
}
