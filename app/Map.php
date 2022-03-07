<?php
namespace App;

use App\Cell;

class Map
{
    private array $cells;
    private const DIMENSIONS = ['row' => 5, 'column' => 5];
    private const INITIALROVERPOSITION = ['row' => 0, 'column' => 0];

    public function create(): void
    {
        $this->cells = $this->createCells();
        $this->setRandomObstacles();
        $this->fillRover($this->find(self::INITIALROVERPOSITION['row'], self::INITIALROVERPOSITION['column']));
    }

    public function getRoversCell(): Cell
    {
        foreach ($this->cells as $cell){
            if($cell->hasRover()){
                return $cell;
            }
        }
    }

    public function getObstaclesPositions(): string
    {
        $obstacles = "";
        foreach ($this->cells as $cell){
            if($cell->hasObstacle()){
                $obstacles .= "\r\n" . $cell->toString();
            }
        }

        return $obstacles;
    }

    public function move(String $actions): void
    {
        $actions = str_split(strtoupper($actions));

        foreach ($actions as $action){
            $cell = $this->getRoversCell();
            $target = $this->getTargetCell($action, $cell);

            if($target->hasObstacle()){
                throw new \Exception('Movement not valid in this cell are a obstacle!');
            }
            $cell->empty();
            $this->fillRover($target);
        }
    }

    public function getTargetCell(String $action, Cell $cell): Cell
    {
        $actualRow = $cell->getRow();
        $actualColumn = $cell->getColumn();

        return match($action) {
            'R' => $this->find($actualRow, $actualColumn + 1),
            'L' => $this->find($actualRow, $actualColumn - 1),
            'F' => $this->find($actualRow + 1, $actualColumn),
            default => throw new \InvalidArgumentException('Movement not valid!'),
        };
    }

    public function find($row, $column): Cell
    {
        $cell = array_filter($this->cells, static fn ($cell) => $cell->getRow() == $row && $cell->getColumn() == $column );
        if(empty($cell)){
            throw new \Exception('Movement not valid this cell not exists!');
        }
        return reset($cell);
    }

    private function createCells(): array
    {
        $cells = [];
        for($row = 0; $row < self::DIMENSIONS['row']; $row++){
            for($column = 0; $column < self::DIMENSIONS['column']; $column++){
                array_push($cells, new Cell($row, $column));
            }
        }
        return $cells;
    }

    private function setRandomObstacles(): void
    {
        $randCells = array_rand($this->cells, 5);
        foreach ($randCells as $randCellIndex){
            if( $this->cells[$randCellIndex]->getRow() != self::INITIALROVERPOSITION['row'] &&
                $this->cells[$randCellIndex]->getColumn() != self::INITIALROVERPOSITION['column']){
                    $this->cells[$randCellIndex]->fillObstacle();
            }
        }
    }

    private function fillRover(Cell $cell): void
    {
        if($this->isValid($cell)) {
            $cell->fillRover();
        }
    }

    private function isValid(Cell $cell): bool
    {
        return $cell->getRow() <= self::DIMENSIONS['row'] && $cell->getColumn() <= self::DIMENSIONS['column'];
    }
}
