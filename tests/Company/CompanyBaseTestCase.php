<?php

include_once __DIR__."/../BaseTestCase.php";

class CompanyBaseTestCase extends BaseTestCase
{
	public function setUp()
    {
        parent::setUp();

        $this -> clickElement("id","system");

		$this -> clickElement("id","company-sub-link");

		$this-> wait(1000);
    }

    public function tearDown()
    {
        parent::tearDown();

        $this -> deleteUploadedImage();

        DB::statement('TRUNCATE company CASCADE');
    }

    /***************** GENERAL FUNCTIONS *************************************************************/
	protected function clearData()
	{
		$companyNameTextField = $this->webDriver->findElement(WebDriverBy::name("company_name"));
		$companyNameTextField -> clear();

		$companyDescTextField = $this->webDriver->findElement(WebDriverBy::name("company_description"));
		$companyDescTextField -> clear();

		$companyAddressTextField = $this->webDriver->findElement(WebDriverBy::name("company_address"));
		$companyAddressTextField -> clear();

		$companyTelephoneTextField = $this->webDriver->findElement(WebDriverBy::name("company_telephone"));
		$companyTelephoneTextField -> clear();

		$companyTinNoTextField = $this->webDriver->findElement(WebDriverBy::name("company_tin_number"));
		$companyTinNoTextField -> clear();

		$companySSNITNoTextField = $this->webDriver->findElement(WebDriverBy::name("company_ssnit_number"));
		$companySSNITNoTextField -> clear();

		$companyEmailTextField = $this->webDriver->findElement(WebDriverBy::name("company_email"));
		$companyEmailTextField -> clear();

		$companyWebsiteTextField = $this->webDriver->findElement(WebDriverBy::name("company_website"));
		$companyWebsiteTextField -> clear();
	}
	
	private function deleteUploadedImage()
	{
		$companyLogoImage = \DB::table("company")->first()->company_logo_name;

		if($companyLogoImage != null)
		{
			if(file_exists(public_path("uploads/".$companyLogoImage)))
			{
	        	unlink(public_path("uploads/".$companyLogoImage));
	        }
	    }
	}

}