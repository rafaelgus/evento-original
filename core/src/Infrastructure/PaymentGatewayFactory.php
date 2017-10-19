<?php
namespace EventoOriginal\Core\Infrastructure\Payments;
use EventoOriginal\Core\Enums\PaymentGateway;
use EventoOriginal\Core\Infrastructure\Payments\Checkout\WebCheckout\PaypalService;
use EventoOriginal\Core\Infrastructure\Payments\Exceptions\InvalidGatewayException;
use Exception;

class PaymentGatewayFactory
{
    private $paymentGateways;

    public function __construct(array $paymentGateways = [])
    {
        $this->paymentGateways = $paymentGateways;
    }
    /**
     * @param string $gateway
     * @return PaymentGatewayInterface
     * @throws Exception
     * @throws InvalidGatewayException
     */
    public function create(string $gateway)
    {
        if (!in_array($gateway, $this->paymentGateways)) {
            throw new InvalidGatewayException();
        }
        if ($gateway === PaymentGateway::PAYPAL) {
            $paymentGateway = new PaypalService();
            return $paymentGateway;
        } else {
            throw new Exception('gateway not implemented');
        }
    }
}