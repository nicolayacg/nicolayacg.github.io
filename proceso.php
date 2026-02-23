<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recepción y limpieza de datos
    $nombre = htmlspecialchars($_POST['nombre']);
    $documento = htmlspecialchars($_POST['documento']);
    $noches = intval($_POST['noches']);
    $habitacion = $_POST['habitacion'];
    $mascotas = intval($_POST['mascotas']);
    $adultos = intval($_POST['adultos']);
    $niños = intval($_POST['niños']);

    // 2. Configuración de Precios (Precios por noche)
    $tarifas = [
        "normal" => 150000,
        "doble"  => 250000,
        "vip"    => 450000
    ];

    $precio_base_noche = $tarifas[$habitacion];
    $subtotal = $precio_base_noche * $noches;

    // 3. Lógica Animalista y Descuentos
    $descuento = 0;
    $mensaje_especial = "";

    if ($mascotas > 0) {
        // Descuento del 10% por ser familia multiespecie
        $descuento = $subtotal * 0.10;
        $mensaje_especial = "🐾 ¡Gracias por viajar con tus peluditos! Se aplicó un 10% de descuento de familia animalista.";
    } else {
        $mensaje_especial = "🌿 Tu estancia ayuda a financiar nuestro refugio aliado para animales rescatados.";
    }

    $total_final = $subtotal - $descuento;

    // 4. Salida HTML mejorada
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Reserva - Natura & Huellas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4a7c59; --secondary: #8fc0a9; --accent: #faf3dd; --text: #2f3e46; }
        body { font-family: 'Poppins', sans-serif; background: #c8d5b9; display: flex; justify-content: center; padding: 40px; }
        .receipt { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-width: 500px; width: 100%; border-top: 10px solid var(--primary); }
        h1 { color: var(--primary); font-size: 22px; text-align: center; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .total-box { background: var(--accent); padding: 15px; border-radius: 10px; margin-top: 20px; text-align: center; }
        .total-price { font-size: 24px; font-weight: bold; color: var(--primary); }
        .badge { background: #e8f5e9; color: #2e7d32; padding: 10px; border-radius: 8px; font-size: 13px; margin-top: 15px; text-align: center; }
        .btn-back { display: block; text-align: center; margin-top: 25px; text-decoration: none; color: var(--primary); font-weight: 600; font-size: 14px; }
    </style>
</head>
<body>

<div class="receipt">
    <h1>Confirmación de Reserva</h1>
    <p style="text-align:center;">Huésped: <strong><?php echo $nombre; ?></strong></p>
    
    <div class="detail-row">
        <span>Habitación:</span>
        <span><?php echo ucfirst($habitacion); ?></span>
    </div>
    <div class="detail-row">
        <span>Estadía:</span>
        <span><?php echo $noches; ?> noches</span>
    </div>
    <div class="detail-row">
        <span>Huéspedes:</span>
        <span><?php echo "$adultos adultos, $niños niños"; ?></span>
    </div>
    <div class="detail-row">
        <span>Mascotas:</span>
        <span><?php echo $mascotas; ?> 🐕/🐈</span>
    </div>

    <div class="badge">
        <?php echo $mensaje_especial; ?>
    </div>

    <div class="total-box">
        <div style="font-size: 14px; color: #666;">Total a Pagar</div>
        <div class="total-price">$<?php echo number_format($total_final, 0, ',', '.'); ?> COP</div>
        <?php if($descuento > 0): ?>
            <small style="color: #2e7d32;">Ahorraste: $<?php echo number_format($descuento, 0, ',', '.'); ?></small>
        <?php endif; ?>
    </div>

    <a href="javascript:history.back()" class="btn-back">← Modificar datos</a>
</div>

</body>
</html>
<?php
} else {
    // Si alguien intenta entrar directamente al archivo sin enviar el formulario
    header("Location: index.html");
    exit();
}
?>