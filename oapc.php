<?php
//mb_language("japanese");
//mb_internal_encoding("utf-8");

// create ansible hosts
function create_hosts($ipaddr, $user, $pass)
{
    $hosts = "oa_hosts";
    if (!file_exists($hosts)) {
        touch($hosts);
    }

    $data = "[windows]" . "\n" . $ipaddr . "\n\n";
    $data .= "[windows:vars]" . "\n" . "ansible_user=" . $user . "\n" . "ansible_password=" . $pass . "\n";
    $data .= "ansible_port=5986" . "\n" . "ansible_connection=winrm" . "\n" . "ansible_winrm_server_cert_validation=ignore";

    chmod($hosts, 0666);
	/*
    if (is_writable($hosts)) {
        echo 'ok';
    } else {
        echo 'bad';
    }
	*/

    $rel = file_put_contents($hosts, $data);
    $current = file_get_contents($hosts);
    //print_r($current);
}

// create ansible playbook
function create_playbook($soft)
{
	// インストールするソフトを配列に代入
	$softs = explode(',', $soft);
	//print_r($softs);
	//print(count($softs));

	// play-book の作成
    $book = "oainst.yml";
    if (!file_exists($book)) {
        touch($book);
    }

    $data = "- hosts: windows". "\n";
    $data .= "  tasks:" . "\n";
    $data .= "    - win_stat: path=C:\ProgramData\chocolatey\\\bin\chocolatey.exe" . "\n";
    $data .= "      register: file_info" . "\n";
    $data .= "    - script: chocolatey.ps1" . "\n";
    $data .= "      when: file_info.stat.exists == false" . "\n";
    $data .= "    - raw: cinst {{ item }} -y" . "\n";
    $data .= "      with_items:" . "\n";

	foreach ($softs as $insoft) {
    	$data .= "        - " . $insoft . "\n";
	}

    chmod($book, 0666);

    $rel = file_put_contents($book, $data);
    $current = file_get_contents($book);
    //print_r($current);
}

// exec command
function command_exec($cmd)
{
    exec($cmd, $opt, $return_var);
    print_r($opt);

    //$out = shell_exec('ls -l');
    //print_r($out);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ipaddr = $_POST["ipaddr"];
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    $soft = $_POST["soft"];

	create_hosts($ipaddr, $user, $pass);
    command_exec('ansible windows -i oa_hosts -m ping -vvvv');
    //command_exec('ansible windows -i hosts -m raw -a "iex ((new-object net.webclient).DownloadString(\'https://chocolatey.org/install.ps1\'))"');
	create_playbook($soft);
    command_exec('ansible-playbook -i oa_hosts oainst.yml');
	
    //$fp = fopen("./hosts", "r");
    //while ($line = fgets($fp)) {
    //    echo "$line<br />";
    //}
    //fclose($fp);



    //echo $ipaddr;
} else {
    echo "フォームからアクセスしてください";
    exit(1);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>HTMLフォームのPOSTの受信テスト</title>
</head>
<body>
送信されたデータは、<br />
ipaddr: <?=$ipaddr ?><br />
user: <?=$user ?><br />
pass: <?=$pass ?><br />
soft: <?=$soft ?><br />
</body>
</html>
