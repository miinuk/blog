<?php 

    define('HOST','sql109.epizy.com');
	define('DB','epiz_28912433_bd_escola');
	define('USERS','epiz_28912433');
	define('PASS','willian573');

	try{
		$pdo = new PDO('mysql:dbname=bd_escola1;host=localhost','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		//echo "Conectado com sucesso";
	}catch(Exception $erro){
		echo 'Erro ao conectar';
	}

    if(isset($_POST['enviar'])){
        $aluno = $_POST['aluno'];
        $disciplina = $_POST['disciplina'];
        $nota1 = $_POST['nota1'];
        $nota2 = $_POST['nota2'];

        $sql = $pdo->prepare("INSERT INTO alunos VALUES (?,?,?,?,null)");
        $sql->execute(array($aluno,$disciplina,$nota1,$nota2));
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="post">
        <input type="text" name="aluno">
        <input type="text" name="disciplina">
        <input type="text" name="nota1">
        <input type="text" name="nota2">
        <input type="submit" name="enviar" value="Enviar">
    </form>

    <br><br><br><br><br> 

    <?php 

        $sql2 = $pdo->prepare("SELECT * FROM alunos");
        $sql2->execute();
        $info = $sql2->fetchAll();  

        foreach ($info as $key => $value) {  
            $media = (int) (($value['nota1'] + ($value['nota2']*2))/3);

            echo '<form method="post">';

            $id = $value['id'];

            if(isset($POST['apagar'.$id])){
                $sql3 = $pdo->prepare("DELETE FROM alunos WHERE id=?");
                $sql3->execute(array($id));
                echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
            }
            ?>
            
            <h1>
            <span style="margin:20px; color:blue; padding:10px;"><?php echo $value['aluno']; ?></span>
            <span style="margin:20px; color:red; padding:10px;"><?php echo $value['disciplina']; ?></span>
            <span style="margin:20px; color:green; padding:10px;"><?php echo $value['nota1']; ?></span>
            <span style="margin:20px; color:orange; padding:10px;"><?php echo $value['nota2']; ?></span>
            <span style="margin:20px; color:black; padding:10px;">Média: <?php echo $media ?></span>

            <input style="background-color:blue;color:white;" name="apagar_<?php echo $value['id']; ?>" type="submit" value="Apagar">

            </h1>

            <br>

            </form>
        <?php } ?>

</body>
</html>