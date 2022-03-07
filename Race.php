<?php
require_once('Car.php');
include('RaceResult.php');
include('RoundResult.php');


class Race
{
    const TOTAL_CARS = 5;
    const MAX_TRACK_ELEMENTS = 2000;
    const SERIES_ELEMENTS_MINIMUM_LENGTH = 40;
    const STRAIGHT_ELEMENT_TYPE = 'straight';
    const CURVE_ELEMENT_TYPE = 'curve';
    
    private $track;
    private $raceResult;
    private array $roundResults = [];
    private array $cars;
    private bool $isRaceEnded;

    private static array $elementTypes = [
        self::STRAIGHT_ELEMENT_TYPE,
        self::CURVE_ELEMENT_TYPE
    ];

    public function __construct()
    {
        $this->track = $this->createTrack();

        $carOBJarr = [];
        for ($i=0; $i < self::TOTAL_CARS; $i++) {
            $carNumber =  $i + 1;
            array_push($carOBJarr, new Car("Car-" . $carNumber));
        }
        $this->cars = $carOBJarr;
        $this->raceResult = new RaceResult();
    }

    private function createTrack(): array
    {
        $trackSeriesCount = round(self::MAX_TRACK_ELEMENTS / self::SERIES_ELEMENTS_MINIMUM_LENGTH);

        $trackLoop = [];
        for ($i = 0, $step = 1; $i < $trackSeriesCount; $i++, $step++) {
            $maxElementChunkIndex = $step * self::SERIES_ELEMENTS_MINIMUM_LENGTH;
            $trackLoop[--$maxElementChunkIndex] = self::$elementTypes[array_rand(self::$elementTypes)];
            
        }
        return $trackLoop;
    }

    public function start(): RaceResult
    {
        $round = 0;
        $this->isRaceEnded = false;
        $carCurrentElements = [];
        $carPersonalTrack = [];

        for ($i = 0; $i < count($this->cars); $i++) {
            $carPersonalTrack[$i] = $this->track;
            $carCurrentElements[] = reset($carPersonalTrack[$i]);
        }

        while (!$this->isRaceEnded) {

            foreach ($this->cars as $index => $car) {
               
                $car->move($carCurrentElements[$index] == "straight" ? $car->straightSpeed : $car->curveSpeed);
                $currentMaxElementChunkIndex = key($carPersonalTrack[$index]);

                if ($car->getPosition() >= $currentMaxElementChunkIndex) {
                    unset($carPersonalTrack[$index][key($carPersonalTrack[$index])]);

                    if (!empty($carPersonalTrack[$index])) {
                        $nextElement = reset($carPersonalTrack[$index]);

                        if ($carCurrentElements[$index] !== $nextElement) {
                            $carCurrentElements[$index] = $nextElement;
                            $car->setPosition(++$currentMaxElementChunkIndex);
                        }

                    } else {
                        if ($car->getPosition() > array_key_last($this->track)) {
                            if (!$this->isRaceEnded) {
                                $this->isRaceEnded = true;
                            }
                
                            $this->raceResult->finalRoundArray($car);
                        }
                    }

                }
            }
            
            $this->roundResults[] = (new RoundResult(++$round, $this->cars[0]->getSortedcarsByPosition($this->cars)));

        }

        $this->raceResult->setRoundResults($this->roundResults);
        return $this->raceResult;
    }
    
}
