<?php
$max_iterations = $_GET['iterations'] ?? 15;
$max_iterations = min($max_iterations, 35);
$print_only = null;
$on = $_GET['on'] ?? '⬛';
$off = $_GET['off'] ?? '⬜';
$pattern_index = $_GET['pattern'] ?? 4;
$patterns = [1 => '1x1', 2 => '3x3 Dice Five', 3 => '3x3 Diagonal', 4 => '3x3 Cross']
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

    <label>
        Pattern
        <select name="pattern">
            <?php foreach ($patterns as $i => $pattern):?>
                <option value="<?= $i?>" <?= $i == $pattern_index ? 'selected' : '' ?>><?= $pattern ?></option>
            <?php endforeach;?>
        </select>
    </label>

    <button type="submit">Replicate</button>
</form>
<?php

include('src/Grid.php');
include('src/Cell.php');
include('src/PatternFactory.php');

//$pattern = PatternFactory::pattern3x3Five();
//
$pattern = PatternFactory::pattern3x3Cross();
switch ($pattern_index) {
    case 1:
        $pattern = PatternFactory::pattern1x1();
        break;
    case 2:
        $pattern = PatternFactory::pattern3x3DiceFive();
        break;
    case 3:
        $pattern = PatternFactory::pattern3x3Diagonal();
        break;
    case 4:
        $pattern = PatternFactory::pattern3x3Cross();
        break;
}

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
