<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Pycubemi general helper functions
 *
 * @author krishna 3/20/2015
 * @copyright Pycube
 *
 */
if (!function_exists('contains')) {
    /**
     * Case insensitive contains.
     * This helper function is a case insensitive contains function that looks for a string within a string.
     *
     * @param string The string to look for the specified string in (haystack).
     * @param string The string you want to search for (needle).
     *
     * @return bool Returns true if the string is found and false otherwise.
     */
    function contains($haystack, $needle)
    {
        return !(stripos($haystack, $needle) === false);
    }
}
