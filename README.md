# Block Bindings Example

WordPress の Block Bindings API を使用するためのサンプルプラグインです。

## 概要

このプラグインは、WordPress 6.5 で導入された Block Bindings API の実装例を提供します。Block Bindings API を使用すると、ブロックの属性を動的なデータソース（カスタムフィールド、外部 API など）にバインドできます。

## 参考資料

このプラグインは以下の記事を参考に作成しています：

- [WordPress Block Bindings APIの概要と使い方](https://kinsta.com/jp/blog/wordpress-block-bindings-api/) - Kinsta

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

以下の投稿メタフィールドを登録し、ブロックにバインドできます：

| メタキー | 説明 |
|---------|------|
| `block_bindings_city_name` | 都市名 |
| `block_bindings_image_url` | 都市画像のURL |
| `block_bindings_city_lat` | 緯度 |
| `block_bindings_city_lng` | 経度 |

### 天気 API 連携（カスタムバインディングソース）

`bb/weather-condition` というカスタムバインディングソースを登録し、[Open-Meteo API](https://open-meteo.com/) から取得した天気データをブロックに動的に表示できます。

取得できるデータ：
- `temperature` - 現在の気温（°C）
- `weather_state` - 天気の状態（clear, cloudy, rainy, snowy, thunderstorm）

天気データは30分間キャッシュされ、API呼び出し回数を削減します。

### 未実装の機能

参考記事の「[カスタムバインディングソースのUIを作成する方法](https://kinsta.com/jp/blog/wordpress-block-bindings-api/#ui)」セクション（WordPress 6.9 以降で利用可能）はまだ実装されていません。

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
