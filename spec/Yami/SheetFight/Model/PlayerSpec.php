<?php

namespace spec\Yami\SheetFight\Model;

use PhpSpec\ObjectBehavior;
use InvalidArgumentException;
use Yami\SheetFight\Model\CharacterInterface;

class PlayerSpec extends ObjectBehavior
{
    public function let(CharacterInterface $main, CharacterInterface $sub)
    {
        $this->beConstructedWith('Yamo', $main, $sub);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Yami\SheetFight\Model\Player');
    }

    public function it_is_a_player()
    {
        $this->shouldImplement('Yami\SheetFight\Model\PlayerInterface');
    }

    public function it_has_a_nickname()
    {
        $this->getNickname()->shouldBeString();
        $this->getNickname()->shouldReturn('Yamo');
    }

    public function its_nickname_should_be_string(CharacterInterface $main, CharacterInterface $sub)
    {
        $this->shouldThrow(new InvalidArgumentException('The nickname should be a string'))->during('__construct', [123, $main, $sub]);
    }

    public function it_has_a_main_character(CharacterInterface $main)
    {
        $this->getMain()->shouldReturn($main);
    }

    public function it_has_a_sub_character(CharacterInterface $sub)
    {
        $this->getSub()->shouldReturn($sub);
    }
}
