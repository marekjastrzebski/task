<?php

namespace App\Services;

use App\Entity\History;
use Symfony\Component\HttpFoundation\RequestStack;


class HistoryService
{
    public function __construct(
        private readonly RequestStack $requestStack
    )
    {
    }

    public function handle(): History
    {
        $entity = $this->create();

        return $this->update($entity);
    }

    private function create(): History
    {
        $request = json_decode($this->requestStack->getCurrentRequest()?->getContent(), true);
        $history = new History();
        $history->setFirstIn($request['first'] ?? null);
        $history->setSecondIn($request['second'] ?? null);
        $history->setCreateDate(new \DateTime('now'));

        return $history;
    }

    private function update(History $history): History
    {
        $history->setFirstOut($history->getSecondIn());
        $history->setSecondOut($history->getFirstIn());
        $history->setUpdateDate(new \DateTime('now'));

        return $history;
    }
}