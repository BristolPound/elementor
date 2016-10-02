<?php

class Wroter_Test_Settings extends WP_UnitTestCase {

	public function test_validationsCheckboxList() {
		$this->assertEquals( [], \Wroter\Settings_Validations::checkbox_list( null ) );
		$this->assertEquals( [ 'a', 'b' ], \Wroter\Settings_Validations::checkbox_list( [ 'a', 'b' ] ) );
	}
}
