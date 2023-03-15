<?php
if (!function_exists('setting')) {
    function setting($name) {
        return app('settings')[$name] ?? null;
    }
}