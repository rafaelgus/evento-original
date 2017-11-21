<?php

if (!function_exists('current_user')) {
    function current_user()
    {
        return Auth::user();
    }
}

if (!function_exists('current_customer')) {
    function current_customer()
    {
        return Auth::user()->getCustomer();
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

if (!function_exists('article_image_url')) {
    function article_image_url(string $filename)
    {
        return storage_url() . "/images/" . $filename;
    }
}


if (!function_exists('storage_url')) {
    function storage_url()
    {
        return env('AWS_S3_URL');
    }
}

if (!function_exists('domain_url')) {
    function domain_url()
    {
        return "https://evento-original.com";
    }
}
