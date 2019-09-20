#!/bin/sh

ng build --prod

path="../serveur"
sudo rm $path/3rdpartylicenses.txt $path/main-es* $path/polyfills* $path/favicon.ico $path/runtime* $path/index.html $path/styles*
sudo cp -r dist/client-angular/* $path
