<?php
return [
    'name' => 'Document',
    'version' => '1.0',
    'date' => '2017-03-01',
    'label' => 'Управления документами',

    /*
    |--------------------------------------------------------------------------
    | Место хранения записей об документах
    |--------------------------------------------------------------------------
    |
    | Здесь можно определить место хранения для записей об документах.
    | Доступны значения: "database" - база данных, "mongodb" - MongoDb
    |
    */
    'record' => env('DOCUMENT', 'mongodb'),

    
	/*
    |--------------------------------------------------------------------------
    | Драйвер хранения документов
    |--------------------------------------------------------------------------
    |
    | Определяем систему хранения документов.
	| base - в базе данных, local - локально в папке, ftp - через FTP протокол в папке
	| http - через HTTP протокол в папке
    |
    */
	'driver' => env('DOCUMENT_DRIVER', 'local'),


	/*
    |--------------------------------------------------------------------------
    | Настройка хранилищь для документов
    |--------------------------------------------------------------------------
    |
    | В этом месте можно определить доступы к хранилищу документов
    |
    */
	'store' =>
	[
		'base' =>
		[
		'table' => 'document',
		'property' => 'byte'
		],
		'local' =>
		[
		'path' => 'engine/storage/app/public/documents/',
		'pathSource' => storage_path('app/public/documents/'),
		],
		'ftp' =>
		[
		'server' => 'weborobot.ru',
		'login' => 'weborobot',
		'password' => '',
		'path' => 'www/documents/'
		],
		'http' =>
		[
		'read' => 'http://loc.weborobot.ru/engine/storage/app/public/documents/',
		'create' => 'http://loc.weborobot.ru/doc/create/',
		'update' => 'http://loc.weborobot.ru/doc/update/',
		'destroy' => 'http://loc.weborobot.ru/doc/destroy/',
		]
	],
];
