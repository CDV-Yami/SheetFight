<?php

namespace spec\Yami\SheetFight\Model;

use PhpSpec\ObjectBehavior;
use InvalidArgumentException;

class FrameDataSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(1, 2, 3, 4, 5);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Yami\SheetFight\Model\FrameData');
    }

    public function it_is_a_frame_data()
    {
        $this->shouldImplement('Yami\SheetFight\Model\FrameDataInterface');
    }

    public function it_has_a_startup()
    {
        $this->getStartup()->shouldBeInteger();
        $this->getStartup()->shouldReturn(1);
        $this->shouldThrow(new InvalidArgumentException('The startup should be integer'))
            ->during('__construct', ['Yamo', 2, 3, 4, 5])
        ;
    }

    public function it_has_active_frames()
    {
        $this->getActive()->shouldBeInteger();
        $this->getActive()->shouldReturn(2);
        $this->shouldThrow(new InvalidArgumentException('The active frames should be integer'))
            ->during('__construct', [1, 'Yamo', 3, 4, 5])
        ;
    }

    public function it_has_a_recovery()
    {
        $this->getRecovery()->shouldBeInteger();
        $this->getRecovery()->shouldReturn(3);
        $this->shouldThrow(new InvalidArgumentException('The recovery should be integer'))
            ->during('__construct', [1, 2, 'Yamo', 4, 5])
        ;
    }

    public function it_has_a_guard_advantage()
    {
        $this->getGuardAdvantage()->shouldBeInteger();
        $this->getGuardAdvantage()->shouldReturn(4);
        $this->shouldThrow(new InvalidArgumentException('The guard advantage should be integer'))
            ->during('__construct', [1, 2, 3, 'Yamo', 5])
        ;
    }

    public function it_has_a_hit_advantage()
    {
        $this->getHitAdvantage()->shouldBeInteger();
        $this->getHitAdvantage()->shouldReturn(5);
        $this->shouldThrow(new InvalidArgumentException('The hit advantage should be integer'))
            ->during('__construct', [1, 2, 3, 4, 'Yamo'])
        ;
    }
}
