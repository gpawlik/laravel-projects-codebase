<?php

include_once __DIR__."/../BaseTestCase.php";

class RoleBaseTestCase extends BaseTestCase
{
    protected $roleName = "System Admin";

	public function setUp()
    {
        parent::setup();
        \DB::table("roles")->wherE("role_name",$this -> roleName)->delete();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

     /***************** GENERAL FUNCTIONS *************************************************************/
	protected function clearData()
	{
		$allowanceNameTextField = $this->webDriver->findElement(WebDriverBy::name("role_name"));
		$allowanceNameTextField -> clear();
	}

}