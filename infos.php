<?php

echo 'Tempo de vida no servidor (gc_maxlifetime): '.ini_get('session.gc_maxlifetime').' segundos<br>';
echo 'Tempo de vida no navegador (cookie_lifetime): '.ini_get('session.cookie_lifetime').' segundos';

session_start();

if (!empty($_SESSION)) {
    foreach ($_SESSION as $key => $value) {
        // Handle cases where the value might be an array or object
        if (is_array($value) || is_object($value)) {
            echo '<strong>'.htmlspecialchars($key).':</strong> [Array/Object]<br>';
        } else {
            echo '<strong>'.htmlspecialchars($key).':</strong> '.htmlspecialchars($value).'<br>';
        }
    }
} else {
    echo 'No session variables are currently set.';
}
