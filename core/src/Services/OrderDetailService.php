<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\OrderDetail;
use EventoOriginal\Core\Persistence\Repositories\OrderDetailRepository;

class OrderDetailService
{
    private $orderDetailRepository;

    public function __construct(OrderDetailRepository $detailRepository)
    {
        $this->orderDetailRepository = $detailRepository;
    }

    /**
     * @param array $data
     * @return OrderDetail
     */
    public function create(array $data)
    {
        $detail = new OrderDetail();
        $detail->setQuantity($data['quantity']);
        $detail->setMoney($data['money']);
        $detail->setArticle($data['article']);
        return $detail;
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