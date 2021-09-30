<?php

/**
 *	@author Félix Girault <felix.girault@gmail.com>
 *	@license FreeBSD License (http://opensource.org/licenses/BSD-2-Clause)
 */

namespace fg\Essence\Provider\OEmbed;

if ( !defined( 'ESSENCE_BOOTSTRAPPED')) {
	require_once dirname( dirname( dirname( dirname( dirname( __FILE__ )))))
		. DIRECTORY_SEPARATOR . 'bootstrap.php';
}



/**
 *	Test case for Gists
 */

class GistTest extends \PHPUnit_Framework_TestCase {

	public $Gist = null;

	public function setUp( ) {

		$this->Gist = new Gist( );
		$Reflection = new \ReflectionClass( '\\fg\\Essence\\Provider\\OEmbed\\Gist' );

		$Property = $Reflection->getProperty( '_endpoint' );
		$Property->setAccessible( true );
		$Property->setValue( $this->Gist, 'file://' . ESSENCE_HTTP . '%s.json' );
	}

   public function testCanEmbed() {
		$this->assertTrue( $this->Gist->canEmbed( 'https://gist.github.com/4115220' ));
   }

	public function testCantEmbed( ) {
		$this->assertFalse( $this->Gist->canEmbed( 'https://gist.github.cm/4115220' ));
		$this->assertFalse( $this->Gist->canEmbed( 'http://www.youtube.com/watch?v=HgKXN_Uw2ME' ));
	}

	public function testPrepare( ) {

		$Media = $this->Gist->embed( 'https://gist.github.com/4115220' );

		$this->assertEquals( 'https://gist.github.com/4115220', $Media->url );
		$this->assertEquals( '592', $Media->width );
		$this->assertEquals( '444', $Media->height );
	}

	public function testPrepareAlreadyPrepared( ) {

		$Media = $this->Gist->embed( 'https://gist.github.com/4115220.json' );

		$this->assertEquals( 'https://gist.github.com/4115220', $Media->url );
		$this->assertEquals( '592', $Media->width );
		$this->assertEquals( '444', $Media->height );
	}

   public function testEmbed() {

      $Media = $this->Gist->embed( 'https://gist.github.com/4115220' );

      $this->assertEquals(
         "GET /guide/{guideid}/steps response",
         $Media->description
      );
   }
}
