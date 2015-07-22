<?PHP
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
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

if(isset($_REQUEST['init'])){
	
	//Append 2>&1 returns the error stream
	//This requires the www-data user can sudo comands
	//Add the following line to the bottom of /etc/sodoers
	//www-data ALL=(root) NOPASSWD:ALL
	$exec = 'sudo '.__DIR__.'/piface init 2>&1';

    $json_return = shell_exec($exec);


}elseif(isset($_REQUEST['writeout'])){
	
	$exec = __DIR__.'/piface write '.$_REQUEST['writeout'].' '.$_REQUEST['value'];

	$json_return = shell_exec($exec);

}else{
	
	$exec = __DIR__.'/piface';

	$json_return = shell_exec($exec);

}

$pins = json_decode($json_return);

if($pins!==NULL){
	
	?>	
	 <a href="?init">(re)init PiFace</a>
	<?PHP

	foreach($pins as $key => $pin){

		echo ($key%2 ? '' : '<br/>');
		
		?>
		
		<a href="?writeout=<?=$pin->outpin ?>&value=<?=($pin->value ? 0 : 1); ?>" class="value<?=$pin->value; ?>"><?=$pin->outpin ?></a>
		
		<?PHP
	}

}else{

	echo 'Cannot decode JSON string: <pre>'.$json_return.'</pre>';

}

?>

</body>

</html>
