<?php
namespace App\Events;

use EventoOriginal\Core\Entities\Design;
use Illuminate\Queue\SerializesModels;

class DesignRejected
{
    use SerializesModels;

    private $design;

    public function __construct(Design $design)
    {
        $this->design = $design;
    }

    public function getDesign()
    {
        return $this->design;
    }
}
