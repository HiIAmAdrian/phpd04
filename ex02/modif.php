<?php
if (!empty($_POST['newpw']) && !empty($_POST['oldpw']) && !empty($_POST['login']) && $_POST['submit'] != "OK")
{
	if (!file_exists("../private"))
		mkdir("../private");
	if (!file_exists("../private/passwd"))
		file_put_contents("../private/passwd", NULL);

	$tmp = array('login' => $_POST['login'], 'oldpw' => $_POST['oldpw']);
	$content = unserialize(file_get_contents("../private/passwd"));
	$ok = 0;
	if ($content)
	{
		$log = 0;
		foreach($content as $key => $v)
		{
			print_r($v);
			if ($v['login'] == $tmp['login'])
			{
				$log = 1;
				if (hash("sha256",$tmp['oldpw']) != $v['passwd'])
					$ok = 1;
				else
					unset($content[$k]);
			}
		}
	}
	if ($ok == 1 || !$log)
		echo "ERROR\n";
	else
	{
//ramane de schimbat in tmp oldpwd cu passwd
		$tmp['oldpw'] = hash("sha256",$tmp['newpw']);
		$content[] = $tmp;
		file_put_contents("../private/passwd", serialize($content));
		echo "OK\n";
	}
}
else
	echo "ERROR\n";
?>
