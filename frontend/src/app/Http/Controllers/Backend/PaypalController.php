<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Enums\PayoutGateways;
use EventoOriginal\Core\Services\PayoutService;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    private $payoutService;

    public function __construct(PayoutService $payoutService)
    {
        $this->payoutService = $payoutService;
    }

    private const RESOURCE_TYPE_PAYOUTS_ITEM = 'payouts_item';

    public function payoutWebhook(Request $request)
    {
        $data = $request->all();

        logger()->info($data);

        if ($data['resource_type'] === self::RESOURCE_TYPE_PAYOUTS_ITEM) {
            $resource = $data['resource'];
            $payoutItem = $resource['payout_item'];
            $externalId = $payoutItem['sender_item_id'];

            $payout = $this->payoutService->findByExternalId($externalId);

            if ($payout) {
                $this->payoutService->processWebhook($payout, $data);
            }
        }
    }
}
