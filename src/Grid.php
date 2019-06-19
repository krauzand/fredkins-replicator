<?php
class Grid {
    protected $grid_cells = [];
    /**
     * @var Cell[]
     */
    protected $cells = [];
    protected $iteration;
    protected $size;
    protected $offset;
    protected $range;
    protected $on;
    protected $off;


    public function initGrid(Grid $from_grid, $on = '⬛', $off = '⬜') {
        $this->on = $on;
        $this->off = $off;
        $this->iteration = 0;
        $this->grid_cells = $from_grid->grid_cells;
        $this->cells = $from_grid->cells;

        foreach ($this->cells as &$cell) {
            $new_cell = new Cell($cell->getX(), $cell->getY(), $this);
            $new_cell->setOn($cell->isOn());
            $new_cell->reset();


            $cell = $new_cell;
            $this->grid_cells[$cell->getX()][$cell->getY()] = $cell;
        }

        $this->setSize();
    }

    protected function setSize() {
        $this->size = count($this->grid_cells);
        $this->offset = ($this->size - 1) / 2;
        $this->range = range(-$this->offset, $this->offset);
    }

    public function initCell(int $x, int $y): Cell {
        $this->grid_cells[$x][$y] = new Cell($x, $y, $this);
        ksort($this->grid_cells);

        $this->cells[] = $this->grid_cells[$x][$y];
        return $this->grid_cells[$x][$y];
    }

    public function existsCell($x, $y){
        return array_key_exists($x, $this->grid_cells) && array_key_exists($y, $this->grid_cells[$x]);
    }

    public function getCell(int $x, int $y): Cell {
        return $this->grid_cells[$x][$y];
    }

    protected function extendGrid() {
        foreach ($this->cells as $cell) {
            $cell->nextIteration();
        }
        $this->setSize();
    }

    protected function calculateGrid() {
        foreach ($this->cells as $cell) {
            //if ready for re-calc
            if ($cell->isNewOn() === null) {
                $cell->calculate();
            }
        }
    }

    public function iterate($print = true) {

        //extend
        $this->extendGrid();

        //calculate values
        $this->calculateGrid();

        //output
        $output = null;
        if ($print) {
            $output = $this->renderGrid();
        }

        //finalize after printout
        foreach ($this->cells as $cell) {
            //if ($cell->isNewOn() !==  null) {
            $cell->setOn($cell->isNewOn());
            //}
            $cell->reset();
        }

        $this->iteration++;

        return $output;

    }

    public function renderGrid() {
        $output = '';
        foreach ($this->range as $x) {
            $line = '';
            foreach ($this->range as $y) {
                $cell = $this->getCell($x,$y);

                if ($cell->isNewOn()) {
                    $line.= $this->on;

                }
                else {
                    $line.= $this->off;
                }
            }
            $output.= "<div class='line'>{$line}</div>";
        }
        //$output.= "<hr>";
        return $output;
    }
}