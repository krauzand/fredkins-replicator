<?php
$max_iterations = $_GET['iterations'] ?? 22;
$max_iterations = min($max_iterations, 35);
$print_only = null;
$on = $_GET['on'] ?? '⬛';
$off = $_GET['off'] ?? '⬜';
?>
<form>
    <label>
        On
        <input type="text" value="<?= $on ?>" maxlength="1" name="on">
    </label>
    <label>
        Off
        <input type="text" value="<?= $off ?>" maxlength="1" name="off">
    </label>

    <label>
        Iterations
        <input type="number" name="iterations" max="35" value="<?= $max_iterations ?>">
    </label>


    <button type="submit">Replicate</button>
</form>
<?php

include('src/Grid.php');
include('src/Cell.php');

$pattern = new Grid();

/* 3x3 five */
$pattern->initCell(-1, -1)->setOn(true);
$pattern->initCell(-1, 0)->setOn(false);
$pattern->initCell(-1, 1)->setOn(true);
$pattern->initCell(0, -1)->setOn(false);
$pattern->initCell(0, 0)->setOn(true);
$pattern->initCell(0, 1)->setOn(false);
$pattern->initCell(1, -1)->setOn(true);
$pattern->initCell(1, 0)->setOn(false);
$pattern->initCell(1, 1)->setOn(true);

/* 3x3 five */
$pattern->initCell(-1, -1)->setOn(true);
$pattern->initCell(-1, 0)->setOn(false);
$pattern->initCell(-1, 1)->setOn(false);
$pattern->initCell(0, -1)->setOn(false);
$pattern->initCell(0, 0)->setOn(true);
$pattern->initCell(0, 1)->setOn(false);
$pattern->initCell(1, -1)->setOn(false);
$pattern->initCell(1, 0)->setOn(false);
$pattern->initCell(1, 1)->setOn(true);



$grid = new Grid();

//zero iteration
$grid->initGrid($pattern, $on, $off);
print "{$on}\n";
print "<hr>";

$out = '';
foreach (range(1, $max_iterations) as $i) {
    $out .= "<div class='image i-{$i}'>{$grid->iterate(($i+1) === $print_only || $print_only === null)}</div>";
}
$out = "<style>
    .images {
        font-size: 6px;
        line-height: 8px; 
        display:flex; 
        flex-wrap: wrap;
        align-items: center;
    }
    .image {
        padding: 10px;
    }
   
</style>
<div class='images'>{$out}</div>";

print $out;
