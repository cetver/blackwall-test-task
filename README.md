# Необходимые программы

- git
- docker
- docker-compose
- find
- sed
- curl
- jq

# Установка

```shell script
git clone https://github.com/cetver/blackwall-test-task -- /project/dir
cd /project/dir
```

# Настройка docker'a

`closest-country-code` - https://www.debian.org/mirror/list -> `ctrl+f` -> Primary Debian mirror sites -> `f3`
```shell script
find .docker -type f -name .gitignore -exec rm --verbose --recursive --force {} \;
sed --regexp-extended --in-place \
    --expression "s@/var/www/blackwall-test-task@/project/dir@" \
    --expression "s@SOURCES_LIST_COUNTRY_CODE: md@SOURCES_LIST_COUNTRY_CODE: <closest-country-code>@" \
    .docker/docker-compose.yml
.docker/setup/copy-common-scripts
docker-compose --file .docker/docker-compose.yml up --detach --build
```

# Настройка проекта

```shell script
echo "
##
# Blackwall ac test task    
##

127.0.0.1    blackwall-ac-test-task.loc
" | sudo tee --append /etc/hosts

docker-compose --file .docker/docker-compose.yml exec blackwall-ac-test-task-php /bin/bash --login

blackwall-ac-test-task@php7_4-debian:/var/www/html$ composer install
blackwall-ac-test-task@php7_4-debian:/var/www/html$ php artisan migrate
```

# Использование

**Создание игры**

- Случайное поле
```shell script
curl \
    --compressed \
    --silent \
    --show-error \
    --request POST \
    --header 'Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=' \
    --header 'Accept: application/json' \
    'http://blackwall-ac-test-task.loc/api/game' | jq
```
- Заданное поле
```shell script
curl \
    --compressed \
    --silent \
    --show-error \
    --request POST \
    --header 'Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/x-www-form-urlencoded' \
    --data 'tiles=041215090213140305070806110110' \
    'http://blackwall-ac-test-task.loc/api/game' | jq
```

