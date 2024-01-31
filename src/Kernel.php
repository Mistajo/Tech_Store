<?php

namespace App;

use App\Trait\TimeZoneTrait;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    use TimeZoneTrait;

    public function _construct(string $environment, bool $debug)
    {
        $this->changeTimeZone("Europe/Paris");
        parent::__construct($environment, $debug);
    }
}
