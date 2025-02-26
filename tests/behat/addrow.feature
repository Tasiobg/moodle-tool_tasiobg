@tool @tool_tasiobg @javascript
Feature: Add a row to the table
  In order to add new courses
  As an admin
  I want to be able to add a new rows to the table

  Background:
    Given I log in as "admin"

  Scenario: I see the Add new row link
    When I visit "/admin/tool/tasiobg/index.php?id=1"
    And I click on "Add new row" "link"
    And I click on "Submit" "button"
    # Custom step definition for learning purposes
    Then I should see the new row "Pleasse enter a name"
