## Env
Create .env and fill 
- DB_USERNAME=admin
- DB_PASSWORD=pass
- DB_PORT=13307
- DB_HOST (your docker ip) 
- ELASTICSEARCH_HOSTS (your docker ip)

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

Generate app key:
```bash
php artisan key:generate
```

And make migration:
```bash
php artisan migrate
```

Install passport:
```bash
php artisan passport:install
```

Make seeds if you need:
```bash
php artisan db:seed
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
php artisan search:reindex
```

## Open Api documentation
You can find all documentation by link:
[Documentation](https://app.swaggerhub.com/apis/MAXRADJIAZP/drum-n_code_test/1.0.0)
