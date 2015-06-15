Feature: Organization
  In order to show the status of different systems
  As a developer
  I want to separate incident by organization

  Scenario: Add first organization
    Given there are no organizations
    And I add an organization named "ABC"
    Then I should see the organization "ABC" in homepage