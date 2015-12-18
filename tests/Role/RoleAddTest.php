<?php

include_once "RoleBaseTestCase.php";

class RoleAddTest extends RoleBaseTestCase
{
	public function setUp()
	{
		parent::setUp();

		$this -> clickElement("id","system");

		$this -> clickElement("id","role-sub-link");

		$this -> wait(1000);

		$this -> clickElement("id","add_role");
	}

	public function testAdd()
	{
		$this -> wait(1000);

		$this -> assertContains('Add Role', $this->webDriver->getTitle());

		$this -> insertDataIntoField("name","role_name",$this -> roleName);

		$this -> submitForm();

		$this->assertEquals(2,\DB::table("roles")->count());  
	}

	public function testBlankFields()
	{
		//click with empty data
		$this -> submitForm();

		$this -> assertEquals($this -> baseUrl."/system/roles/create",$this->webDriver->getCurrentURL());
		$this -> assertEquals(1, count($this->webDriver->findElement(WebDriverBy::className("error-box")) ) );	
	}
}