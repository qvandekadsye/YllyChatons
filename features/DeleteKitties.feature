Feature: Allow deleting  Kitty
  In order to have less kitties

Scenario: Delete kitty as anon
  Given I have no Authtentication Token
  When I make a DELETE Request to "/api/kitties"
  Then I shall have a 401 error

Scenario: Delete Kitty as Logged with bad ID
  Given I have an Authtentication Token
  When I make a Delete Request to "/api/kitties/0"
  Then I shall have a 404 error

Scenario: Delete Kitty as Logged with good ID
  Given I have an Authtentication Token
  When I make a Delete Request to "/api/kitties/" "id"
  Then I shall have a 204 response and the previous kitty should not exists