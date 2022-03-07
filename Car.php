<?php
require_once('Race.php');

class Car
{
    
    const CAR_SPEED_MIN = 4;
    const CAR_SPEED_MAX = 22;

    protected string $name;
    public int $straightSpeed;
    public int $curveSpeed;
    protected int $position = 0;

    public function __construct(string $name)
    {
        $this->name = $name;

        $this->setSpeed();

        echo '<p><b>' . $this->getType() . '</b> created - <b>' . $name . '</b></p>';
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function move(int $speed): void
    {
        $this->position += $speed;   
    }

    public function getType(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getSortedcarsByPosition(array $cars): array
    {
        usort($cars, fn($a, $b) => ($a->position <= $b->position));
        return $cars;
    }

    public function setPosition(int $newPosition): void
    {
        $this->position = $newPosition;
    }

    private function setSpeed(): void
    {
        $this->straightSpeed = rand(self::CAR_SPEED_MIN, self::CAR_SPEED_MAX - self::CAR_SPEED_MIN);
        $this->curveSpeed = self::CAR_SPEED_MAX - $this->straightSpeed;
    }
}
