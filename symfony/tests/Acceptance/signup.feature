Feature: signup
  In order to signup
  As a user
  I need to provide my details

  Scenario: signup successfully
    Given I am on the signup page
    When I fill in the form with dominic@example.com and password123
    And I submit the form
    Then I should see a success message
