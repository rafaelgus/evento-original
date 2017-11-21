<?php

use Money\Money;
use Symfony\Component\Intl\Intl;

function formatted_money(Money $money)
{
    return ($money->getAmount() / 100) . " " . money_symbol($money);
}

function money_symbol(Money $money)
{
    return Intl::getCurrencyBundle()->getCurrencySymbol($money->getCurrency()->getCode());
}