**Проверка ходов**
```shell script
curl \
    --compressed \
    --verbose \
    --show-error \
    --request POST \
    --header 'Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=' \
    --header 'Accept: application/json' \
    --header 'Content-Type: application/json' \
    --data '{
                "moves": [
                    [4, 12, 15, 9, 2, 13, 14, 3, 5, 7, 8, 6, 11, 1, 10, 0],
                    [4, 12, 15, 9, 2, 13, 14, 3, 5, 7, 8, 0, 11, 1, 10, 6],
                    [4, 12, 15, 9, 2, 13, 14, 3, 5, 7, 0, 8, 11, 1, 10, 6],
                    [4, 12, 15, 9, 2, 13, 14, 3, 5, 0, 7, 8, 11, 1, 10, 6],
                    [4, 12, 15, 9, 2, 0, 14, 3, 5, 13, 7, 8, 11, 1, 10, 6],
                    [4, 12, 15, 9, 2, 14, 0, 3, 5, 13, 7, 8, 11, 1, 10, 6],
                    [4, 12, 15, 9, 2, 14, 3, 0, 5, 13, 7, 8, 11, 1, 10, 6],
                    [4, 12, 15, 0, 2, 14, 3, 9, 5, 13, 7, 8, 11, 1, 10, 6],
                    [4, 12, 0, 15, 2, 14, 3, 9, 5, 13, 7, 8, 11, 1, 10, 6],
                    [4, 0, 12, 15, 2, 14, 3, 9, 5, 13, 7, 8, 11, 1, 10, 6],
                    [0, 4, 12, 15, 2, 14, 3, 9, 5, 13, 7, 8, 11, 1, 10, 6],
                    [2, 4, 12, 15, 0, 14, 3, 9, 5, 13, 7, 8, 11, 1, 10, 6],
                    [2, 4, 12, 15, 5, 14, 3, 9, 0, 13, 7, 8, 11, 1, 10, 6],
                    [2, 4, 12, 15, 5, 14, 3, 9, 13, 0, 7, 8, 11, 1, 10, 6],
                    [2, 4, 12, 15, 5, 14, 3, 9, 13, 1, 7, 8, 11, 0, 10, 6],
                    [2, 4, 12, 15, 5, 14, 3, 9, 13, 1, 7, 8, 0, 11, 10, 6],
                    [2, 4, 12, 15, 5, 14, 3, 9, 0, 1, 7, 8, 13, 11, 10, 6],
                    [2, 4, 12, 15, 5, 14, 3, 9, 1, 0, 7, 8, 13, 11, 10, 6],
                    [2, 4, 12, 15, 5, 0, 3, 9, 1, 14, 7, 8, 13, 11, 10, 6],
                    [2, 4, 12, 15, 5, 3, 0, 9, 1, 14, 7, 8, 13, 11, 10, 6],
                    [2, 4, 12, 15, 5, 3, 9, 0, 1, 14, 7, 8, 13, 11, 10, 6],
                    [2, 4, 12, 0, 5, 3, 9, 15, 1, 14, 7, 8, 13, 11, 10, 6],
                    [2, 4, 0, 12, 5, 3, 9, 15, 1, 14, 7, 8, 13, 11, 10, 6],
                    [2, 0, 4, 12, 5, 3, 9, 15, 1, 14, 7, 8, 13, 11, 10, 6],
                    [2, 3, 4, 12, 5, 0, 9, 15, 1, 14, 7, 8, 13, 11, 10, 6],
                    [2, 3, 4, 12, 5, 9, 0, 15, 1, 14, 7, 8, 13, 11, 10, 6],
                    [2, 3, 4, 12, 5, 9, 7, 15, 1, 14, 0, 8, 13, 11, 10, 6],
                    [2, 3, 4, 12, 5, 9, 7, 15, 1, 14, 8, 0, 13, 11, 10, 6],
                    [2, 3, 4, 12, 5, 9, 7, 0, 1, 14, 8, 15, 13, 11, 10, 6],
                    [2, 3, 4, 0, 5, 9, 7, 12, 1, 14, 8, 15, 13, 11, 10, 6],
                    [2, 3, 0, 4, 5, 9, 7, 12, 1, 14, 8, 15, 13, 11, 10, 6],
                    [2, 3, 7, 4, 5, 9, 0, 12, 1, 14, 8, 15, 13, 11, 10, 6],
                    [2, 3, 7, 4, 5, 9, 8, 12, 1, 14, 0, 15, 13, 11, 10, 6],
                    [2, 3, 7, 4, 5, 9, 8, 12, 1, 14, 10, 15, 13, 11, 0, 6],
                    [2, 3, 7, 4, 5, 9, 8, 12, 1, 14, 10, 15, 13, 11, 6, 0],
                    [2, 3, 7, 4, 5, 9, 8, 12, 1, 14, 10, 0, 13, 11, 6, 15],
                    [2, 3, 7, 4, 5, 9, 8, 12, 1, 14, 0, 10, 13, 11, 6, 15],
                    [2, 3, 7, 4, 5, 9, 8, 12, 1, 14, 6, 10, 13, 11, 0, 15],
                    [2, 3, 7, 4, 5, 9, 8, 12, 1, 14, 6, 10, 13, 0, 11, 15],
                    [2, 3, 7, 4, 5, 9, 8, 12, 1, 0, 6, 10, 13, 14, 11, 15],
                    [2, 3, 7, 4, 5, 0, 8, 12, 1, 9, 6, 10, 13, 14, 11, 15],
                    [2, 3, 7, 4, 0, 5, 8, 12, 1, 9, 6, 10, 13, 14, 11, 15],
                    [2, 3, 7, 4, 1, 5, 8, 12, 0, 9, 6, 10, 13, 14, 11, 15],
                    [2, 3, 7, 4, 1, 5, 8, 12, 9, 0, 6, 10, 13, 14, 11, 15],
                    [2, 3, 7, 4, 1, 5, 8, 12, 9, 6, 0, 10, 13, 14, 11, 15],
                    [2, 3, 7, 4, 1, 5, 8, 12, 9, 6, 10, 0, 13, 14, 11, 15],
                    [2, 3, 7, 4, 1, 5, 8, 0, 9, 6, 10, 12, 13, 14, 11, 15],
                    [2, 3, 7, 4, 1, 5, 0, 8, 9, 6, 10, 12, 13, 14, 11, 15],
                    [2, 3, 0, 4, 1, 5, 7, 8, 9, 6, 10, 12, 13, 14, 11, 15],
                    [2, 0, 3, 4, 1, 5, 7, 8, 9, 6, 10, 12, 13, 14, 11, 15],
                    [0, 2, 3, 4, 1, 5, 7, 8, 9, 6, 10, 12, 13, 14, 11, 15],
                    [1, 2, 3, 4, 0, 5, 7, 8, 9, 6, 10, 12, 13, 14, 11, 15],
                    [1, 2, 3, 4, 5, 0, 7, 8, 9, 6, 10, 12, 13, 14, 11, 15],
                    [1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 10, 12, 13, 14, 11, 15],
                    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 0, 12, 13, 14, 11, 15],
                    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 0, 15],
                    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 0]
                ]    
            }' \
    'http://blackwall-ac-test-task.loc/api/game/<create-game-response.body.id>/solve' | jq
```

# Прочее

**Redis**
```shell script
docker-compose --file .docker/docker-compose.yml exec blackwall-ac-test-task-redis /bin/bash --login
root@blackwall-ac-test-task-redis_6-debian:/data# redis-cli -s /var/run/redis/redis.sock monitor
```

**Postgres**
```shell script
docker-compose --file .docker/docker-compose.yml exec blackwall-ac-test-task-postgresql /bin/bash --login
root@blackwall-ac-test-task-postgresql_12-debian:/# psql -U postgres
postgres=# \c blackwall-ac-test-task
blackwall-ac-test-task=# \dt
```
