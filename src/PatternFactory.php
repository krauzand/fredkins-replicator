<?php


class PatternFactory
{
    public static function pattern1x1() {
        /*
         x
         */
        $pattern = new Grid();
        $pattern->initCell(0, 0)->setOn(true);
        return $pattern;
    }

    public static function pattern3x3Cross()
    {
        /*

         x
        xxx
         x

        */
        $pattern = new Grid();
        $pattern->initCell(0, 0)->setOn(true);
        $pattern->initCell(-1, 0)->setOn(true);
        $pattern->initCell(1, 0)->setOn(true);
        $pattern->initCell(0, 1)->setOn(true);
        $pattern->initCell(0, -1)->setOn(true);
        $pattern->initCell(1, -1)->setOn(false);
        $pattern->initCell(-1, -1)->setOn(false);
        $pattern->initCell(-1, 1)->setOn(false);
        $pattern->initCell(1, 1)->setOn(false);
        return $pattern;
    }

    public static function pattern3x3DiceFive(){
        $pattern = new Grid();

        /*

        x x
         x
        x x

        */
        $pattern->initCell(-1, -1)->setOn(true);
        $pattern->initCell(-1, 0)->setOn(false);
        $pattern->initCell(-1, 1)->setOn(true);
        $pattern->initCell(0, -1)->setOn(false);
        $pattern->initCell(0, 0)->setOn(true);
        $pattern->initCell(0, 1)->setOn(false);
        $pattern->initCell(1, -1)->setOn(true);
        $pattern->initCell(1, 0)->setOn(false);
        $pattern->initCell(1, 1)->setOn(true);

        return $pattern;
    }

    public static function pattern3x3Diagonal()
    {
        /*

        x
         x
          x

        */
        $pattern = new Grid();
        $pattern->initCell(-1, -1)->setOn(true);
        $pattern->initCell(-1, 0)->setOn(false);
        $pattern->initCell(-1, 1)->setOn(false);
        $pattern->initCell(0, -1)->setOn(false);
        $pattern->initCell(0, 0)->setOn(true);
        $pattern->initCell(0, 1)->setOn(false);
        $pattern->initCell(1, -1)->setOn(false);
        $pattern->initCell(1, 0)->setOn(false);
        $pattern->initCell(1, 1)->setOn(true);
        return $pattern;
    }
}