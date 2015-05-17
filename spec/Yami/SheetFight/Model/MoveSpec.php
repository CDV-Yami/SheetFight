<?php

namespace spec\Yami\SheetFight\Model;

use PhpSpec\ObjectBehavior;
use InvalidArgumentException;
use RangeException;
use Yami\SheetFight\Model\InputInterface;
use Yami\SheetFight\Model\MoveInterface;
use Yami\SheetFight\Model\FrameDataInterface;
use LogicException;

class MoveSpec extends ObjectBehavior
{
    private $defaultInputs;
    private $defaultCancelAbilities;
    private $defaultFrameData;

    public function let(InputInterface $input, MoveInterface $move, FrameDataInterface $frameData)
    {
        $input->getValue()->willReturn('2');
        $move->getInputs()->willReturn([$input]);
        $this->defaultInputs = [$input];
        $this->defaultCancelAbilities = [$move];
        $this->defaultFrameData = $frameData;
        $this->beConstructedWith(
            MoveInterface::TYPE_NORMAL,
            'YamoKick',
            'standing',
            $this->defaultInputs,
            100,
            100,
            'mid',
            $this->defaultCancelAbilities,
            $this->defaultFrameData
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Yami\SheetFight\Model\Move');
    }

    public function it_is_a_move()
    {
        $this->shouldImplement('Yami\SheetFight\Model\MoveInterface');
    }

    /**
     * Specifies if the move is a normal, special or super.
     *
     * @return bool
     */
    public function it_could_be_normal()
    {
        $this->isNormal()->shouldBeBool();
        $this->isNormal()->shouldBe(true);
        $this->isSpecial()->shouldBe(false);
        $this->isSuper()->shouldBe(false);
    }

    public function it_could_be_special()
    {
        $this->beConstructedWith(MoveInterface::TYPE_SPECIAL, 'YamoKick', 'standing', $this->defaultInputs, 100, 100, 'mid', $this->defaultCancelAbilities, $this->defaultFrameData);
        $this->isSpecial()->shouldBeBool();
        $this->isSpecial()->shouldBe(true);
        $this->isNormal()->shouldBe(false);
        $this->isSuper()->shouldBe(false);
    }

    public function it_could_be_super()
    {
        $this->beConstructedWith(MoveInterface::TYPE_SUPER, 'YamoKick', 'standing', $this->defaultInputs, 100, 100, 'mid', $this->defaultCancelAbilities, $this->defaultFrameData);
        $this->isSuper()->shouldBeBool();
        $this->isSuper()->shouldBe(true);
        $this->isSpecial()->shouldBe(false);
        $this->isNormal()->shouldBe(false);
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldBeString();
        $this->getName()->shouldReturn('YamoKick');
    }

    public function its_name_should_be_string()
    {
        $this->shouldThrow(new InvalidArgumentException('The name should be a string'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 123, 'standing', $this->defaultInputs, 100, 100, 'mid', $this->defaultCancelAbilities, $this->defaultFrameData])
        ;
    }

    public function it_has_an_initial_position()
    {
        $this->getInitialPosition()->shouldBeString();
        $this->getInitialPosition()->shouldReturn('standing');
    }

    public function its_initial_position_should_be_string()
    {
        $this->shouldThrow(new InvalidArgumentException('The initial position should be a string'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 123, $this->defaultInputs, 100, 100, 'mid', $this->defaultCancelAbilities, $this->defaultFrameData])
        ;
    }

    public function its_initial_position_should_be_valid()
    {
        $this->shouldThrow(new InvalidArgumentException('Invalid initial position'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'Yamo', $this->defaultInputs, 100, 100, 'mid', $this->defaultCancelAbilities, $this->defaultFrameData])
        ;
    }

    public function it_has_inputs()
    {
        $this->getInputs()->shouldReturn($this->defaultInputs);
    }

    public function its_inputs_should_always_be_an_array()
    {
        $this->shouldThrow(new InvalidArgumentException('The inputs should be an array'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'standing', 1, 100, 100, 'mid', $this->defaultCancelAbilities, $this->defaultFrameData])
        ;
    }

    public function its_inputs_should_only_contain_input(InputInterface $input)
    {
        $this->shouldThrow(new InvalidArgumentException('The inputs should contain only input'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'standing', [$input, 123], 100, 100, 'mid', $this->defaultCancelAbilities, $this->defaultFrameData])
        ;
    }

    public function it_should_have_at_least_one_input()
    {
        $this->shouldThrow(new InvalidArgumentException('The inputs should not be empty'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'standing', [], 100, 100, 'mid', $this->defaultCancelAbilities, $this->defaultFrameData])
        ;
    }

    public function it_has_damage()
    {
        $this->getDamage()->shouldBeInteger();
        $this->getDamage()->shouldReturn(100);
    }

    public function its_damage_should_be_positive()
    {
        $this->shouldThrow(new RangeException('The damage should not be negative'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'standing', $this->defaultInputs, -1, 100, 'mid', $this->defaultCancelAbilities, $this->defaultFrameData])
        ;
    }

    public function it_has_meter_gain()
    {
        $this->getMeterGain()->shouldBeInteger();
        $this->getMeterGain()->shouldReturn(100);
    }

    public function it_has_a_hit_level()
    {
        $this->getHitlevel()->shouldBeString();
        $this->getHitLevel()->shouldReturn('mid');
    }

    public function its_hit_level_should_be_string()
    {
        $this->shouldThrow(new InvalidArgumentException('The hit level should be string'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'standing', $this->defaultInputs, 100, 100, 123, $this->defaultCancelAbilities, $this->defaultFrameData])
        ;
    }

    public function its_hit_level_should_always_be_valid()
    {
        $this->shouldThrow(new InvalidArgumentException('Invalid hit level'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'standing', $this->defaultInputs, 100, 100, 'Yamo', $this->defaultCancelAbilities, $this->defaultFrameData])
        ;
    }

    public function it_has_cancel_abilities()
    {
        $this->getCancelAbilities()->shouldReturn($this->defaultCancelAbilities);
    }

    public function its_cancel_abilities_should_always_be_an_array()
    {
        $this->shouldThrow(new InvalidArgumentException('The cancel abilities should be an array'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'standing', $this->defaultInputs, 100, 100, 'mid', 123, $this->defaultFrameData])
        ;
    }

    public function its_cancel_abilities_should_only_contain_move(MoveInterface $move)
    {
        $this->shouldThrow(new InvalidArgumentException('The cancel abilities should contain only moves'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'standing', $this->defaultInputs, 100, 100, 'mid', [$move, 123], $this->defaultFrameData])
        ;
    }

    public function its_cancel_abilities_should_contain_unique_moves(MoveInterface $move, InputInterface $input)
    {
        $input->getValue()->willReturn('2');
        $move->getInputs()->willReturn([$input]);
        $this->shouldThrow(new LogicException('The cancel abilities should contain unique moves'))
            ->during('__construct', [MoveInterface::TYPE_NORMAL, 'YamoKick', 'standing', $this->defaultInputs, 100, 100, 'mid', [$move, $move], $this->defaultFrameData])
        ;
    }

    public function it_has_a_frame_data()
    {
        $this->getFrameData()->shouldReturn($this->defaultFrameData);
    }

    public function it_compares_by_inputs(MoveInterface $otherMove)
    {
        $otherMove->getInputs()->willReturn($this->defaultInputs);
        $this->equals($otherMove)->shouldBeBoolean();
        $this->equals($otherMove)->shouldReturn(true);

        $otherMove->getInputs()->willReturn([]);
        $this->equals($otherMove)->shouldBeBoolean();
        $this->equals($otherMove)->shouldReturn(false);
    }
}
