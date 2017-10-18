<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\OrderDetail;
use EventoOriginal\Core\Persistence\Repositories\OrderDetailRepository;
use Exception;
use Money\Currency;
use Money\Money;

class OrderDetailService
{
    const EUR_CURRENCY =  'EUR';

    private $orderDetailRepository;

    public function __construct(OrderDetailRepository $detailRepository)
    {
        $this->orderDetailRepository = $detailRepository;
    }

    /**
     * @param array $data
     * @param bool $discount
     * @throws Exception
     * @return OrderDetail
     */
    public function create(array $data, bool $discount = false)
    {
        $detail = new OrderDetail();
        $detail->setQuantity($data['quantity']);

        $money = new Money(($data['price'] * 100 ), new Currency(self::EUR_CURRENCY));

        $detail->setMoney($money);

        if (!in_array('artice', $data) and $discount === true) {
            throw new Exception('Invalid detail');
        }

        if (in_array('artice', $data)) {
            $detail->setArticle($data['article']);
        }

        $detail->setDiscount($discount);
        return $detail;
    }

    public function setOrder(array $orderDetails, Order $order)
    {
        foreach ($orderDetails as $detail) {
            $detail->setOrder($order);

            $this->orderDetailRepository->save($detail, false);
        }

        $this->orderDetailRepository->flushRepository();
    }

    public function findById(int $id)
    {
        return $this->orderDetailRepository->find($id);
    }

    public function findAll()
    {
        return $this->orderDetailRepository->findAll();
    }
}