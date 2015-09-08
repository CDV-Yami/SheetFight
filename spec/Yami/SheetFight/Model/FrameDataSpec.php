<?php

namespace spec\Yami\SheetFight\Model;

use PhpSpec\ObjectBehavior;
use InvalidArgumentException;
use RangeException;
use Yami\SheetFight\Model\FrameDataInterface;

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

    public function it_has_startup_frames()
    {
        $this->getStartup()->shouldBeInteger();
        $this->getStartup()->shouldReturn(1);
        $this->shouldThrow(new InvalidArgumentException('The startup frames should be integer'))
            ->during('__construct', ['Yamo', 2, 3, 4, 5])
        ;
    }

    public function its_startup_frames_should_always_be_positive()
    {
      $this->shouldThrow(new RangeException('The startup frames should not be negative'))
          ->during('__construct', [-1, 1, 3, 4, 5])
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

    public function its_active_frames_should_always_be_positive()
    {
      $this->shouldThrow(new RangeException('The active frames should not be negative'))
          ->during('__construct', [1, -1, 3, 4, 5])
      ;
    }

    public function it_has_recovery_frames()
    {
        $this->getRecovery()->shouldBeInteger();
        $this->getRecovery()->shouldReturn(3);
        $this->shouldThrow(new InvalidArgumentException('The recovery frames should be integer'))
            ->during('__construct', [1, 2, 'Yamo', 4, 5])
        ;
    }

    public function its_recovery_frames_should_always_be_positive()
    {
      $this->shouldThrow(new RangeException('The recovery frames should not be negative'))
          ->during('__construct', [1, 1, -1, 4, 5])
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

    public function it_compares_by_frames_value(FrameDataInterface $otherFrameData)
    {
        $otherFrameData->getStartup()->willReturn(1);
        $otherFrameData->getActive()->willReturn(2);
        $otherFrameData->getRecovery()->willReturn(3);
        $otherFrameData->getGuardAdvantage()->willReturn(4);
        $otherFrameData->getHitAdvantage()->willReturn(5);
        $this->equals($otherFrameData)->shouldBeBoolean();
        $this->equals($otherFrameData)->shouldReturn(true);

        $otherFrameData->getStartup()->willReturn(1);
        $otherFrameData->getActive()->willReturn(2);
        $otherFrameData->getRecovery()->willReturn(2);
        $otherFrameData->getGuardAdvantage()->willReturn(4);
        $otherFrameData->getHitAdvantage()->willReturn(5);
        $this->equals($otherFrameData)->shouldBeBoolean();
        $this->equals($otherFrameData)->shouldReturn(false);
    }
}
