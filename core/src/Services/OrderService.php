<?php

namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\OrderDetail;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\VisitorEvent;
use EventoOriginal\Core\Enums\MovementType;
use EventoOriginal\Core\Enums\PaymentStatus;
use Money\Currency;
use Money\Money;

class OrderService
{
    private $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function liquidateAffiliateCommission(Order $order, User $seller, VisitorEvent $visitorEvent)
    {
        $article = $visitorEvent->getArticle();

        $articleCommission = $article->getCategory()->getAffiliateCommission();

        if ($order->getPayment()->getStatus() === PaymentStatus::APPROVE) {
            $orderDetail = $order->getOrdersDetail()->filter(function (OrderDetail $orderDetail) use ($article) {
                return $orderDetail->getArticle() === $article;
            });

            if ($orderDetail) {
                $amount = $orderDetail[0]->getMoney()->getAmount();

                $sellerCommission = $amount * ($articleCommission / 100);

                $moneyCommission = new Money($sellerCommission, new Currency('EUR'));

                $this->walletService->addBalance(
                    $seller->getWallet(),
                    $moneyCommission,
                    MovementType::AFFILIATE_COMMISSION_CREDIT,
                    $visitorEvent
                );
            }
        }

        logger()->notice("Affiliate commission not valid, the payment is approve: Order " . $order->getId());
    }
}
