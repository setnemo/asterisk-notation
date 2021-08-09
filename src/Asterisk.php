<?php

/**
 * Asterisk is provide PHP asterisk notation access to arrays
 * @author  Artem Pakhomov <setnemo@gmail.com>
 * @link    https://github.com/setnemo/asterisk-notation
 * @license https://github.com/setnemo/asterisk-notation/blob/main/LICENSE (MIT License)
 *
 * Extends Dot Notation
 * @author  Riku Särkinen <riku@adbar.io>
 * @link    https://github.com/adbario/php-dot-notation
 * @license https://github.com/adbario/php-dot-notation/blob/2.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Setnemo;

use Adbar\Dot;

class Asterisk extends Dot
{
    /**
     * Set a given key / value pair or pairs
     * if the key doesn't exist already
     *
     * @param array|int|string $keys
     * @param mixed            $value
     */
    public function add($keys, $value = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->add($key, $value);
            }
        } elseif (is_null($this->get($keys, null, false))) {
            $this->set($keys, $value, false);
        }
    }

    /**
     * Delete the contents of a given key or keys
     *
     * @param array|int|string|null $keys
     * @param bool $asterisk
     */
    public function clear($keys = null, bool $asterisk = true): void
    {
        if (is_null($keys)) {
            $this->items = [];

            return;
        }
        $keys = (array) $keys;
        foreach ($keys as $key) {
            $this->set($key, [], $asterisk);
        }
    }

    /**
     * Delete the given key or keys
     *
     * @param array|int|string $keys
     */
    public function delete($keys)
    {
        $keys = (array) $keys;
        $affectedKeys = $this->getAffectedAndFilterKeys($keys);

        parent::delete(array_merge($keys, $affectedKeys));
    }

    /**
     * Return the value of a given key
     * with star - all keys as array ['key.with.dot' => 'value']
     *
     * @param int|string|null $key
     * @param mixed $default
     * @param bool $asterisk
     * @return mixed
     */
    public function get($key = null, $default = null, bool $asterisk = true)
    {
        if (false === $asterisk || is_null($key) || !$this->keyHasStars($key)) {
            return parent::get($key, $default);
        }

        return $this->getStarsAffectedKeys($key);
    }

    /**
     * Check if a given key or keys exists
     * Also compare values with strict mode (default)
     *
     * @param array|int|string $keys
     * @param null $value
     * @param bool $strict
     * @return bool
     */
    public function has($keys, $value = null, bool $strict = true): bool
    {
        $keys = (array) $keys;
        if (!$this->items || $keys === []) {
            return false;
        }

        $affectedKeys = $this->getAffectedAndFilterKeys($keys);

        if (null !== $value) {
            return $this->hasValueAndStrict(array_merge($affectedKeys, $keys), $value, $strict);
        }

        return (bool) (!empty($affectedKeys) | parent::has($keys));
    }

    /**
     * Set a given key / value pair or pairs
     *
     * @param array|int|string $keys
     * @param mixed            $value
     */
    public function set($keys, $value = null, bool $asterisk = true)
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->set($key, $value, $asterisk);
            }
            return;
        }
        if ($asterisk && $this->keyHasStars($keys)) {
            $affectedKeys = $this->prepareStarsAffectedKeys($keys, $value);
            $this->set($affectedKeys, [], false);
            return;
        }
        $items = &$this->items;
        foreach (explode('.', (string) $keys) as $key) {
            if (!isset($items[$key]) || !is_array($items[$key])) {
                $items[$key] = [];
            }

            $items = &$items[$key];
        }
        $items = $value;
    }

    /**
     * @param string $asteriskKey
     * @param $value
     * @return array
     */
    protected function prepareStarsAffectedKeys(string $asteriskKey, $value): array
    {
        $keys = $this->getStarsAffectedKeys($asteriskKey);
        if ($this->isEmpty() && empty($keys)) {
            return [$asteriskKey => $value];
        }

        foreach ($keys as $key => $v) {
            $keys[$key] = $value;
        }

        return $keys;
    }

    /**
     * @param array $keys
     * @return array
     */
    protected function getAffectedAndFilterKeys(array &$keys): array
    {
        $affectedKeys = [];
        foreach ($keys as $it => $key) {
            if ($this->keyHasStars($key)) {
                $affectedKeys = array_merge($affectedKeys, $this->getStarsAffectedKeys($key, false) ?? []);

                unset($keys[$it]);
            }
        }

        return $affectedKeys;
    }

    /**
     * @param string $asteriskKey
     * @param bool $withValues
     * @return array|null
     */
    protected function getStarsAffectedKeys(string $asteriskKey, bool $withValues = true): ?array
    {
        $keys = $this->flatten();
        $result = [];
        $pattern = '/' . strtr($asteriskKey, ['*' => '[^\.]+']) . '/';
        foreach ($keys as $key => $v) {
            $matches = [];
            preg_match_all($pattern, "$key", $matches);
            $matchResult = $matches[0][0] ?? [];
            if (!empty($matchResult) || $matchResult === "0") {
                $result = array_merge($result, $withValues ? [$matchResult => $v] : [$matchResult]);
            }
        }

        return empty($result) ? null : $result;
    }

    /**
     * @param array $keys
     * @param $value
     * @param bool $strict
     * @return bool
     */
    protected function hasValueAndStrict(
        array $keys,
        $value,
        bool $strict
    ): bool {
        $nonStrictResult = 0;

        foreach ($keys as $key) {
            if ($value !== $this->get($key, null, false)) {
                if (false === $strict) {
                    $nonStrictResult++;
                    continue;
                }
                return false;
            }
        }

        if (!$strict) {
            return $nonStrictResult !== count($keys);
        }

        return true;
    }

    /**
     * @param $keys
     * @return bool
     */
    protected function keyHasStars($keys): bool
    {
        $counter = array_count_values(explode('.', (string) $keys) ?? []);

        return (bool) ($counter['*'] ?? 0);
    }
}
