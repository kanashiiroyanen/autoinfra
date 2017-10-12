<?php
//mb_language("japanese");
//mb_internal_encoding("utf-8");

// create ansible hosts
function create_hosts($ipaddr, $user, $pass)
{
    $hosts = "infra_hosts";
    if (!file_exists($hosts)) {
        touch($hosts);
    }

    $data = "[docker]" . "\n" . $ipaddr . "\n\n";
    $data .= "[docker:vars]" . "\n" . "ansible_ssh_user=" . $user . "\n" . "ansible_ssh_pass=" . $pass . "\n";
    $data .= "ansible_sudo_pass=" . $pass;

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

// create ansible playbook (install docker on ubuntu)
function create_playbook($user)
{

	// play-book の作成
    $book = "docker.yml";
    if (!file_exists($book)) {
        touch($book);
    }

    $data = "- hosts: all" . "\n";
    $data .= "  sudo: yes" . "\n";
    $data .= "  tasks:" . "\n";

    $data .= "    - name: install docker.." . "\n";
    $data .= "      apt: name={{item}} state=present update_cache=yes" . "\n";
    $data .= "      with_items:" . "\n";
    $data .= "        - apt-transport-https" . "\n";
    $data .= "        - ca-certificates" . "\n";
    $data .= "        - curl" . "\n";
    $data .= "        - software-properties-common" . "\n";

    $data .= "    - name: Add Docker's official GPG Key" . "\n";
    $data .= "      shell: curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -" . "\n";

    $data .= "    - name: Verify fingerprint" . "\n";
    $data .= "      shell: sudo apt-key fingerprint 0EBFCD88" . "\n";

    $data .= "    - name: following stable repository" . "\n";
    $data .= "      shell: sudo add-apt-repository \"deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable\"" . "\n";

    $data .= "    - name: Update apt package index" . "\n";
    $data .= "      shell: sudo apt-get update" . "\n";

    $data .= "    - name: install Docker-CE" . "\n";
    $data .= "      apt: name={{item}} state=present update_cache=yes" . "\n";
    $data .= "      with_items:" . "\n";
    $data .= "        - docker-ce" . "\n";

    $data .= "    - name: docker test run" . "\n";
    $data .= "      shell: sudo docker run hello-world" . "\n";

    $data .= "    - name: Download Docker Compose" . "\n";
    $data .= "      shell: sudo curl -L https://github.com/docker/compose/releases/download/1.16.1/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose" . "\n";

    $data .= "    - name: Apply executable permissions to the binary" . "\n";
    $data .= "      shell: sudo chmod +x /usr/local/bin/docker-compose" . "\n";

    $data .= "    - name: docker run (web, dns, db)" . "\n";
    $data .= "      shell: sudo docker-compose up -d chdir=/home/" . $user . "/docker/docker_compose" . "\n";

    chmod($book, 0666);

    $rel = file_put_contents($book, $data);
    $current = file_get_contents($book);
    //print_r($current);
}

function create_dcfile()
{
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
    $web = $_POST["web"];
    $dns = $_POST["dns"];
    $db = $_POST["db"];

	create_hosts($ipaddr, $user, $pass);
    command_exec('ansible windows -i infra_hosts -m ping -vvvv');
	create_playbook($user);
	//command_exec('ansible-playbook -i infra_hosts docker.yml');
	//create_dcfile();
	
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
web: <?=$web ?><br />
DNS: <?=$dns ?><br />
DB: <?=$db ?><br />
</body>
</html>
