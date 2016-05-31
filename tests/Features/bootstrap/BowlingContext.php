<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Bowling\Game;
use Bowling\RollResult;
use Bowling\ScoreListener;
use Tests\Codeception\TestCase\Hamcrest;

class BowlingContext implements Context
{
    use Hamcrest;

    /**
     * @var TableNode
     */
    private $sheet;

    /**
     * @Given /^I have the following sheet:$/
     */
    public function iHaveTheFollowingSheet(TableNode $sheet)
    {
        $this->sheet = $sheet;
    }

    /**
     * @Then /^the score should be (\d+)$/
     */
    public function theScoreShouldBe(string $expectedScore)
    {
        foreach ($this->sheet->getRows() as $gameSheet) {
            $game = new Game();
            $game->addRollListener(new ScoreListener());
            
            foreach ($gameSheet as $frame) {
                $game->roll(RollResult::create($frame{0}));

                if (strlen($frame) > 1) {
                    $game->roll(RollResult::create($frame{1}));
                }
            }

            $this->verifyThat($game->getCurrentScore(), equalTo($expectedScore));
        }
    }
}
