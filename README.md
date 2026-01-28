# Block Bindings Example

WordPress の Block Bindings API を使用するためのサンプルプラグインです。

## 概要

このプラグインは、WordPress 6.5 で導入された Block Bindings API の実装例を提供します。Block Bindings API を使用すると、ブロックの属性を動的なデータソース（カスタムフィールド、外部 API など）にバインドできます。

## 動作環境

- WordPress 6.5 以上
- PHP 7.4 以上

## インストール

1. このリポジトリをクローンまたはダウンロードします
2. `block-bindings-example` フォルダを `/wp-content/plugins/` ディレクトリにアップロードします
3. WordPress 管理画面の「プラグイン」メニューからプラグインを有効化します

## ファイル構成

```
/block-bindings-example/
├── block-bindings-example.php    # メインプラグインファイル
└── /includes/
    ├── binding-sources.php       # バインディングソースの登録
    ├── meta-fields.php           # カスタムフィールドの登録
    └── weather-api.php           # 天気 API 連携の実装例
```

## 機能

### カスタムフィールドのバインディング

投稿メタフィールド `block_bindings_image_url` を登録し、画像ブロックなどにバインドできます。

### 天気 API 連携

外部の天気 API からデータを取得し、ブロックに動的に表示するサンプル実装を含みます。

## 使用方法

### エディターでの使用

1. 投稿または固定ページの編集画面を開きます
2. 画像ブロックや段落ブロックを追加します
3. ブロックの設定パネルから「バインディング」オプションを選択します
4. 登録されたバインディングソースを選択してデータをバインドします

## 開発

### コーディング規約

このプラグインは WordPress Coding Standards に準拠しています。

```bash
# PHPCS でコードをチェック
composer run phpcs

# PHPCBF で自動修正
composer run phpcbf
```

## ライセンス

GPL-3.0 License

## 作者

Rocket Martue
