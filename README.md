## Pendahuluan

SOAP client untuk Laravel yang dikhususkan untuk menggunakan webservice dari aplikasi PDDIKTI. Untuk menggunakan package ini diharapkan user mengetahui akses login forlap.

## Installasi Package

Untuk sementara saya tidak mendaftarkan package ini ke packagist karena package ini memang dibuat untuk webservice PDDIKTI yang hanya digunakan oleh perguruan tinggi di Indonesia. 

Untuk menginstall package ini ke laravel tambahkan link github ini ke file `composer.json`

```
// composer.json

...
"repositories": [
    {
        "type": "git",
        "name": "sugeng/soap-client",
        "url": "https://github.com/sugeng/soap-client.git"
    }
  ],
  "require": {
        "php": ">=5.6.4",
        "sugeng/soap-client": "dev-master"
        "laravel/framework": "5.4.*",
        "laravel/tinker": "~1.0"
  },
...

```

Simpan kemudian lakukan `composer update`

#### Service Provider

Buka `config/app.php` dengan text editor lalu tambahkan service provider pada bagian provider

```
Sugeng\Soap\SoapClientServiceProvider::class,
```

#### Facade

Jika ingin menggunakan facade, silakan tambahkan pada `app.php` pada bagian alias

```
'Soap' => Sugeng\Soap\SoapFacade::class,
```

Selanjutnya dapat memanggil soap dengan `Soap::make()`

## Config File

Authentikasi forlap dapat disimpan pada `.env` atau langsung disimpan pada file config. Untuk mempublish file config gunakan

```
php artisan vendor:publish --config
```

Yang akan menyalin file `forlap.php` ke folder config laravel.

Silakan update file config sesuai konfigurasi PDDIKTI

```
'url'           => env('FORLAP_URL', 'http://<ip-atau-domain-apliasi-pddikti>:8082/ws/live.php?wsdl'),
'username'      => env('FORLAP_USERNAME', '<username forlap>'),
'password'      => env('FORLAP_PASSWORD', '<password forlap'),
'token-name'    => env('FORLAP_TOKEN', 'forlap-token')
```

ATAU gunakan file `.env`

```
FORLAP_URL=http://<ip-atau-domain-apliasi-pddikti>:8082/ws/live.php?wsdl
FORLAP_USERNAME=username forlap
FORLAP_PASSWORD=password forlap
```

## Contoh-contoh

```
// routes/web.php

Route::get('soap-test', function() {
    $forlap = \Soap::make(); // Facade

    dump("token : {$forlap->token()}");

    $result = $forlap->proxy()->ListTable($forlap->token());

    dump($result);
});
```

```
Route::get('soap-test-mahasiswa', function() {
    $forlap = app('soap.client'); // Using app resolve container..

    dump("token : {$forlap->token()}");

    $table = 'mahasiswa';
    $filter = "nm_pd ilike '%abdul%'";
    $order = 'nm_pd';
    $limit = 10;
    $offset = 0;

    $result = $forlap->proxy()->GetRecordset($forlap->token(), $table, $filter, $order, $limit, $offset);

    dump($result);
});

```

## Why I build This Package?

[Sugeng Me]()

