<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I have no Authtentication Token
     */
    public function iHaveNoAuthtenticationToken()
    {
        throw new PendingException();
    }

    /**
     * @When I browse \/api\/kitties
     */
    public function iBrowseApiKitties()
    {
        throw new PendingException();
    }

    /**
     * @Then I should have Kitty
     */
    public function iShouldHaveKitty()
    {
        throw new PendingException();
    }

    /**
     * @Then only id and Name
     */
    public function onlyIdAndName()
    {
        throw new PendingException();
    }

    /**
     * @Given I have an Authtentication Token
     */
    public function iHaveAnAuthtenticationToken()
    {
        throw new PendingException();
    }

    /**
     * @When I browse \/api\/kitties\/:arg1
     */
    public function iBrowseApiKitties2($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I shall have a :arg1 error
     */
    public function iShallHaveAError($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should have a Kitty
     */
    public function iShouldHaveAKitty()
    {
        throw new PendingException();
    }

    /**
     * @Then I shall have a http not found error
     */
    public function iShallHaveAHttpNotFoundError()
    {
        throw new PendingException();
    }

    /**
     * @When I make a POST Request to :arg1
     */
    public function iMakeAPostRequestTo($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When With bad informations
     */
    public function withBadInformations()
    {
        throw new PendingException();
    }

    /**
     * @When With good informations
     */
    public function withGoodInformations()
    {
        throw new PendingException();
    }

    /**
     * @Then I shall have a :arg1 status code
     */
    public function iShallHaveAStatusCode($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I Shall have the new kitty as response
     */
    public function iShallHaveTheNewKittyAsResponse()
    {
        throw new PendingException();
    }




}
