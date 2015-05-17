<?php

namespace spec\Yami\SheetFight\Model;

use PhpSpec\ObjectBehavior;
use Yami\SheetFight\Model\MoveInterface;
use Yami\SheetFight\Model\InputParser;
use Yami\SheetFight\Model\Input;
use Yami\SheetFight\Model\Move;
use Yami\SheetFight\Model\FrameData;
use LogicException;

class MoveBuilderSpec extends ObjectBehavior
{
    public function it_is_initializable(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->shouldHaveType('Yami\SheetFight\Model\MoveBuilder');
    }

    public function it_should_be_typed_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->is('special');
        $this->shouldThrow(new LogicException('Already typed'))
            ->during('is', [null])
        ;
    }

    public function it_should_be_named_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->named('Hadoken');
        $this->shouldThrow(new LogicException('Already named'))
            ->during('named', [null])
        ;
    }

    public function its_start_position_should_be_defined_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->start('standing');
        $this->shouldThrow(new LogicException('Start already defined'))
            ->during('start', [null])
        ;
    }

    public function its_damage_should_be_defined_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->deal(80);
        $this->shouldThrow(new LogicException('Damage already defined'))
            ->during('deal', [null])
        ;
    }

    public function its_hit_level_should_be_defined_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->aim('mid');
        $this->shouldThrow(new LogicException('Hit level already defined'))
            ->during('aim', [null])
        ;
    }

    public function its_meter_gain_should_be_defined_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->withMeterGain(10);
        $this->shouldThrow(new LogicException('Meter gain already defined'))
            ->during('withMeterGain', [null])
        ;
    }

    public function its_inputs_should_be_defined_only_once(InputParser $parser)
    {
        $parser->transforms('236P')->willReturn([new Input('2'), new Input('3'), new Input('6'), new Input('P')]);
        $this->beConstructedWith($parser);
        $this->withInputs('236P');
        $this->shouldThrow(new LogicException('Inputs already defined'))
            ->during('withInputs', [[]])
        ;
    }

    public function its_cancel_abilities_should_be_defined_only_once(InputParser $parser, MoveInterface $move)
    {
        $move->getName()->willReturn('Hadouken');
        $move->equals($move)->willReturn(true);
        $this->beConstructedWith($parser);
        $this->addCancel($move);
        $this->shouldThrow(new LogicException('Cancel ability "Hadouken" already defined'))
            ->during('addCancel', [$move])
        ;
    }

    public function its_start_frames_should_be_defined_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->startIn(10);
        $this->shouldThrow(new LogicException('Start frames already defined'))
            ->during('startIn', [null])
        ;
    }

    public function its_active_frames_should_be_defined_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->activeDuring(20);
        $this->shouldThrow(new LogicException('Active frames already defined'))
            ->during('activeDuring', [null])
        ;
    }

    public function its_recovery_should_be_defined_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->recoverIn(10);
        $this->shouldThrow(new LogicException('Recovery frames already defined'))
            ->during('recoverIn', [null])
        ;
    }

    public function its_hit_advantage_should_be_defined_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->advantageOnHit(5);
        $this->shouldThrow(new LogicException('Hit advantage already defined'))
            ->during('advantageOnHit', [null])
        ;
    }

    public function its_guard_advantage_should_be_defined_only_once(InputParser $parser)
    {
        $this->beConstructedWith($parser);
        $this->advantageOnGuard(-10);
        $this->shouldThrow(new LogicException('Guard advantage already defined'))
            ->during('advantageOnGuard', [null])
        ;
    }

    public function it_builds_move(InputParser $parser)
    {
        $parser->transforms('236P')
            ->willReturn([
                new Input('2'),
                new Input('3'),
                new Input('6'),
                new Input('P'),
            ])
        ;

        $expectedMove = new Move(
            'special',
            'Hadouken',
            'standing',
            [
                new Input('2'),
                new Input('3'),
                new Input('6'),
                new Input('P'),
            ],
            80,
            10,
            'mid',
            [],
            new FrameData(
                10,
                20,
                10,
                5,
                -10
            )
        );

        $this->beConstructedWith($parser);
        $this
            ->is('special')
            ->named('Hadouken')
            ->start('standing')
            ->deal(80)
            ->aim('mid')
            ->withMeterGain(10)
            ->withInputs('236P')
            ->startIn(10)
            ->activeDuring(20)
            ->recoverIn(10)
            ->advantageOnHit(-10)
            ->advantageOnGuard(5)
        ;

        $this->build()->shouldReturnMove($expectedMove);
    }

    public function getMatchers()
    {
        return [
            'returnMove' => function ($subject, MoveInterface $expectation) {

                $isSameInputs = function ($subject, $expectation) {
                    if (!is_array($subject)) {
                        return false;
                    }

                    if (count($expectation) !== count($subject)) {
                        return false;
                    }

                    foreach ($expectation as $index => $expectedInput) {
                        if (get_class($subject[$index]) !== get_class($expectedInput) ||
                            !$expectedInput->equals($subject[$index])) {
                            return false;
                        }
                    }

                    return true;
                };

                $isSameCancelAbilities = function ($subject, $expectation) {
                    if (!is_array($subject)) {
                        return false;
                    }

                    if (count($expectation) !== count($subject)) {
                        return false;
                    }

                    foreach ($expectation as $index => $expectedMove) {
                        if (!$expectedMove->equals($subject[$index])) {
                            return false;
                        }
                    }

                    return true;
                };

                return
                    $expectation->isNormal() === $subject->isNormal() &&
                    $expectation->isSpecial() === $subject->isSpecial() &&
                    $expectation->isSuper() === $subject->isSuper() &&
                    $expectation->getName() === $subject->getName() &&
                    $expectation->getInitialPosition() === $subject->getInitialPosition() &&
                    $expectation->getDamage() === $subject->getDamage() &&
                    $expectation->getMeterGain() === $subject->getMeterGain() &&
                    $expectation->getHitLevel() === $subject->getHitLevel() &&
                    $isSameInputs($subject->getInputs(), $expectation->getInputs()) &&
                    $expectation->getFrameData()->equals($subject->getFrameData()) &&
                    $isSameCancelAbilities($subject->getCancelAbilities(), $expectation->getCancelAbilities())
                ;
            },
        ];
    }
}
