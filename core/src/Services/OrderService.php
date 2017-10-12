<?php

namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\OrderDetail;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Enums\MovementType;
use EventoOriginal\Core\Enums\PaymentStatus;

class OrderService
{
    private $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function liquidateAffiliateCommission(Order $order, User $seller, Article $article)
    {
        $articleCommission = $article->getCategory()->getAffiliateCommission();

        if ($order->getPayment()->getStatus() === PaymentStatus::APPROVE) {
            $orderDetail = $order->getOrdersDetail()->filter(function (OrderDetail $orderDetail) use ($article) {
                return $orderDetail->getArticle() === $article;
            });

            if ($orderDetail) {
                $amount = $orderDetail[0]->getMoney()->getAmount();

                $sellerCommission = $amount * ($articleCommission / 100);

                $this->walletService->addBalance(
                    $seller->getWallet(),
                    $sellerCommission,
                    MovementType::AFFILIATE_COMMISSION_CREDIT
                );
            }
        }

        logger()->notice("Affiliate commission not valid, the payment is approve: Order " . $order->getId());
    }
}
