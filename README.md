Slic3r Server
================================
Goals
----------------

1) people can do the sli3r configration setting online, it's easy for them to ask for suggestion if everyone can access the correct slic3r setting.

2) people can do the sli3r online instead of local computer, this will simplify so many slic3r setting, and avoid some possible problem on the local computer.


Join This Project
-----------------
I am looking for developer(s) to join me with this prject. please email me or fork this project if you like to help. Thanks,

Web application is powered by Yii 2, you can check the demo at: http://mrguo.net/slicer/web/

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install from an Archive File

Downlaod the .zip file.

If your composer.json is changed you can run ```composer update```, wait till packages are downloaded and installed and then just use them. Autoloading of classes will be handled automatically.


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.

Also check and edit the other files in the `config/` directory to customize your application.
