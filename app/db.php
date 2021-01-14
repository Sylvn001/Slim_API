<?php
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

if(PHP_SAPI != 'cli'){
    exit('Command Line only!');
}

require __DIR__ . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/app/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();

$db = $container->get('db');

//var_dump($db);

$schema = $db->schema();

$schema = $db->schema();
$table = 'products';

$schema->dropIfExists($table);

$schema->create($table, function($table){
    $table->increments('id');
    $table->string('title', 100);
    $table->text('description');
    $table->decimal('price',11,2);
    $table->string('manufacturer', 60);
    $table->timestamps();
});

$db->table($table)->insert([
    "title" => " Redmi Note 9S",
    "description" => "Android 10.0 -  MIUI 12 - Size 6.67 - 128GB 6GB RAM  - Li-Po 5020 mAh ",
    "price" => "1519", 
    "manufacturer" => "Xioami",
    "created_at" => "2020-04-30",
    "updated_at" => "2020-04-30"
    ]);

$db->table($table)->insert([
    "title" => "Xiaomi Mi 11",
    "description" => "164.3 x 74.6 x 8.1 mm (Glass) / 8.6 mm (Leather) - 128GB 8GB RAM - 108 MP - 4600 mAh",
    "price" => " 3215", 
    "manufacturer" => "Xioami",
    "created_at" => "2020-12-28",
    "updated_at" => "2020-12-28"
]);

$schema->dropIfExists('users');

$schema->create('users', function($table){
    $table->increments('id');
    $table->string('name', 50);
    $table->string('email', 150);
    $table->string('password', 35);
});

$db->table('users')->insert([
    "name" => "Junior Barros",
    "email" => "sylvn001@mail.com",
    "password" => "123456", 
]);

$db->table('users')->insert([
    "name" => "Test User",
    "email" => "test@mail.com",
    "password" => "123456", 
]);



echo 'Migrations And Seeders created!';