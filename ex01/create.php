<?php
if (!empty($_POST['passwd']) && !empty($_POST['login']) && $_POST['submit'] != "OK")
{
	if (!file_exists("../private"))
		mkdir("../private");
	if (!file_exists("../private/passwd"))
		file_put_contents("../private/passwd", NULL);

	$tmp = array('login' => $_POST['login'], 'passwd' => $_POST['passwd']);
	$content = unserialize(file_get_contents("../private/passwd"));
	$ok = 0;
	if ($content)
	{
		foreach($content as $key => $v)
		{
			print_r($v);
			if ($v['login'] == $tmp['login'])// && hash("sha256",$tmp['passwd']) != $v['passwd'])
				$ok = 1;
		}
	}
	if ($ok)
		echo "ERROR\n";
	else
	{
		$tmp['passwd'] = hash("sha256",$tmp['passwd']);
		$content[] = $tmp;
		file_put_contents("../private/passwd", serialize($content));
		echo "OK\n";
	}
}
else
	echo "ERROR\n";
?>
