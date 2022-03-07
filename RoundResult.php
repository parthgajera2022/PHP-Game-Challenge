<?php

class RoundResult
{

    public $step;
    public $carsPosition;

    public function __construct(int $step, array $carsPosition)
    {
        $this->step = $step;
        $this->carsPosition = $carsPosition;
    }

    public function getStep(): int
    {
        return $this->step;
    }

    public function getCarPositions(): array
    {
        return $this->carsPosition;
    }
}
