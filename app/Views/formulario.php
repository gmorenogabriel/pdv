<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
    helper('form');
    echo form_open('home/nuevoCliente')
?>
Nombre:<input type="text" name="nombre" value="<?= old('nombre') ?>"><br>
Email :<input type="text" name="email"  value="<?= old('nombre') ?>"><br>
<input type="submit" value="guardar">
<?php if(isset($error)):?>
    <p><?= $error->listErrors() ?></p>
<?php endif; ?>
<?= form_close() ?>

</body>
</html>