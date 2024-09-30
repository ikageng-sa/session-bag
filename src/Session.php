<?php

namespace Qanna\SessionBag;

class Session extends SessionHandler {

	protected const SESSION_FLASH = '_flash';

	protected bool | array $reflash = false;

	/**
	 * Starts the session
	 * @return bool
	 */
	public function start(): bool {
		return $this->open();
	}

	/**
	 * Checks if the session has a key
	 *
	 * @param string $key Key of the session you are searching
	 * @return bool
	 */
	public function has(string $key): bool {
		return (bool) $this->read($key, null);
	}

	/**
	 * Adds a key => value to the sesion
	 *
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function push(string $key, $value = null): mixed {
		return $this->write($key, $value);
	}

	/**
	 * Gets the value of a session key, or defaults
	 *
	 * @param string $key
	 * @param mixed $default [optional] The default value that should be
	 * returned if no key was found
	 *
	 * @return mixed
	 */
	public function get(string $key, $default = null): mixed {
		return $this->read($key, $default);
	}

	/**
	 * Remove the value of a specific key from the session
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function forget(string $key) {
		return $this->destroy($key);
	}

	/**
	 * Saves a message that to flash once
	 *
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function flash(string $key, $value): mixed {
		$key = self::SESSION_FLASH . ".$key";
		return $this->push($key, $value);
	}

	/**
	 * Gets a flash message once and delete it
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function getFlash($key): mixed {
		$key = self::SESSION_FLASH . ".$key";
		$value = $this->get($key, null);
		$searchKey = trim(strrchr($key, '.'), '.'); // Get the substring after the last occurence of '.'

		if ($value !== null && ($this->reflash === false || (is_array($this->reflash) && !in_array($searchKey, $this->reflash)))) {
			$this->forget($key);
		}

		return $value;
	}

	/**
	 * Prevent flash message from being deleted once flashed
	 *
	 * @param array $keys [optional]
	 * @return mixed
	 */
	public function reflash(array $keys = []) {
		if (!empty($keys)) {
			$this->reflash = $keys;
		} else {
			$this->reflash = true;
		}

		return $this->reflash;
	}

	/**
	 * Remove all the data from the session
	 *
	 * @return mixed
	 */
	public function flush(): mixed {
		return $this->destroy();
	}
}