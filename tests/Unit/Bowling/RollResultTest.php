<?php

namespace Unit\Bowling;

use Bowling\Game;
use Bowling\RollResult;
use Mockery as m;
use Tests\Unit\UnitTest;
use UnexpectedValueException;

/**
 * @method Game uut()
 */
class RollResultTest extends UnitTest
{
    public function testItCompareRollsForStrikeOrSpareOrGutter()
    {
        $roll = RollResult::STRIKE();
        $this->verifyThat($roll->isGutter(), equalTo(false));
        $this->verifyThat($roll->isSpare(), equalTo(false));
        $this->verifyThat($roll->isStrike(), equalTo(true));

        $roll = RollResult::SPARE();
        $this->verifyThat($roll->isGutter(), equalTo(false));
        $this->verifyThat($roll->isStrike(), equalTo(false));
        $this->verifyThat($roll->isSpare(), equalTo(true));

        $roll = RollResult::GUTTER();
        $this->verifyThat($roll->isStrike(), equalTo(false));
        $this->verifyThat($roll->isSpare(), equalTo(false));
        $this->verifyThat($roll->isEqual(RollResult::EIGHT_PINS()), equalTo(false));
        $this->verifyThat($roll->isGutter(), equalTo(true));
    }

    public function testItShouldHaveStringRepresentation()
    {
        $this->verifyThat((string)RollResult::EIGHT_PINS(), equalTo('8'));
    }

    public function testItShouldSupportRollEquality()
    {
        $roll = RollResult::EIGHT_PINS();
        $equalRole = RollResult::EIGHT_PINS();
        $unequalRole = RollResult::FIVE_PINS();

        $this->verifyThat($roll->isEqual($equalRole), equalTo(true));
        $this->verifyThat($roll->isEqual($unequalRole), equalTo(false));
    }

    public function testItCreatesARollFromAStringRepresentation()
    {
        $this->verifyThat(RollResult::create('X'), equalTo(RollResult::STRIKE()));
        $this->verifyThat(RollResult::create('10'), equalTo(RollResult::STRIKE()));
        $this->verifyThat(RollResult::create('/'), equalTo(RollResult::SPARE()));
        $this->verifyThat(RollResult::create('1'), equalTo(RollResult::ONE_PIN()));
        $this->verifyThat(RollResult::create('2'), equalTo(RollResult::TWO_PINS()));
    }
    
    public function testItThrowsExceptionWhenCreatingFromInvalidStringRepresentation()
    {
        $this->expectException(UnexpectedValueException::class);
        RollResult::create('11');
    }
}
