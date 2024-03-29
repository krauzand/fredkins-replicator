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

    public static function pattern3x3CrossEmpty() {
        $pattern = new Grid();
        $pattern->initCell(0, 0)->setOn(false);
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

    public static function pattern3x3ZL(){
        $pattern = new Grid();

        /*

        x x
         x
        x x

        */
        $pattern->initCell(-1, -1)->setOn(true);
        $pattern->initCell(-1, 0)->setOn(true);
        $pattern->initCell(-1, 1)->setOn(false);
        $pattern->initCell(0, -1)->setOn(false);
        $pattern->initCell(0, 0)->setOn(true);
        $pattern->initCell(0, 1)->setOn(false);
        $pattern->initCell(1, -1)->setOn(false);
        $pattern->initCell(1, 0)->setOn(true);
        $pattern->initCell(1, 1)->setOn(true);

        return $pattern;
    }
    public static function choose($pattern_index) {
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
            case 5:
                $pattern = PatternFactory::pattern3x3CrossEmpty();
                break;
            case 6:
                $pattern = PatternFactory::pattern3x3ZL();
                break;
        }
        return $pattern;
    }
}