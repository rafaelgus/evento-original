<?php

if (!function_exists('current_customer_balance')) {
    function current_user_balance()
    {
        $wallet = current_user()->getWallet();

        if ($wallet) {
            return $wallet->getBalance();
        }

        return 0;
    }
}
