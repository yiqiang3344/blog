<?php
/**
 * Created by PhpStorm.
 * User: sidney
 * Date: 2019/9/12
 * Time: 6:34 PM
 */

namespace base;


class View
{
    private $params;

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function __get($name)
    {
        return $this->params[$name] ?? null;
    }

    public function __isset($name)
    {
        return isset($this->params[$name]);
    }

    public function __unset($name)
    {
        if (isset($this->params[$name])) {
            $this->params[$name] = null;
        }
    }

    public function __construct($config = [])
    {
        foreach ($config as $k => $v) {
            $this->params[$k] = $v;
        }
    }

    public function render($file)
    {
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        try {
            require $file;
            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }
}