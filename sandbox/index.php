<?php

namespace Abc;

use Dez\Utils\Text;

include_once '../vendor/autoload.php';

echo Text::random(32, Text::RANDOM_ALL) . "<br>";

echo Text::random(32, Text::RANDOM_NUM) . "<br>";

echo Text::random(32, Text::RANDOM_UPPER) . "<br>";

echo Text::random(32, Text::RANDOM_LOWER) . "<br>";

echo Text::random(32, Text::RANDOM_UPPER | Text::RANDOM_NUM) . "<br>";

$test = 'test top secret string...';

echo $test . "<br>";

$encrypted  = Text::encrypt($test);

echo $encrypted . "<br>";

echo Text::decrypt($encrypted) . "<br>";

echo Text::underscore('getUserIdXRefGroupId') . "<br>";

echo Text::camelize('field_account_name_error_no') . "<br>";
