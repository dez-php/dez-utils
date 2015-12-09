# dez-utils
## Utils &amp; Helpers

#Usage

```php
// use namespace
use Dez\Utils\Text;
```

#### Random strings
```php
echo Text::random(32, Text::RANDOM_ALL); // tYFhTjuxOaoNvCAEOWINJBkljrudQnhV

echo Text::random(32, Text::RANDOM_NUM); // 41247839441307727030854307274812

echo Text::random(32, Text::RANDOM_UPPER); // TMLPLFLYCCWDPWKVKFMMDFXWEZBABXYC

echo Text::random(32, Text::RANDOM_LOWER); // cuwihetmtldwglansbixjrbelvzzmqxa

echo Text::random(32, Text::RANDOM_UPPER | Text::RANDOM_NUM); // QXXQK3ZS9XT166FWG80JKWPP0MIL9JKZ
```

#### xor-crypt string

```php
$test = 'test top secret string...';
echo $test;

$encrypted  = Text::encrypt($test);

echo $encrypted; // 02c511n02lk2ti02bn29j028ixp102r5mm602vhim702ShSOv02Pl2G900007ed
echo Text::decrypt($encrypted); // test top secret string...
```

#### Camelize & Underscore string

```php
echo Text::underscore('getUserIdXRefGroupId'); // get_user_id_x_ref_group_id
echo Text::camelize('field_account_name_error_no'); // fieldAccountNameErrorNo
```