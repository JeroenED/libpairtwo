libpairtwo
==========
This distribution is a good start to use libpairtwo if you don't have knowledge of composer or dependency management.

How to use this distribution?
-----------------------------
The file `template.php` is the one you'll probably want to work with. The user will want to point your browser to this file. 
The first 2 lines of this file contains 2 important variables. The most important one is the variable `$pairingfile`. You'll want to set this to your existing pairing file. The other variable (`$fileformat`) is a variable that defines the format of the above pairing file. For now only `Pairtwo-6`, `Pairtwo-5` and `Swar-4` are available. In the future more formats will become available.

Starting from line 8 you'll find some example code. The example codes gives the pairings and rankings of the currently used pairing file. If you need any modifications like adding your own template or you want to just write it to a file: go ahead it's all yours.

How to update the library?
--------------------------
If you want to upgrade the library to a new version you just need to remove the `vendor/` directory and upload the updated one.

It's important to remove the folder first because overwriting might cause problems because of residual files.

What if I need other dependencies?
----------------------------------
If you started to ask yourself this question, you'll probably know what composer and dependency management is? Therefore this section will become a little more advanced than the ones above.

To add another dependency you just run `composer require {{ your new dependency }}`

    $ composer require phpoffice/phpspreadsheet

If you already have a project with other dependencies you'll only want to copy or edit the `template.php` file and run. 

    $ composer require jeroened/libpairtwo

If you want to update the libary while having other dependencies you don't want to remove `vendor/` directory or `composer.json` file. The `vendor/` folder contains these other dependencies and the `composer.json` contains the definitions of these dependencies. To update the library you only need to launch the update command.

    $ composer update jeroened/libpairtwo
