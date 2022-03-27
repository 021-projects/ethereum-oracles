<?php

if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value, ...$args)
    {
        return $value instanceof Closure ? $value(...$args) : $value;
    }
}

if (! function_exists('weak_map_keys')) {
    /**
     * Return keys of a WeakMap class.
     *
     * @param  \WeakMap  $map
     * @return array
     */
    function weak_map_keys(WeakMap $map): array
    {
        $keys = [];

        foreach ($map as $key => $v) {
            $keys[] = $key;
        }

        return $keys;
    }
}