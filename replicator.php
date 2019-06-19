
<?php
include('src/Grid.php');
include('src/Cell.php');

$max_iterations = 22;
$print_only = null;
$on = '🚦';
$off = '🚥';//credits to five year old daughter Gundega

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
$grid->initGrid($pattern, $on, $off);
print "{$on}\n";


$out = '';
foreach (range(1, $max_iterations) as $i) {
    print "{$i} ";
    $out .= "<div class='image'>{$grid->iterate(($i+1) === $print_only || $print_only === null)}</div>";
}
$out = "<style>.images{font-size: 6px;
line-height: 8px;}</style><div class='images'>{$out}</div>";

file_put_contents('/Users/Andris/Downloads/fred-'.time().'.htm', $out);
