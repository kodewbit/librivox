<?php

namespace Kodewbit\LibriVox\Traits;

trait Helpers
{
    /**
     * Loop through an array recursively and remove a specific key.
     *
     * @param $array
     * @param $unwantedKey
     * @return array|false
     */
    public function recursiveUnset(array &$array, $unwantedKey)
    {
        if (!is_array($array) || empty($unwantedKey)) {
            return false;
        }

        if (is_array($unwantedKey)) {
            foreach ($unwantedKey as $key) {
                unset($array[$key]);
            }
        } else {
            unset($array[$unwantedKey]);
        }

        foreach ($array as &$value) {
            if (is_array($value)) {
                call_user_func_array([$this, __FUNCTION__], [&$value, $unwantedKey]);
            }
        }

        return $array;
    }
}
