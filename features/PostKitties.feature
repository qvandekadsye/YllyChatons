Feature: Allow posting new Kitty
  In order to have more kitties

Scenario: Post kitty as anon
  Given I have no Authtentication Token
  When I make a POST Request to "/api/kitties"
  Then I shall have a 401 error

Scenario: Post Kitty as Logged with bad informations
  Given I have an Authtentication Token
  When I make a POST Request to "/api/kitties"
  But  With bad informations
  Then I shall have a 400 error

Scenario: Post Kitty as Logged with good informations
  Given I have an Authtentication Token
  When I make a POST Request to "/api/kitties"
  But  With good informations
  Then I shall have a 201 status code
  Then I Shall have the new kitty as response
