<?PHP
	error_reporting(E_ALL);
?>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.5">

	<style>
	
	a{
		display:inline-block;
		background-color:#ccccff;
		padding:10px;
		margin:5px;
	}

	a.value0{
		background-color:#ffcccc;
	}

	a.value1{
		background-color:#ccffcc;
	}

	</style>

</head>

<body>

<?PHP


if(isset($_REQUEST['writeout'])){
	
	$exec = __DIR__.'/piface '.$_REQUEST['writeout'].' '.$_REQUEST['value'];

	$json_return = shell_exec($exec);

}else{
	
	$exec = __DIR__.'/piface';

	$json_return = shell_exec($exec);

}

$pins = json_decode($json_return);

foreach($pins as $key => $pin){

	echo ($key%2 ? '' : '<br/>');
	
?>
	
	<a href="?writeout=<?=$pin->outpin ?>&value=<?=($pin->value ? 0 : 1); ?>" class="value<?=$pin->value; ?>"><?=$pin->outpin ?></a>
	
	<?PHP
}

?>

</body>

</html>
