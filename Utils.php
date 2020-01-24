<?php
namespace Mezon\Router;

/**
 * Class Utils
 *
 * @package Router
 * @subpackage Utils
 * @author Dodonov A.A.
 * @version v.1.0 (2020/01/17)
 * @copyright Copyright (c) 2020, aeon.org
 */

/**
 * Router utilities class
 */
class Utils
{

    /**
     * Converting method name to route
     *
     * @param string $methodName
     *            method name
     * @return string route
     */
    public static function convertMethodNameToRoute(string $methodName): string
    {
        $methodName = str_replace('action', '', $methodName);

        if (ctype_upper($methodName[0])) {
            $methodName[0] = strtolower($methodName[0]);
        }

        for ($i = 1; $i < strlen($methodName); $i ++) {
            if (ctype_upper($methodName[$i])) {
                $methodName = substr_replace($methodName, '-' . strtolower($methodName[$i]), $i, 1);
            }
        }

        return $methodName;
    }

    /**
     * Method prepares route for the next processing
     *
     * @param mixed $route
     *            Route
     * @return string Trimmed route
     */
    public static function prepareRoute($route): string
    {
        if (is_array($route) && $route[0] === '') {
            $route = $_SERVER['REQUEST_URI'];
        }

        if ($route == '/') {
            $route = '/index/';
        }

        if (is_array($route)) {
            $route = implode('/', $route);
        }

        return '/' . trim($route, '/') . '/';
    }

    /**
     * Method compiles callable description
     *
     * @param mixed $processor
     *            Object to be descripted
     * @return string Description
     */
    public static function getCallableDescription($processor): string
    {
        if (is_string($processor)) {
            return $processor;
        } elseif (is_object($processor[0])) {
            return get_class($processor[0]) . '::' . $processor[1];
        } else {
            return $processor[0] . '::' . $processor[1];
        }
    }
    
    /**
     * Method detects if the $string is a parameter or a static component of the route
     *
     * @param string $string
     *            String to be validated
     * @return bool Does we have parameter
     */
    public static function isParameter($string): bool
    {
        return $string[0] == '[' && $string[strlen($string) - 1] == ']';
    }
}