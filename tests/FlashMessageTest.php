<?php

namespace Qanna\Tests;

use function PHPUnit\Framework\assertTrue;
use PHPUnit\Framework\Attributes\Test;

class FlashMessageTest extends TestCase {

	#[Test]
	public function can_flash_and_clear_message() {
		$key = 'test';
		$value = 'success';

		$this->session->flash($key, $value);
		$retrievedFlash = $this->session->getFlash($key);

		$this->assertEquals($value, $retrievedFlash);
		$this->assertFalse((bool) $this->session->getFlash($key));
	}

	#[Test]
	public function preserves_flash_data_for_the_next_request() {
		$this->session->flash('username', 'example');
		$this->session->flash('email', 'example@domain.com');

		$this->session->reflash();
		$retrievedUsername = $this->session->getFlash('username');
		$retrievedEmail = $this->session->getFlash('email');

		$this->assertEquals('example', $retrievedUsername);
		$this->assertEquals('example@domain.com', $retrievedEmail);

		$this->assertTrue($this->session->has('_flash.username'));
		$this->assertTrue($this->session->has('_flash.email'));
	}

	#[Test]
	public function preserves_specified_data_for_the_next_request() {
		$this->session->flash('username', 'example');
		$this->session->flash('email', 'example@domain.com');

		$this->session->reflash(['email']);
		$retrievedEmail = $this->session->getFlash('email');
		$retrievedUsername = $this->session->getFlash('username');

		$this->assertEquals('example', $retrievedUsername);
		$this->assertEquals('example@domain.com', $retrievedEmail);

		$this->assertFalse($this->session->has('_flash.username'));
		$this->assertTrue($this->session->has('_flash.email'));
	}

}