<?php

function p($out_string, $immediate_output = 0, $mystyle = 0) {
    $trace = debug_backtrace();
    $curTrace = $trace[0];
    echo "\n<p style=\"margin: 1px 0; font: 7.5pt tahoma; color: red;\">DEBUGGING File " . $curTrace['file'] . " line " . $curTrace['line'] . "</p>";
    if ((is_array($out_string)) || (is_object($out_string))) {
        pa($out_string);
    } else {
        if ($mystyle) {
            echo ($out_string);
        } else {
            echo ("\n<p style=\"margin: 1px 0; font: 7.5pt tahoma; color: red;\">]" . $out_string . "[</p>");
        }
    }

    if ($immediate_output) {
        ob_flush();
        flush();
    }
}

function pa($out_array) {
    echo "\n<pre style=\"margin: 2px 0; font:7.5pt tahoma; color:green;\">";
    echo "\n";
    print_r($out_array);
    echo "\n</pre>";
}

function debug() {
    $short_debug = array();
    foreach (debug_backtrace() as $key => $debug) {
        if ($key == 0) {
            continue;
        }

        if (isset($debug['file'])) {
            $short_debug[$key - 1]['file'] = $debug['file'];
        }

        if (isset($debug['line'])) {
            $short_debug[$key - 1]['line'] = $debug['line'];
        }

        if (isset($debug['function'])) {
            $short_debug[$key - 1]['function'] = $debug['function'];
        }

        if (isset($debug['class'])) {
            $short_debug[$key - 1]['class'] = $debug['class'];
        }
    }
    return $short_debug;
}