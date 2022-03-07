<?php
namespace App;

class Cell
{
    private $row;
    private $column;
    private bool $rover = false;
    private bool $obstacle = false;

    public function __construct($row, $column){
        $this->row = $row;
        $this->column = $column;
    }

    public function toString(): string
    {
        return 'Column: ' . $this->column . ' Row: ' . $this->row;
    }

    public function fillRover(): void
    {
        if($this->isEmpty()) {
            $this->rover = true;
        }
    }

    public function hasRover(): bool
    {
        return $this->rover;
    }

    public function fillObstacle(): void
    {
        if($this->isEmpty()){
            $this->obstacle = true;
        }
    }

    public function getRow(): string
    {
        return $this->row;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function empty(): void
    {
        $this->rover = false;
    }

    public function hasObstacle(): bool
    {
        return $this->obstacle;
    }

    private function isEmpty(): bool
    {
        if(!$this->hasObstacle() && !$this->rover){
            return true;
        }
        return false;
    }
}
