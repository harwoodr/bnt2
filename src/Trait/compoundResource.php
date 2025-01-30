<?php

namespace App\Trait;

use App\Entity;

trait compoundResource
{

    public function index(): void
    {
        echo __CLASS__ . " - " . __METHOD__ . " - " . $this->targetName;

    }

    public function show(?int $ida, ?int $idb): void
    {
        echo __CLASS__ . " - " . __METHOD__ . " - " . $this->targetName . " - ida:" . $ida . " - idb:" . $idb;
    }

    public function create(): void
    {
        echo __CLASS__ . " - " . __METHOD__ . " - " . $this->targetName;

    }

    public function store(): void
    {
        echo __CLASS__ . " - " . __METHOD__ . " - " . $this->targetName;

    }

    public function edit(?int $ida, ?int $idb): void
    {
        echo __CLASS__ . " - " . __METHOD__ . " - " . $this->targetName . " - ida:" . $ida . " - idb:" . $idb;
    }

    public function update(?int $ida, ?int $idb): void
    {
        echo __CLASS__ . " - " . __METHOD__ . " - " . $this->targetName . " - ida:" . $ida . " - idb:" . $idb;
    }

    public function destroy(?int $ida, ?int $idb): void
    {
        echo __CLASS__ . " - " . __METHOD__ . " - " . $this->targetName . " - ida:" . $ida . " - idb:" . $idb;
    }
}