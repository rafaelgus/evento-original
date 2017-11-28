<?php

if (!function_exists('current_customer_balance')) {
    function current_user_balance()
    {
        $wallet = current_user()->getWallet();

        if ($wallet) {
            return formatted_money($wallet->getBalanceMoney());
        }

        return 0;
    }
}
