<?php
/**
 * Block types registration Tests
 *
 * @package Gutenberg
 */

/**
 * Test register_block_type(), unregister_block_type(), get_dynamic_block_names()
 */
class Registration_Test extends WP_UnitTestCase {

	function render_stub() {}

	function tearDown() {
		parent::tearDown();

		foreach ( WP_Block_Type_Registry::get_instance()->get_all_registered() as $name => $block_type ) {
			WP_Block_Type_Registry::get_instance()->unregister( $name );
		}
	}

	function test_register_affects_main_registry() {
		$name     = 'core/paragraph';
		$settings = array(
			'icon' => 'text',
		);

		register_block_type( $name, $settings );

		$this->assertTrue( WP_Block_Type_Registry::get_instance()->is_registered( $name ) );
	}

	function test_unregister_affects_main_registry() {
		$name     = 'core/paragraph';
		$settings = array(
			'icon' => 'text',
		);

		register_block_type( $name, $settings );
		unregister_block_type( $name );

		$this->assertFalse( WP_Block_Type_Registry::get_instance()->is_registered( $name ) );
	}

	function test_get_dynamic_block_names() {
		register_block_type( 'core/paragraph', array() );
		register_block_type( 'core/dynamic', array( 'render_callback' => array( $this, 'render_stub' ) ) );

		$dynamic_block_names = get_dynamic_block_names();

		$this->assertSame( array( 'core/dynamic' ), $dynamic_block_names );
	}
}
