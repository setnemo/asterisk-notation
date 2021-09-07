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

use function PHPUnit\Framework\isNull;

/**
 * Asterisk is provide asterisk notation access to arrays
 *
 * @package Setnemo
 */
class Asterisk extends Dot
{
    /**
     * Set a given key / value pair or pairs
     * if the key doesn't exist already
     *
     * @param array|int|string $keys
     * @param mixed            $value
     */
    public function add($keys, $value = null): void
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
     * @param bool                  $asterisk
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
    public function delete($keys): void
    {
        $keys = (array) $keys;
        $affectedKeys = $this->getAffectedAndFilterKeys($keys);

        parent::delete(array_merge($keys, $affectedKeys));
    }

    /**
     * Return the value of a given key
     * with asterisk - all keys as array ['key.with.dot' => 'value']
     *
     * @param int|string|null $key
     * @param mixed           $default
     * @param bool            $asterisk
     * @return mixed
     */
    public function get($key = null, $default = null, bool $asterisk = true)
    {
        if (false === $asterisk || is_null($key) || !$this->keyHasAsterisk($key)) {
            return parent::get($key, $default);
        }

        return $this->getAffectedKeys((string) $key);
    }

    /**
     * Check if a given key or keys exists
     * Also compare values with strict mode (default)
     *
     * @param array|int|string $keys
     * @param null             $value
     * @param bool             $strict
     * @return bool
     */
    public function has($keys, $value = null, bool $strict = true): bool
    {
        $keys = (array) $keys;
        if (!$this->items || $keys === []) {
            return false;
        }

        $affectedKeys = $this->getAffectedAndFilterKeys($keys);

        if (!is_null($value)) {
            return $this->hasValueAndStrict(array_merge($affectedKeys, $keys), $value, $strict);
        }

        return (bool) ((int) !empty($affectedKeys) | (int) parent::has($keys));
    }

    /**
     * Set a given key / value pair or pairs
     * @param array|int|string $keys
     * @param mixed            $value
     * @param bool             $asterisk
     */
    public function set($keys, $value = null, bool $asterisk = true): void
    {
        if (is_array($keys)) {
            foreach ($keys as $key => $value) {
                $this->set($key, $value, $asterisk);
            }
            return;
        }
        if ($asterisk && $this->keyHasAsterisk($keys)) {
            $affectedKeys = $this->prepareAffectedKeys((string) $keys, $value);
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
     * @param array $keys
     * @param       $value
     * @param bool  $strict
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
     * Push a given value to the end of the array
     * in a given key
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function push($key, $value = null, bool $asterisk = true): void
    {
        $items = $this->get($key);
        if ($asterisk && $this->keyHasAsterisk($key)) {
            $items = $this->prepareAffectedKeys($key, $value);
            foreach ($items as $key => $item) {
                $changedItems = $this->get($key);
                $this->set($key, array_merge((array)$changedItems, (array)$value), false);
            }
        } elseif (is_array($items) || is_null($items)) {
            $items[] = $value ?? [];
            $this->set($key, $items, $asterisk);
        }
    }

    /**
     * @param array $keys
     * @return      array
     */
    protected function getAffectedAndFilterKeys(array &$keys): array
    {
        $affectedKeys = [];
        foreach ($keys as $it => $key) {
            if ($this->keyHasAsterisk($key)) {
                $affectedKeys = array_merge($affectedKeys, $this->getAffectedKeys($key, false) ?? []);

                unset($keys[$it]);
            }
        }

        return $affectedKeys;
    }

    /**
     * @param string $asteriskKey
     * @param bool   $withValues
     * @return array|null
     */
    protected function getAffectedKeys(string $asteriskKey, bool $withValues = true): ?array
    {
        $keys = $this->flatten();

        if ([] === $keys) {
            return null;
        }

        $result = [];
        $pattern = '/' . strtr($asteriskKey, ['*' => '[^\.]+']) . '/';
        foreach ($keys as $key => $v) {
            $matches = [];
            preg_match_all($pattern, "$key", $matches);
            $matchResult = $matches[0][0] ?? '';
            if (!empty($matchResult) || $matchResult === '0') {
                $result = array_merge($result, $withValues ? [$matchResult => $v] : [$matchResult]);
            }
        }

        return empty($result) ? null : $result;
    }

    /**
     * @param  $key
     * @return bool
     */
    protected function keyHasAsterisk($key): bool
    {
        $counter = array_count_values(explode('.', (string) $key) ?? []);

        return (bool) ($counter['*'] ?? 0);
    }

    /**
     * @param string $asteriskKey
     * @param        $value
     * @return array
     */
    protected function prepareAffectedKeys(string $asteriskKey, $value): array
    {
        $keys = $this->getAffectedKeys($asteriskKey);
        if ($this->isEmpty() && empty($keys)) {
            return [$asteriskKey => $value ?? []];
        }

        if (is_array($keys)) {
            foreach ($keys as $key => $v) {
                $keys[$key] = $value;
            }
        }

        return $keys;
    }
}
