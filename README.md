# coachtechフリマ


## 環境構築手順

-   コンテナを立ち上げる

```
docker compose up -d --build
```

-   env ファイルの作成をする

```
cp src/.env.example src/.env
```

-   php にコンテナに入る

```
docker compose exec php bash
```

-   composer パッケージをインストールする

```
composer install
```

-   アプリケーションキーを作成する

```
php artisan key:generate
```

-   マイグレーションを実行する

```
php artisan migrate
```

-   シーディングを実行する

```
php artisan db:seed
```

-   ストレージと公開ディレクトリをリンクする

```
php artisan storage:link
```


## 使用技術（実行環境）
-   PHP 8.4.5
-   Laravel 8.83.29
-   MySQL 8.0.26


## ER図
![Image](https://github.com/user-attachments/assets/b195e14b-a9be-4302-b91a-708f7ef1995b)

## URL

-   開発環境：http://localhost/
-   phpMyAdmin：http://localhost:8080/