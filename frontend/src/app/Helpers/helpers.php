<?php

if (!function_exists('current_user')) {
    function current_user()
    {
        return Auth::user();
    }
}

if (!function_exists('current_user_is_admin')) {
    function current_user_is_admin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('storage_url')) {
    function storage_url()
    {
        return "https://evento-original-s3.s3.us-east-2.amazonaws.com";
    }
}

if (!function_exists('domain_url')) {
    function domain_url()
    {
        return "https://evento-original.com";
    }
}
