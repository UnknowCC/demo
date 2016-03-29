<?php

namespace SScore;

use \ErrorException;

/**
 *
 */
class Error
{
    public static function exception($e)
    {
        if (DEBUG) {
            $errorMsg = <<<EOL
            <section class="error">
            <h1>Uncaught Exception</h1>
            <p><code>{$e->getMessage()}</code>
            <h3>Origin</h3>
            <p><code>{$e->getFile()}--on line--{$e->getLine()}</code></p>
            <h3>Trace</h3>
            <pre>{$e->getTraceAsString()}</pre>
            </section>
EOL;
        } else {
            static::log($e);
            $errorMsg = <<<EOL
            <section class="missing">
            <h2>Page missing</h2>
            <p>Wrong request,page missing! go <a href=ROOT>Home</a></p>
            </section>
EOL;
        }
        echo $errorMsg;
    }

    public static function native($code, $message, $file, $line, $context)
    {
        static::exception(new ErrorException($message, $code, 0, $file, $line));
    }

    public static function shutdown()
    {
        if ($error = error_get_last()) {
            extract($error);

            static::exception(new ErrorException($message, $type, 0, $file, $line));
        }
    }

    public static function log($e)
    {
        $data = array(
            'date' => date('Y-m-d H:i:s'),
            'message' => $e->getMessage(),
            'trace' => $e->getTrace(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        );
        file_put_contents(RUNTIME_PATH.'errors.log', json_encode($data)."\n", FILE_APPEND | LOCK_EX);
    }
}
