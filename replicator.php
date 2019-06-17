
<?php
class Grid {
    //const ON = '⬛';
    //const OFF = '⬜';
    const ON = '🎃';
    const OFF = '💩';
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
                    $line.= self::ON;
                    //$line.= '♞‍';
                }
                else {
                    $line.= self::OFF;
                    //$line.= '♘';
                }
            }
            $output.= "<div class='line'>{$line}</div>";
        }
        $output.= "<hr>";
        return $output;
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
$pattern = new Grid();

/* 1x1 square */
//$pattern->initCell(0,0)->setOn(true);

/* 3x3 cross */
//$pattern->initCell(0,0)->setOn(true);
//$pattern->initCell(-1,0)->setOn(true);
//$pattern->initCell(1,0)->setOn(true);
//$pattern->initCell(0,1)->setOn(true);
//$pattern->initCell(0,-1)->setOn(true);
//$pattern->initCell(1,-1)->setOn(false);
//$pattern->initCell(-1,-1)->setOn(false);
//$pattern->initCell(-1,1)->setOn(false);
//$pattern->initCell(1,1)->setOn(false);

/* 3x3 square */
//$pattern->initCell(0,0)->setOn(true);
////$pattern->initCell(-1,0)->setOn(true);
////$pattern->initCell(1,0)->setOn(true);
////$pattern->initCell(0,1)->setOn(true);
////$pattern->initCell(0,-1)->setOn(true);
////$pattern->initCell(1,-1)->setOn(true);
////$pattern->initCell(-1,-1)->setOn(true);
////$pattern->initCell(-1,1)->setOn(true);
////$pattern->initCell(1,1)->setOn(true);
///
/* 3x3 five */
$pattern->initCell(-1,-1)->setOn(true);
$pattern->initCell(-1,0)->setOn(false);
$pattern->initCell(-1,1)->setOn(true);
$pattern->initCell(0,-1)->setOn(false);
$pattern->initCell(0,0)->setOn(true);
$pattern->initCell(0,1)->setOn(false);
$pattern->initCell(1,-1)->setOn(true);
$pattern->initCell(1,0)->setOn(false);
$pattern->initCell(1,1)->setOn(true);

/* 3x3 five */
$pattern->initCell(-1,-1)->setOn(true);
$pattern->initCell(-1,0)->setOn(false);
$pattern->initCell(-1,1)->setOn(false);
$pattern->initCell(0,-1)->setOn(false);
$pattern->initCell(0,0)->setOn(true);
$pattern->initCell(0,1)->setOn(false);
$pattern->initCell(1,-1)->setOn(false);
$pattern->initCell(1,0)->setOn(false);
$pattern->initCell(1,1)->setOn(true);


//$pattern->initCell(0,0)->setOn(true);
//$pattern->initCell(-1,0)->setOn(true);
//$pattern->initCell(-1,0)->setOn(true);

$grid = new Grid();

//zero iteration
$grid->initGrid($pattern);
print "initial x\n";

$max_iterations = 32;

$out = '';
foreach (range(1, $max_iterations) as $i) {
    print $i;
    $out .= "<div class='image'>{$grid->iterate()}</div>";
}
$out = "<style>.images{font-size: 6px;
line-height: 8px;}</style><div class='images'>{$out}</div>";

file_put_contents('/Users/Andris/Downloads/fred3x3-5.htm', $out);
