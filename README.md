# coachtechフリマ

## プロジェクト概要
coachtechフリマは、ユーザーが商品を出品・購入できるフリマアプリケーションです。

主な機能：

- 商品の出品・編集・削除

- 商品の検索・閲覧

- いいね機能

- コメント機能

- 商品購入（Stripe決済）

- ユーザー管理

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

## テスト用ユーザー情報

シーディング実行後、以下のテスト用ユーザーでログインできます：

### 管理者ユーザー
- **メールアドレス**: admin@example.com
- **パスワード**: password
- **役割**: 管理者（全機能利用可能）

### 一般ユーザー
- **メールアドレス**: test1@example.com
- **パスワード**: password
- **役割**: テストユーザー1

- **メールアドレス**: test2@example.com
- **パスワード**: password
- **役割**: テストユーザー2

- **メールアドレス**: customer@example.com
- **パスワード**: password
- **役割**: 購入テスト用ユーザー

- **メールアドレス**: seller@example.com
- **パスワード**: password
- **役割**: 販売者（商品管理テスト用）

## URL

-   開発環境：http://localhost/
-   phpMyAdmin：http://localhost:8080/