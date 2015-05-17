<?php

namespace spec\Yami\SheetFight\Model;

use Yami\SheetFight\Model\Input;
use PhpSpec\ObjectBehavior;

class InputSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith('123');
        $this->shouldHaveType('Yami\SheetFight\Model\Input');
    }

    public function it_requires_a_string_to_be_constructed()
    {
        $this->beConstructedWith('123');
        $this->shouldThrow('InvalidArgumentException')->during('__construct', [123]);
    }

    public function it_is_an_input()
    {
        $this->beConstructedWith('123');
        $this->shouldImplement('Yami\SheetFight\Model\InputInterface');
    }

    public function it_has_the_input_string_representation()
    {
        $this->beConstructedWith('123');
        $this->getValue()->shouldBeString();
        $this->getValue()->shouldReturn('123');
    }

    public function it_compares_by_value(Input $otherInput)
    {
        $otherInput->getValue()->willReturn('123');
        $this->beConstructedWith('123');
        $this->equals($otherInput)->shouldBeBoolean();
        $this->equals($otherInput)->shouldReturn(true);

        $otherInput->getValue()->willReturn('231');
        $this->equals($otherInput)->shouldBeBoolean();
        $this->equals($otherInput)->shouldReturn(false);
    }
}
