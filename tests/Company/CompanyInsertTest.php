<?php

include_once "CompanyBaseTestCase.php";

class CompanyInsertTest extends CompanyBaseTestCase
{
	public function setUp()
	{
		parent::setUp();

		$logoImagePath = "test_images/logo.jpg";

		$this -> insertDataIntoField("name","company_name","E-Transactions Limited");
		$this -> insertDataIntoField("name","company_description","The best and latest electronic transaction service company in the country");
		$this -> insertDataIntoField("name","company_address","Aleye street, Osu, Accra");
		$this -> insertDataIntoField("name","company_telephone","0309220033");
		$this -> insertDataIntoField("name","company_tin_number","T2233949596954");
		$this -> insertDataIntoField("name","company_ssnit_number","SSN00222939394");
		$this -> insertDataIntoField("name","company_email","info@e-transations.com");
		$this -> insertDataIntoField("name","company_website","www.et.com.gh");	
		$this -> uploadFile("id","company_logo_name",$logoImagePath);

		$this -> submitForm();
	}

	public function testAssertionsForInsert()
	{
		$this -> assertEquals("E-Transactions Limited", $this -> getDBProperty("company","company_name") );
		$this -> assertEquals("The best and latest electronic transaction service company in the country", $this -> getDBProperty("company","company_description") );
		$this -> assertEquals("Aleye street, Osu, Accra", $this -> getDBProperty("company","company_address") );
		$this -> assertEquals("0309220033", $this -> getDBProperty("company","company_telephone") );
		$this -> assertEquals("T2233949596954", $this -> getDBProperty("company","company_tin_number") );
		$this -> assertEquals("SSN00222939394", $this -> getDBProperty("company","company_ssnit_number") );
		$this -> assertEquals("info@e-transations.com", $this -> getDBProperty("company","company_email") );
		$this -> assertEquals("www.et.com.gh", $this -> getDBProperty("company","company_website") );

		$logoName = $this -> getDBProperty("company","company_logo_name");
		
		$this -> assertTrue($this -> uploadFileExists($logoName));
	}

	public function testEditCompanyData()
	{
		$this -> clearData();

		$this -> insertDataIntoField("name","company_name","Growth Mosaic");
		$this -> insertDataIntoField("name","company_description","Premier Investment Bank in Ghana");
		$this -> insertDataIntoField("name","company_address","Oyele Cl, Osu, Accra");
		$this -> insertDataIntoField("name","company_telephone","030449932");
		$this -> insertDataIntoField("name","company_tin_number","TIN44499958583");
		$this -> insertDataIntoField("name","company_ssnit_number","SSN2299938483");
		$this -> insertDataIntoField("name","company_email","info@growthmosaic.com");
		$this -> insertDataIntoField("name","company_website","www.growthmosaic.com");

		$this -> submitForm();

		$this -> assertEquals("Growth Mosaic", $this -> getDBProperty("company","company_name") );
		$this -> assertEquals("Premier Investment Bank in Ghana", $this -> getDBProperty("company","company_description") );
		$this -> assertEquals("Oyele Cl, Osu, Accra", $this -> getDBProperty("company","company_address") );
		$this -> assertEquals("030449932", $this -> getDBProperty("company","company_telephone") );
		$this -> assertEquals("TIN44499958583", $this -> getDBProperty("company","company_tin_number") );
		$this -> assertEquals("SSN2299938483", $this -> getDBProperty("company","company_ssnit_number") );
		$this -> assertEquals("info@growthmosaic.com", $this -> getDBProperty("company","company_email") );
		$this -> assertEquals("www.growthmosaic.com", $this -> getDBProperty("company","company_website") );
	}

	public function testClearImage()
	{
		$originalLogoName = $this -> getDBProperty("company","company_logo_name");

		$this -> clickElement("name","clear_check");
		$this -> submitForm();

		$this -> assertNull($this -> getDBProperty("company","company_logo_name"));
		$this -> assertFalse($this -> uploadFileExists($originalLogoName));
	}

	public function testUploadNewImage()
	{
		$newImage = "test_images/user_image.jpg";
		$this -> uploadFile("id","company_logo_name",$newImage);

		$this -> submitForm();

		$logoName = $this -> getDBProperty("company","company_logo_name");
		
		$this -> assertTrue($this -> uploadFileExists($logoName));
	}

	public function testEmptyField()
	{
		$this -> clearData();

		$this -> submitForm();

		$this -> assertEquals($this -> baseUrl."/system/company",$this->webDriver->getCurrentURL());
		$this -> assertEquals(1, count($this->webDriver->findElement(WebDriverBy::className("error-box")) ) );	
	}

	private function uploadFileExists($fileName)
	{
		$fileExists = file_exists(public_path("uploads/".$fileName));

		return $fileExists;
	}
}