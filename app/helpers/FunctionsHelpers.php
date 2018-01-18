<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 22.12.17
 * Time: 11:14
 */

namespace Zvinger\BaseClasses\app\helpers;

class FunctionsHelpers
{
    /**
     * @param bool $var
     * @param bool $showHtml
     * @param bool $showFrom
     * @param bool $overDebug
     * @return bool
     */
    public static function DebugObject($var = FALSE, $showHtml = FALSE, $showFrom = TRUE, $overDebug = FALSE, $calledFrom = NULL)
    {
        $PROJECT_DEBUG = YII_DEBUG || YII_ENV_TEST;
        $IS_CONSOLE = (php_sapi_name() == 'cli') ? TRUE : FALSE;
        if (!$PROJECT_DEBUG && !$overDebug) {
            return FALSE;
        }
        if (!$IS_CONSOLE) {
            echo '<div class="debug">';
        } else {
            echo "::::DEBUG:::: ";
        }
        if ($showFrom) {
            $calledFrom = $calledFrom ?: debug_backtrace();
            if (!$IS_CONSOLE) {
                echo '<strong>';
            }
            echo $calledFrom[0]['file'];
            if (!$IS_CONSOLE) {
                echo '</strong>';
            }
            echo ' (line ';
            if (!$IS_CONSOLE) {
                echo '<strong>';
            }
            echo $calledFrom[0]['line'];
            if (!$IS_CONSOLE) {
                echo '</strong>';
            }
            echo ')';
        }
        if (!$IS_CONSOLE) {
            echo "\n<pre class=\"debug\">\n";
        } else {
            echo PHP_EOL;
        }

        $var = print_r($var, TRUE);
        if ($showHtml) {
            $var = str_replace('<', '&lt;', str_replace('>', '&gt;', $var));
        }
        echo $var;
        if (!$IS_CONSOLE) {
            echo "\n</pre></div>\n\n";
        } else {
            echo PHP_EOL;
        }
    }

    public static function GetEnvironment($key, $default = FALSE)
    {
        $value = getenv($key);
        if ($value === FALSE) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return TRUE;

            case 'false':
            case '(false)':
                return FALSE;
        }

        return $value;
    }

    public static function MbCutString($str, $length, $postfix = '...', $encoding = 'UTF-8')
    {
        if (mb_strlen($str, $encoding) <= $length) {
            return strip_tags($str);
        }

        $tmp = mb_substr($str, 0, $length, $encoding);

        return strip_tags(mb_substr($tmp, 0, mb_strripos($tmp, ' ', 0, $encoding), $encoding) . $postfix);
    }

    public static function checkKeyedData($data, array $keys)
    {
        $result = TRUE;
        $array = (array)$data;
        foreach ($keys as $key) {
            if (!isset($array[$key])) {
                $result = $key;
                break;
            }
        }

        return $result;
    }
}