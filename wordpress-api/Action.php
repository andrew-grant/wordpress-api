<?php

function add_action_temp($a) {
    echo "<h2>add_action_temp called with an action of " . $a . "</h2>";
}

class Action {

    public static function __callStatic($name, $arguments) {
        $actionName = self::from_camel_case($name);
        $merged = array_merge(array($actionName), $arguments);
        // todo: the second arg in merged must be a function (is_callable)
        // test on shortcode class
        call_user_func_array("add_action_temp", $merged);
    }

    static function from_camel_case($str) {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "_" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }

}

?>
