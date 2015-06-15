<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends \Behat\MinkExtension\Context\MinkContext implements Context, SnippetAcceptingContext
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
     * @Given /^there are no organizations$/
     */
    public function thereAreNoOrganizations()
    {
        $config = new \Doctrine\DBAL\Configuration();
        $connectionParams = \Wibbo\Db\DbConfiguration::generate('');
        $conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
        $conn->delete("organizations", [1 => 1]);
    }

    /**
     * @When /^I add an organization named "([^"]*)"$/
     */
    public function iAddAnOrganizationNamed($organizationName)
    {
        $this->getSession()->visit('http://127.0.0.1:8081/admin');
        $page = $this->getSession()->getPage();
        var_dump($this->getSession()->getPage()->findById('OrganizationName'));
        $this->spin(function($context) {
            return $context->getSession()->getPage()->findById('OrganizationName') != null;
        });
        $page->fillField('OrganizationName', 'Abaco');
        $page->find('css', '#OrganizationAdd')
          ->click();
    }

    /**
     * @Then /^I should see the organization "([^"]*)" in homepage$/
     */
    public function iShouldSeeTheOrganizationInHomepage($arg1)
    {

    }

    private function spin ($lambda)
    {
        while (true)
        {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                // do nothing
            }

            sleep(1);
        }
    }
}
