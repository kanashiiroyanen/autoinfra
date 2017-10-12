# autoinfra
====  
社内環境を模したインフラを簡易に構築できるツール。
VMware ESXi 上の VM で OA 端末を、Docker コンテナ上で社内サーバを構築することを想定している。
まだ、開発途中

## Desciription
Web インタフェースから操作が可能
1. VMware ESXi と vCenter 上で動作する VM (Windows) の作成
2. VM に任意アプリのインストール (Ansible, chocolatey を利用)
3. Linux サーバの作成 (Ansible, Docker を利用)

## Requirement
1. 管理ツールの利用
 - 下記のソフトが動作する Linux を準備
 - PHP, Python, Ansible をインストール
2. 仮想化環境で必要なもの
 - VMware ESXi
 - vCenter
 - クローンする VM のテンプレート
3. VM (OA 端末、Windows) で必要なもの
 - WinRM の有効化
 - PowerShell 4.0 以上のインストール
4. 社内サーバ環境の作成
 - Docker が動作する OS を用意

## Usage
VMware ESXi, vCenter, 管理ツールは導入済みである前提で記す。
また、vCenter でテンプレートを作成する VM には、WinRM と PowerShell 4.0 以上をインストールしておくことが望ましい。
1. Windows Clone の作成
 - autoinfra.php を開く
 - Windows のクローンのタブを選択
 - 項目を入力し、送信ボタンをクリック
 - クローンが開始される
2. Windows (VM) の設定
 - autoinfra.php を開く
 - Windows の設定のタブを選択
 - 項目を入力し、送信ボタンをクリック
 - 任意のアプリが VM にインストールされる
3. 社内サーバの設定
 - autoinfra.php を開く
 - サーバ の設定のタブを選択
 - 項目を入力し、送信ボタンをクリック
 - Docker, Docker-Compose のインストール、サーバの起動がはじまる

## License
* MIT
  * see LICENSE.txt
