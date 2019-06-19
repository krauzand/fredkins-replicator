<?php
class Cell {
    protected $x;
    protected $y;
    protected $grid;
    protected $on;
    protected $new_on;

    public function isNewOn(): ?bool {
        return $this->new_on;
    }

    public function isOn(): bool {
        return $this->on;
    }

    public function setOn(bool $on) {
        $this->on = $on;
    }

    public function __construct(int $x, int $y, Grid $grid)
    {
        $this->x = $x;
        $this->y = $y;
        $this->grid = $grid;
        $this->on = false;
        $this->new_on = null;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return Grid
     */
    public function getGrid(): Grid
    {
        return $this->grid;
    }

    public function setGrid(Grid $grid) {
        $this->grid = $grid;
    }

    public function nextIteration() {
        foreach(range(-1, 1) as $x_prim){
            foreach(range(-1,1) as $y_prim){
                $x = $this->x+$x_prim;
                $y = $this->y+$y_prim;
                if (!$this->getGrid()->existsCell($x,$y)) {
                    $this->getGrid()->initCell($x, $y);
                }
            }
        }

    }

    public function calculate() {
        $on_count = 0;
        foreach(range(-1, 1) as $x_prim){
            foreach(range(-1,1) as $y_prim){
                $x = $this->x+$x_prim;
                $y = $this->y+$y_prim;
                if ($this->grid->existsCell($x, $y)) {
                    $cell = $this->grid->getCell($x, $y);
                    if ($cell->isOn() && $cell !== $this) {
                        $on_count++;
                    }
                }
            }
        }
        $this->new_on = $on_count > 0 && $on_count % 2 === 1;
        return $this->new_on;
    }

    public function reset()
    {
        $this->new_on = null;
    }

    public function setNewOn(bool $isOn)
    {
        $this->new_on = $isOn;
    }
}