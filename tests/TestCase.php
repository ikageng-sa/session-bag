<?php

namespace Qanna\SessionBag\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase as FrameworkTestCase;
use Qanna\SessionBag\Session;

class TestCase extends FrameworkTestCase {

	protected ?Session $session;

	protected function setUp(): void {
		$this->session = new Session();
		$this->session->start();
	}

	protected function tearDown(): void {
		$this->session = null;
	}

	#[Test]
	public function initial_test() {
		$this->assertTrue($this->session->start());
	}
}