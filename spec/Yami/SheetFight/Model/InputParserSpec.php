<?php

namespace spec\Yami\SheetFight\Model;

use PhpSpec\ObjectBehavior;
use Yami\SheetFight\Model\Input;
use InvalidArgumentException;

class InputParserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Yami\SheetFight\Model\InputParser');
    }

    public function it_is_a_parser()
    {
        $this->shouldImplement('Yami\SheetFight\Model\InputParserInterface');
    }

    public function it_transforms_a_string_to_inputs()
    {
        $this->transforms('236P')->shouldReturnInputs(
            [
                new Input('2'),
                new Input('3'),
                new Input('6'),
                new Input('P'),
            ]
        );
    }

    public function it_should_require_a_string()
    {
        $this->shouldThrow(new InvalidArgumentException('A string is required'))
            ->during('transforms', [123])
        ;
    }

    public function it_should_require_a_valid_string()
    {
        $invalidStrings = [
            ' ',
            '',
            ' test',
            'test ',
            '@',
            'te st',
        ];

        foreach ($invalidStrings as $invalidString) {
            $this->shouldThrow(new InvalidArgumentException('A valid string is required'))
                ->during('transforms', [$invalidString])
            ;
        }
    }

    public function getMatchers()
    {
        return [
            'returnInputs' => function ($subject, $expectation) {
                if (!is_array($subject)) {
                    return false;
                }

                if (count($expectation) !== count($subject)) {
                    return false;
                }

                foreach ($expectation as $index => $expectedInput) {
                    if (get_class($subject[$index]) === get_class($expectedInput) &&
                        $subject[$index]->getValue() !== $expectedInput->getValue()) {
                        return false;
                    }
                }

                return true;
            },
        ];
    }
}
