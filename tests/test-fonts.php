<?php

class Wroter_Test_Fonts extends WP_UnitTestCase {

	public function test_getAllFonts() {
		$this->assertNotEmpty( \Wroter\Fonts::get_fonts() );
	}

	public function test_getFontType() {
		$this->assertEquals( 'system', \Wroter\Fonts::get_font_type( 'Arial' ) );
		$this->assertFalse( \Wroter\Fonts::get_font_type( 'NotFoundThisFont' ) );
	}

	public function test_getFontByGroups() {
		$this->assertArrayHasKey( 'Arial', \Wroter\Fonts::get_fonts_by_groups( [ 'system' ] ) );
		$this->assertArrayNotHasKey( 'Arial', \Wroter\Fonts::get_fonts_by_groups( [ 'googlefonts' ] ) );
	}
}
