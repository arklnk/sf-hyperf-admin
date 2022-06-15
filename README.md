## 创建网络

```shell
docker network create ark-net
```

## 启动redis容器

```shell
docker run --name redis -d --net ark-net redis:latest
```

## 启动mysql容器

```shell
docker run --name mysql5.7 -e MYSQL_ROOT_PASSWORD=root -d --net ark-net mysql:5.7
```

## 启动phpmyadmin容器

```shell
docker run --name phpmyadmin -d -e PMA_HOST=mysql5.7 -p 8080:80 --net ark-net phpmyadmin:latest
```

## 启动ark-admin容器

```shell
git clone https://github.com/arklnk/sf-hyperf-admin.git

mv sf-hyperf-admin /sf-hyperf-admin

docker run --name sf-hyperf-admin -v /sf-hyperf-admin:/sf-hyperf-admin -p 9501:9501 -p 9502:9502 -itd --net ark-net --privileged -u root --entrypoint /bin/sh hyperf/hyperf:7.4-alpine-v3.11-swoole
```

## 导入数据

访问phpmyadmin：http://127.0.0.1:8080

账号：root

密码：root

新建数据库sf_admin，并导入sf-hyperf-admin/sql目录下的init.sql

## 修改配置

（复制sf-hyperf-admin目录下的.env.example为.env）

```text
APP_NAME=skeleton
APP_ENV=dev

DB_DRIVER=mysql
DB_HOST=mysql5.7
DB_PORT=3306
DB_DATABASE=sf_admin
DB_USERNAME=root
DB_PASSWORD=root
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
DB_PREFIX=

REDIS_HOST=redis
REDIS_AUTH=(null)
REDIS_PORT=6379
REDIS_DB=0

JWT_KEY=jwt
JWT_EXPIRE=86400

CAPTCHA_TTL=300
CAPTCHA_CHARSET=123456789
```

## 初始化超级管理员

```text
php bin/hyperf.php ark:admin arkadmin 123456
```

> 执行命令后，初始化的超级管理员为
>
> 账号：arkadmin
>
> 密码：123456

## 启动服务

进入sf-hyperf-admin容器执行命令

```shell
cd /sf-hyperf-admin

composer install

php bin/hyperf.php server:watch
```