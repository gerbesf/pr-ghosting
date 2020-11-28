# PRG - Project Reality Ghosting

##### Database SQLite Requeriments
```
sudo apt install php7.4-sqlite3
```

##### Server Environment
```
PRG_HASH=http://usaserver.divsul.org:666/PRServer/cdhash_doacao/cdhash_main.txt
```
Http protection
```
PRG_HTTP_USER=
PRG_HTTP_PASSWORD=
```


### Sync and Updates
Check/Update Server Players
Cronjob
```
* * * * * php /var/www/pr-ghosting/artisan s:s
```


Run cron via http - 2
```
http://your_endpoint/crond
```
