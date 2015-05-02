<?php

namespace spec\Yami\SheetFight\Model;

use Yami\SheetFight\Model\Input;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InputSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Yami\SheetFight\Model\Input');
    }
}
