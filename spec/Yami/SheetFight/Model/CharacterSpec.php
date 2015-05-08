<?php

namespace spec\Yami\SheetFight\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use InvalidArgumentException;
use RangeException;
use Yami\SheetFight\Model\MoveInterface;

class CharacterSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Yamo', 100, []);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Yami\SheetFight\Model\Character');
    }

    public function it_is_a_character()
    {
        $this->shouldImplement('Yami\SheetFight\Model\CharacterInterface');
    }

    public function it_has_a_name()
    {
        $this->getName()->shouldBeString();
        $this->getName()->shouldReturn('Yamo');
    }

    public function its_name_should_be_string()
    {
        $this->shouldThrow(new InvalidArgumentException('The name should be a string'))
            ->during('__construct', [123, 100, []])
        ;
    }

    public function it_has_health()
    {
        $this->getHealth()->shouldBeInteger();
        $this->getHealth()->shouldReturn(100);
    }

    public function its_health_should_be_integer()
    {
        $this->shouldThrow(new InvalidArgumentException('The health should be an integer'))
            ->during('__construct', ['Yamo', '123', []])
        ;
    }

    public function its_health_should_be_positive()
    {
        $this->shouldThrow(new RangeException('The health should be positive'))
            ->during('__construct', ['Yamo', -1, []])
        ;
        $this->shouldThrow(new RangeException('The health should be positive'))
            ->during('__construct', ['Yamo', 0, []])
        ;
    }

    public function it_has_a_collection_of_moves(MoveInterface $move)
    {
        $moves = [$move];
        $this->beConstructedWith('Ken', 100, $moves);
        $this->getMoves()->shouldBeArray();
        $this->getMoves()->shouldReturn($moves);
    }

    public function its_moves_should_contain_only_move(MoveInterface $move)
    {
        $this->shouldThrow(new InvalidArgumentException('The moves should contain only move'))
            ->during('__construct', ['Yamo', 100, [$move, 123]])
        ;
    }

    public function its_should_have_unique_moves(MoveInterface $move)
    {
        $this->shouldThrow(new InvalidArgumentException('The moves should contain only unique move'))
            ->during('__construct', ['Yamo', 100, [$move, $move]])
        ;
    }
}
