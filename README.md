# Drinks Machine Code


## Installation

Use the  package manager [Composer](https://getcomposer.org/download/) to install .


```bash
Composer install
```
Run a Redis Server (127.0.0.1:6379)

## Usage

### get drink

```php
use Amirzibaee\DrinksMachine\Controllers\Machine;

$machine = new Machine;
$machine->getDrink('pepsi', ['2'=>1,'1'=>3]);

```

### add/remove/update Container to Drinks Machine

```php
use Amirzibaee\DrinksMachine\Controllers\Drinks;

$obj = new Drinks;

$obj->addContainer('pepsi','Pepsi',10,3 );

$obj->removeContainer('pepsi');

$obj->updateContainer('pepsi','Fanta',12,4 );


```

### plus/minus Money 

```php
use Amirzibaee\DrinksMachine\Controllers\Monies;

$obj = new Monies;

$obj->plus(2,5);

$obj->minus(1,1);

/** group plus */
$obj->plusMonies(
            [
                '2' => 10,
                '1' => 10,
                '0.5' => 10,
                '0.2' => 10,
                '0.1' => 10,
            ]
        );
```


### exchange Monies

```php
use Amirzibaee\DrinksMachine\Controllers\Monies;

$obj = new Monies;

/** 
 * exchange(Drink price,Customer payment)
 * 
 * @returns false| remaining Money list
 */
$obj->exchange(5,2);

```


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)

