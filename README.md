## Docker
I used next ports for docker services:

- Webserver - 10080
- DB - 13307
- ElasticSearch - 9200

You can change it in `docker-compose.yml`

Start composer containers:
```bash
docker-compose up -d
```

## First launch
After you've run docker containers, install composer packages:
```bash
composer install
```

And make migration with seeds:
```bash
php artisan migrate --seed
```

All users, that you will create in this way will have password = `12345678`

##Artisan commands for ElasticSearch 

### Create mapping scheme
This command should be used after upping containers:
```bash
php artisan search:add-scheme
```

### Reindex Tasks table
If you need reindex all tasks in DB, use:
```bash
php artisansearch:reindex
```

## Open Api documentation
You can find all documentation by link:
[Documentation](https://app.swaggerhub.com/apis/MAXRADJIAZP/drum-n_code_test/1.0.0)
