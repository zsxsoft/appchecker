<?php
namespace AppChecker;

class Utils
{

/**
 * Include file
 * @param string $path
 * @return bool
 */
    public static function includeFile($path)
    {
        global $zbp;
        if (is_readable($path)) {
            return require_once $path;
        } else {
            return false;
        }
    }
/**
 * Get Function Description
 */
    public static function getFunctionDescription($function)
    {
        try {
            return new \ReflectionFunction($function);
        } catch (\ReflectionException $e) {
            echo $e->getMessage();

            return false;
        }
    }
/**
 * Extracts all global variables as references and includes the file.
 * Useful for including legacy plugins.
 *
 * @param string $__filename__ File to include
 * @param array  $__vars__     Extra variables to extract into local scope
 * @throws Exception
 * @return void
 */
    public static function globalInclude($__filename__, &$__vars__ = null)
    {
        if (!is_file($__filename__)) {
            throw new Exception('File ' . $__filename__ . ' does not exist');
        }

        extract($GLOBALS, EXTR_REFS | EXTR_SKIP);
        if ($__vars__ !== null) {
            extract($__vars__, EXTR_REFS);
        }

        unset($__vars__);
        include $__filename__;
        unset($__filename__);
        foreach (array_diff_key(get_defined_vars(), $GLOBALS) as $key => $val) {
            $GLOBALS[$key] = $val;
        }
    }

    public static function scanDirectory($path, $recursive = true, $returnType = "getPathName")
    {
        $ret = [];

        if ($recursive) {
            $dir = new \RecursiveDirectoryIterator($path);
            $iterator = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::SELF_FIRST);
        } else {
            $iterator = new \DirectoryIterator($path);
        }

        foreach ($iterator as $name => $object) {
            $fileName = $object->getFilename();
            if ($fileName == "." || $fileName == "..") {
                continue;
            }

            if (!$object->isDir()) {
                array_push($ret, $object->$returnType());
            }
        }

        return $ret;
    }

    public static function checkCanBeString($obj)
    {
        return $obj === null || is_scalar($obj) || is_callable([$obj, '__toString']);
    }
}
