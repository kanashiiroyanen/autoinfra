<?php
//mb_language("japanese");
//mb_internal_encoding("utf-8");

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
    $temp = $_POST["temp"];
    $vm = $_POST["vm"];
    $vmnum = $_POST["vmnum"];
    $dstore= $_POST["dstore"];
    $portgr= $_POST["portgr"];

    command_exec('pip install pyvmomi');
    command_exec('git clone https://github.com/vmware/pyvmomi-community-samples ~/.');
    command_exec('cd ~/pyvmomi-community-samples/sampl');

	// clone vm
	$exec = './clone_vm.py -s ' . $ipaddr . ' --user ' $user . ' --password '. $VC_PASS . ' --template ' . $temp . ' --vm-name ' . $vm . ' --datastore-name ' . $dstore . ' --resource-pool pool1 --no-power-on';
    command_exec($exec);

	// add nic
	$exec = './add_nic_to_vm.py -s ' . $ipaddr . ' --user ' $user . ' --password '. $VC_PASS . ' --vm-name ' . $vm . ' --port-group \'' . $portgr . '\'';
    command_exec($exec);
	            
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
temp: <?=$temp ?><br />
vmname: <?=$vm ?><br />
vmnum: <?=$vmnum ?><br />
dstore: <?=$dstore ?><br />
portgr: <?=$portgr?><br />
</body>
</html>
