libpairtwo
==========
This distribution is a good start to use libpairtwo if you don't have knowledge of composer or dependency management.

How to use this distribution?
-----------------------------
The file `template.php` is the one you'll probably want to work with. You'll want to point your browser to this file. It contains some initializations where the most important one is the variable `$pairingfile`. You'll want to set this to existing pairing file.
The other variable (`$pairingfileformat`) is a variable that defines the format of the above pairing file. For now only `Pairtwo-6` and `Pairtwo-5` are available. In the future more formats will become available.

Below the comments you'll find some example code. This code is only a aggregation of several fields that are read out. If you need any modifications like putting the rankings in a table or you want to just write it to a file, go ahead it's all yours.

How to update the library?
--------------------------
If you want to upgrade the library to a new version of it you just need to remove the vendor direcotry and upload the updated one.

I definitely say to remove it because simply overwriting might cause problems because residual files.

You might want to re-upload the file composer.json as well as this file might have been changed as well. However, it probably won't change a lot and can be safely ignored if you don't need other dependencies.

What if I need other dependencies?
----------------------------------
If you started to ask yourself this question, you'll probably know what composer and dependency management is? Therefore this section will become a little more advanced than the ones above.
It's actually very simple, just add them like you normally would do.

    $ composer require phpoffice/phpspreadsheet

If you already have a project with other dependencies you'll only want to copy the `boilerplate.php` file and run. 

    $ composer require jeroened/libpairtwo

If you want to update the libary while having other dependencies, you'll definitely don't want to remove vendor directory or composer.json file. The vendor folder contains these other dependencies and the composer.json contains the definitions of these dependencies. To update the library you only need to launch the update command.

    $ composer update jeroened/libpairtwo
