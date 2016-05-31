@bowling
Feature:
  As a system
  I should be able to provide the score of a bowling game

  #todo: through API??

  Scenario: Request bowling game score
    Given I have the following sheet:
      |X |3/|7 |
    Then the score should be 44

