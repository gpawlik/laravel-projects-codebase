<?php

include_once __DIR__."/../BaseTestCase.php";

class PermissionBaseTestCase extends BaseTestCase
{
    protected $permission = "system_test_can_add";

	public function setUp()
    {
        parent::setup();
    }

    public function tearDown()
    {
        parent::tearDown();
        \DB::table("permissions")->where("permission_name",$this -> permission)->delete();
    }

     /***************** GENERAL FUNCTIONS *************************************************************/
	protected function clearData()
	{
		$allowanceNameTextField = $this->webDriver->findElement(WebDriverBy::name("permission_name"));
		$allowanceNameTextField -> clear();
	}
}