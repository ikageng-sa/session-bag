<?php

namespace Qanna\SessionBag\Tests;

use PHPUnit\Framework\Attributes\Test;

class SessionTest extends TestCase {

	#[Test]
	public function can_push_data_into_session() {
		$value = 'john.mil';
		$this->session->push('username', $value);

		$this->assertTrue($this->session->has('username'));
		$this->assertEquals($value, $this->session->get('username'));
	}

	#[Test]
	public function can_get_data_from_session() {
		$this->session->push('user.username', 'john.mil');
		$this->session->push('user.email', 'john.mil@example.com');

		$this->assertNotEmpty($this->session->get('user'));
		$this->assertIsArray($this->session->get('user'));
		$this->assertEquals('john.mil', $this->session->get('user.username'));
	}

	#[Test]
	public function can_return_default_on_non_existent_key() {
		$default = 'This is a default value';
		$this->assertEquals($default, $this->session->get('bio', $default));
	}

	#[Test]
	public function can_forget_session_data() {
		$this->session->push('user.username', 'john.mil');
		$this->session->push('user.email', 'john.mil@example.com');

		$this->session->forget('user.username');

		$this->assertTrue($this->session->has('user.email'));
		$this->assertFalse($this->session->has('user.username'));
	}

	#[Test]
	public function can_flush_session_data() {
		$this->session->push('user.username', 'john.mil');
		$this->session->push('user.email', 'john.mil@example.com');

		$this->session->flush();

		$this->assertFalse($this->session->has('user'));
	}

}