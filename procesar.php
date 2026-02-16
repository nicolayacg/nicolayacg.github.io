<?php
$kilo = $_POST['cantidad'];
$valor = $_POST['precio'];
$total = $kilo * $valor;
echo "El total es: " . $total;

?>