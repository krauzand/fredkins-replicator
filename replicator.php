
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


    public function initGrid(Grid $from_grid) {
        $this->iteration = 0;
        $this->grid_cells = $from_grid->grid_cells;
        $this->cells = $from_grid->cells;

        foreach ($this->cells as &$cell) {
            $new_cell = new Cell($cell->getX(), $cell->getY(), $this);
            $new_cell->setOn($cell->isOn());

            $cell = $new_cell;
            $this->grid_cells[$cell->getX()][$cell->getY()] = $cell;
        }
        $this->setSize();
        $this->iterate();
    }

    protected function setSize() {
        $this->size = count($this->grid_cells);
    }

    public function initCell(int $x, int $y): Cell {
        $this->grid_cells[$x][$y] = new Cell($x, $y, $this);
        ksort($this->grid_cells);

        $this->cells[] = $this->grid_cells[$x][$y];
        return $this->grid_cells[$x][$y];
    }

    public function getCell(int $x, int $y): Cell {
        if (!isset($this->grid_cells[$x][$y])) {
            $this->initCell($x, $y);
        }
        return $this->grid_cells[$x][$y];
    }

    public function iterate() {
        $this->offset = ($this->size - 1) / 2;
        $this->range = range(-$this->offset, $this->offset);
        $this->renderGrid();

        foreach ($this->cells as $cell) {
            if ($cell->isNewOn()){
                $cell->setOn(true);
            }
            $cell->calculate();
        }
        $this->setSize();

        foreach ($this->cells as $cell) {
            if ($cell->isNewOn() === null) {
                $cell->calculate();
            }
        }

        $this->iteration++;

    }

    public function renderGrid() {

        foreach ($this->range as $x) {
            foreach ($this->range as $y) {
                $cell = $this->getCell($x,$y);

                if ($cell->isNewOn()) {
                    print 'x';
                }
                else {
                    print '_';
                }
                //$cell->reset();
            }
            print "\n";
        }
    }
}
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
        $this->new_on = $on;
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

    public function calculate() {
        $on_count = 0;
        foreach(range(-1, 1) as $x_prim){
            foreach(range(-1,1) as $y_prim){
                $cell = $this->grid->getCell($this->x+$x_prim, $this->y+$y_prim);
                if ($cell->isOn() && $cell !== $this) {
                    $on_count++;
                }
            }
        }
        $this->new_on = $on_count > 0 && $on_count % 2 === 1;
    }

    public function reset()
    {
        $this->new_on = false;
    }
}
$pattern = new Grid();
$pattern->initCell(0,0)->setOn(true);

$grid = new Grid();
$grid->initGrid($pattern);
$grid->iterate();
$grid->iterate();
