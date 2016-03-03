<?php

include 'util.php';
class u extends \utilphp\util { }

$artifacts = $_SERVER['DOCUMENT_ROOT'].'/artifacts/packages';
if (!is_writable($artifacts))
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
	echo "Posible ataque de subida de ficheros\n";
}

// echo 'Mas informacion de depuracion:';
// u::var_dump($_FILES);

?>

<form enctype="multipart/form-data" action="upload.php" method="POST">
    Enviar este fichero: <input name="uploaded" type="file" />
    <input type="submit" value="Enviar fichero" />
</form>

