<?php

if (!function_exists('children')) {
    function children($array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                echo TAB . "'$key' => [" . LINE_BREAK;
                children($value);
                echo TAB . TAB . '],' . LINE_BREAK;
            } else {
                echo TAB . TAB . '"' . $key . '" => "' . $value . '",' . LINE_BREAK;
            }
        }
    }
}


echo '<?php' . LINE_BREAK;
echo 'return [' . LINE_BREAK;

foreach ($array as $key => $value) {
    if (is_array($value)) {
        echo TAB . '"' . $key . '" => [' . LINE_BREAK;
        children($value);
        echo TAB . ' ],' . LINE_BREAK;
    } else {
        echo TAB . ' "' . $key . '" => "' . $value . '",' . LINE_BREAK;
    }
}
echo '];';
