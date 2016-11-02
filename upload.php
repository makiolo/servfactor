<?php
ini_set('upload_max_filesize', '400M');
ini_set('post_max_size', '400M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);

include 'util.php';
class u extends \utilphp\util { }

$artifacts = $_SERVER['DOCUMENT_ROOT'].'/packages';
if(!is_writable($artifacts))
{
	chmod($artifacts, 0777);
	echo "I don't have permission";
	exit;
}

$uploaded_file = $artifacts . "/" . basename($_FILES['uploaded']['name']);
if (move_uploaded_file($_FILES['uploaded']['tmp_name'], $uploaded_file))
{
	echo "El fichero es valido y se subio con exito.\n";
}
else
{
?>
	<form enctype="multipart/form-data" action="upload.php" method="POST">
	    Enviar este fichero: <input name="uploaded" type="file" />
	    <input type="submit" value="Enviar fichero" />
	</form>
<?php
	exit 1;
}

// echo 'Mas informacion de depuracion:';
// u::var_dump($_FILES);

?>

