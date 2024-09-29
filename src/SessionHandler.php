<?php

namespace Qanna\SessionBag;

class SessionHandler {

	protected const SESSION_CREATED_AT = '_created_at';

	protected bool $isOpened = false;

	/**
	 * Regenerate the session id
	 * @return bool
	 */
	protected function regenerate(): bool {
		return session_regenerate_id(true);
	}

	/**
	 * Checks if the session has started
	 * @return bool
	 */
	protected function isOpened(): bool {
		return $this->isOpened = session_status() === PHP_SESSION_ACTIVE;
	}

	/**
	 * Starts the session
	 * @return bool
	 */
	protected function open(): bool {

		if ($this->isOpened()) {
			return true;
		}

		session_start();
		return true;
	}

	/**
	 * Write to the session
	 * @param string $key
	 * $param mixed $value
	 * @return mixed
	 */
	protected function write(string $key, $value = null): mixed {
		$keys = explode('.', $key);
		$session = &$_SESSION;

		foreach ($keys as $key) {
			if (!isset($session[$key])) {
				$session[$key] = [];
			}

			$session = &$session[$key];
		}
		$session = $value;
		return $value;
	}

	/**
	 * Reads from the session
	 * @param string $key
	 * @param string $default [optional] To be returned if the session returns null
	 * @return mixed
	 */
	protected function read($key, $default = null): mixed {
		$keys = explode('.', $key);
		$session = $_SESSION;

		foreach ($keys as $key) {
			if (!isset($session[$key])) {
				return $default;
			}

			$session = $session[$key];
		}

		return $session;
	}

	/**
	 * Closes the session
	 * @return bool
	 */
	protected function close(): bool {
		$this->isOpened = false;
		return true;
	}

	/**
	 * Removes all or specified data from the session
	 * @param string $key [optional] Specify the key to remove from the session
	 */
	protected function destroy(string $key = null) {
		if (!$key) {
			session_unset();
			return session_destroy();
		}

		$keys = explode('.', $key);
		$session = &$_SESSION;

		foreach ($keys as $i => $key) {
			if (!isset($session[$key])) {
				return;
			}

			if ($i === count($keys) - 1) {
				unset($session[$key]);
				return;
			}

			$session = &$session[$key];
		}
		return true;
	}

}