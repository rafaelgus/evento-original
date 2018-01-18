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

        $money = new Money(($data['price']), new Currency(self::EUR_CURRENCY));

        $detail->setMoney($money);

        if (!array_has($data, 'article') and $discount === false) {
            throw new Exception('Invalid detail');
        }

        if (array_has($data, 'article')) {
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

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->orderDetailRepository->findAll();
    }

    /**
     * @param int $orderId
     * @return null|array
     */
    public function findByOrder(int $orderId)
    {
        return $this->orderDetailRepository->findBy(['order' => $orderId]);
    }

    public function save(OrderDetail $orderDetail)
    {
        $this->orderDetailRepository->save($orderDetail);
    }

    public function updateQty(OrderDetail $orderDetail, int $qty)
    {
        $money = new Money($orderDetail->getArticle()->getPrice(), new Currency(self::EUR_CURRENCY));

        $orderDetail->setQuantity($qty);
        $orderDetail->setMoney($money);

        $this->orderDetailRepository->save($orderDetail);
    }
}