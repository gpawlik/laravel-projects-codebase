<?php

use Illuminate\Foundation\Testing\TestCase;

class BaseTestCase extends TestCase
{
	protected $webDriver;
    protected $app;
    protected $baseUrl = 'http://localhost:8000';

	public function setUp()
    {
        $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        $this->webDriver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);

        $this -> app = self::createApplication();

        //log user in
        $this->webDriver->get($this -> baseUrl);

        $usernameField = $this->webDriver->findElement(WebDriverBy::name("username"));
        $usernameField -> sendKeys("superuser");

        $passwordField = $this->webDriver->findElement(WebDriverBy::name("password"));
        $passwordField -> sendKeys("mala");

        $loginBtn = $this->webDriver->findElement(WebDriverBy::id("login-btn"));
        $loginBtn -> click();

        $this->webDriver->manage()->timeouts()->implicitlyWait(1000);
    }

    public function tearDown()
    {
        $this->webDriver->close();
    }

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function clickElement($elementIdentifier,$elementName)
    {
        $element = $this->webDriver->findElement(WebDriverBy::{$elementIdentifier}($elementName));
        $element -> click();
    }

    protected function clickElementByCssSelector($selector)
    {
        $element = $this -> webDriver -> findElement(WebDriverBy::cssSelector($selector));// clickElement("className","fa-money");
        $element -> click();
    }

    protected function insertDataIntoField($elementIdentifier,$elementName,$data)
    {
        $element = $this->webDriver->findElement(WebDriverBy::{$elementIdentifier}($elementName));
        $element -> clear();
        $element -> sendKeys($data);
    }

    protected function wait($time)
    {
        $this->webDriver->manage()->timeouts()->implicitlyWait($time);
    }

    protected function uploadFile($elementIdentifier,$elementName,$filePath)
    {
        $fileInput = $this->webDriver->findElement(WebDriverBy::{$elementIdentifier}($elementName));
        $fileInput->setFileDetector(new LocalFileDetector());
        $fileInput -> sendKeys($filePath);
    }

    protected function getDBProperty($tableName,$propertyName)
    {
        return \DB::table($tableName)->first()->{$propertyName};
    }

    protected function submitForm()
    {
        $submitBtn = $this->webDriver->findElement(WebDriverBy::className("submit-button"));
        $submitBtn -> click();
    }

}