<?php

class RaceResult
{

    private $roundResults = [];
    private array $raceWinners = [];

    public function finalRoundArray(Car $car): void
    {
        $this->raceWinners[] = $car;
    }

    public function setRoundResults(array $roundResults): void
    {
        $this->roundResults = $roundResults;
    }

    public function getStepResults(): array
    {
        return $this->roundResults;
    }

    public function displayRaceResults(): void
    {
        echo "---------------------------------";
        echo '<p><b>Race</b> details:</p>';

        $this->displayWinners();
        $this->displayRoundResults();
    }

    private function displayWinners(): void
    {
        if (!empty($this->raceWinners)) {
            $table = '<table>';
            $table .= '<thead></thead>';
            $table .= '<tbody>';

            if (count($this->raceWinners) === 1) {
                $table .= '<tr><td colspan="3"><b> Winner:</b></td></tr>';
            } else {
                $this->raceWinners = $this->raceWinners[0]->getSortedCarsByPosition($this->raceWinners);

                $table .= '<tr><td colspan="3" style="text-align: center"><b> THE DRAW</b></td></tr>';
                $table .= '<tr><td colspan="3"><b> Winners:</b></td></tr>';
            }

            $table .= $this->buildCarsTablePart($this->raceWinners);

            $table .= '</tbody>';
            $table .= '</table>';

            echo $table;
        }
    }

    private function buildCarsTablePart(array $cars): string
    {
        $carTablePart = '<tr><td><i>#</i></td><td><i>Car Name</i></td></tr>';

        foreach ($cars as $index => $car) {
            $carTablePart .= '<tr>';
            $carTablePart .= '<td>' . ++$index . '</td>';
            $carTablePart .= '<td>' . $car->getName() . '</td>';
            $carTablePart .= '</tr>';
        }

        return $carTablePart;
    }

    private function displayRoundResults(): void
    {
        echo "---------------------------------";
        echo '<p><b>Rounds</b> details:</p>';

        $table = '<table>';
        $table .= '<thead></thead>';
        $table .= '<tbody>';

        foreach ($this->roundResults as $round) {
            $table .= '<tr><td colspan="3"><b> Round ' . $round->getStep() . '</b></td></tr>';

            $table .= $this->buildCarsTablePart($round->getCarPositions());

            $table .= '<tr><td colspan="3">&nbsp;</td></tr>';
        }

        $table .= '</tbody>';
        $table .= '</table>';

        echo $table;
    }
}
