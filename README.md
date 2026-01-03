# Admin Calendar App

Laravel + FullCalendar を使った **管理画面向けアプリケーション**です。  
ログイン認証付きで、お知らせ管理と個人用カレンダー機能を備えています。

---

## ✨ 主な機能

### 🔐 認証
- Laravel Breeze を使用
- ログイン必須の管理画面
- 未ログイン時は `/admin/*` にアクセス不可

---

### 📰 お知らせ管理（管理画面）
- お知らせの一覧表示
- 作成 / 編集 / 削除
- 詳細表示
- 重要度（1〜5）設定

---

### 📅 個人カレンダー
- FullCalendar を使用
- ログインユーザーごとに予定を管理
- 予定の
  - 追加
  - 詳細表示
  - 編集
  - 削除
- モーダルUIで操作可能

---

## 🖥️ 使用技術

- Laravel
- PHP 8.x
- MySQL
- Laravel Breeze
- Blade
- Vite
- FullCalendar
- JavaScript

---

## 📂 ディレクトリ構成（抜粋）

app/
└ Http/Controllers/Admin
├ EventController.php
└ NewsController.php

resources/
├ views/
│ ├ layouts/admin.blade.php
│ └ admin/calendar.blade.php
└ js/
└ admin-calendar.js

routes/
└ web.php

yaml
コードをコピーする

---

## 🚀 セットアップ手順（ローカル）

### 1️⃣ リポジトリをクローン
```bash
git clone https://github.com/【GitHubユーザー名】/【リポジトリ名】.git
cd 【リポジトリ名】
2️⃣ PHP 依存関係をインストール
bash
コードをコピーする
composer install
3️⃣ フロントエンド依存関係をインストール
bash
コードをコピーする
npm install
4️⃣ 環境ファイルを作成
bash
コードをコピーする
cp .env.example .env
php artisan key:generate
※ .env 内の DB接続情報 を自分の環境に合わせて設定してください。

5️⃣ データベース準備
bash
コードをコピーする
php artisan migrate
6️⃣ サーバー起動
bash
コードをコピーする
php artisan serve
別ターミナルで：

bash
コードをコピーする
npm run dev
7️⃣ ブラウザでアクセス
text
コードをコピーする
http://127.0.0.1:8000/login
ログイン後：

text
コードをコピーする
http://127.0.0.1:8000/admin/calendar
🔒 セキュリティについて
.env は GitHub に含めていません

管理画面は auth ミドルウェアで保護しています

本番公開時は APP_DEBUG=false を推奨します

📝 補足
本プロジェクトは 学習・ポートフォリオ用途を想定しています

機能拡張（チーム共有、権限管理など）も可能な構成です

