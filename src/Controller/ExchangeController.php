<?php

namespace App\Controller;

use App\Entity\History;
use App\Services\HistoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ExchangeController extends AbstractController
{
    public function __invoke(HistoryService $historyService): History
    {
        return $historyService->handle();
    }
}