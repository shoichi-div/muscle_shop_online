# MUSCLE_SHOP_ONLINE
 
筋トレグッズ専門のデモECサイトです。開発環境はdockerを使用しています。 
 
# URL
http://118.27.9.37/MUSCLE_SHOP_ONLINE/www/html

# 使用技術
- HTML&CSS
- php 7.3.11
- MySQL
- JavaScript
- docker
- bootstrap
 
# 機能一覧
- ユーザー機能
 - 新規登録、ログイン、ログアウト機能。パスワードはハッシュ化して管理。
- 商品検索機能
 - マーケットの商品をカテゴリ、部位、キーワード複数同時または個別で検索可能。
- 商品並べ替え機能
 - マーケットの商品を新しい順、価格の安い順、価格の高い順で並べ替えることができる。javascriptのイベントリスナーで実装。
- カート機能
 - マーケットで商品を個数を選びカートに追加できる。カート内商品の数量変更や削除ができる。カート画面ではカート内商品の小計と合計金額がわかる。カート内の商品を購入できる。
- 購入履歴、購入明細機能
 - ログインユーザーの購入履歴及び購入明細を表示。
- 累計使用金額表示機能
 - マーケット画面でログインユーザーの累計使用金額を'mi'として表示。非表示にもできる。
- 管理者機能
 - ユーザー名、パスワード共に'admin'でログインすると商品管理画面及びユーザー管理画面に遷移できるようになる。
 - 商品管理画面では、新規商品登録、既存商品の情報変更ができる。
 - adminでログイン時は全ユーザーの購入履歴、購入明細が確認できる。
- セキュリティ対策
 - XSS対策：変数はHTMLエスケープ処理後に出力
 - SQLインジェクション対策：sql文の変数はbindValueで代入
 - CSRF対策：POST投稿の際はトークンの生成を行い、受け取る際に照合を行う また、iframeの読み込み禁止
 - パスワードのハッシュ化

# 制作者

[@sho1_code](htpps://twitter.com/sho1_code)
