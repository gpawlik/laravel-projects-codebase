<?php

include_once "PermissionBaseTestCase.php";

class PermissionAddTest extends PermissionBaseTestCase
{
	public function setUp()
	{
		parent::setUp();

		$this -> clickElement("id","system");

		$this -> clickElement("id","permission-sub-link");

		$this -> wait(1000);

		$this -> clickElement("id","add_permission");
	}

	public function testAdd()
	{
		$this -> wait(1000);

		$this -> assertContains('Add Permission', $this->webDriver->getTitle());

		$this -> insertDataIntoField("name","permission_name",$this -> permission);

		$this -> submitForm();

		$this->assertEquals(1,\DB::table("permissions")->where("permission_name","system_test_can_add")->count());  
	}

	public function testBlankFields()
	{
		//click with empty data
		$this -> submitForm();

		$this -> assertEquals($this -> baseUrl."/system/permissions/create",$this->webDriver->getCurrentURL());
		$this -> assertEquals(1, count($this->webDriver->findElement(WebDriverBy::className("error-box")) ) );	
	}
}