Feature: Provide Kittes data
In order to provide an API
I should provide Kitties Data:

Scenario: Get kitties as Anon
Given I have no Authtentication Token
When I browse /api/kitties
Then I should have Kitty
But only id and Name

Scenario: Get Kitties as logged
Given I have an Authtentication Token
When I browse /api/kitties
Then I should have Kitty

Scenario: Get one kitty as anon
Given I have no Authtentication Token
When I browse /api/kitties/1
Then I shall have a 401 error

Scenario: Get one kitty as logged
Given I have an Authtentication Token
When I browse /api/kitties/1
Then I should have a Kitty

Scenario: Get A non-existant Kitty
Given I have an Authtentication Token
When I browse /api/kitties/0
Then I shall have a http not found error