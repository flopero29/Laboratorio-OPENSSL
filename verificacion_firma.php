<?php
// Ocultar warnings de deprecated
error_reporting(E_ALL & ~E_DEPRECATED);

echo "<h1> Verificación de Firma Digital</h1>";

// Buscar archivos disponibles
$publicKeyFile = file_exists('keys/public_key.pem') ? 'keys/public_key.pem' : 'keys/public_key_alt.pem';

if (!file_exists($publicKeyFile) || !file_exists('keys/mensaje.txt') || !file_exists('keys/firma.bin')) {
    die(" Faltan archivos necesarios. <a href='firma.php'>Firmar mensaje primero</a>");
}

// Cargar clave pública
$publicKeyPem = file_get_contents($publicKeyFile);
$publicKey = openssl_pkey_get_public($publicKeyPem);

if ($publicKey === false) {
    die(" Error al cargar clave pública: " . openssl_error_string());
}

// Cargar mensaje y firma
$mensaje = file_get_contents('keys/mensaje.txt');
$firma = file_get_contents('keys/firma.bin');

echo "<h2> Mensaje Original:</h2>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #007bff;'>";
echo htmlspecialchars($mensaje);
echo "</div>";

echo "<h2> Clave Pública Utilizada:</h2>";
echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 5px; font-size: 12px;'>";
echo nl2br(htmlspecialchars(substr($publicKeyPem, 0, 200) . "..."));
echo "</div>";

// Verificar la firma
$resultado = openssl_verify($mensaje, $firma, $publicKey, OPENSSL_ALGO_SHA256);

echo "<h2> Resultado de la Verificación:</h2>";

if ($resultado === 1) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 5px; text-align: center;'>";
    echo "<h3 style='color: #155724; margin: 0;'> FIRMA VÁLIDA</h3>";
    echo "<p style='margin: 10px 0 0 0;'>";
    echo "• El mensaje no ha sido alterado<br>";
    echo "• La firma corresponde al mensaje original<br>";
    echo "• La clave pública verifica correctamente la firma<br>";
    echo "</p>";
    echo "</div>";
    
} elseif ($resultado === 0) {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 5px; text-align: center;'>";
    echo "<h3 style='color: #721c24; margin: 0;'> FIRMA INVÁLIDA</h3>";
    echo "<p>El mensaje ha sido alterado o la firma no corresponde</p>";
    echo "</div>";
} else {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 5px;'>";
    echo "<h3 style='color: #856404; margin: 0;'> ERROR EN LA VERIFICACIÓN</h3>";
    echo "<p>Error: " . openssl_error_string() . "</p>";
    echo "</div>";
}

// Prueba de integridad: alterar mensaje
echo "<h2> Prueba de Detección de Alteraciones:</h2>";
$mensaje_alterado = $mensaje . " (texto agregado maliciosamente)";
$resultado_alterado = openssl_verify($mensaje_alterado, $firma, $publicKey, OPENSSL_ALGO_SHA256);

if ($resultado_alterado === 0) {
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px;'>";
    echo " <strong>PRUEBA EXITOSA:</strong> El sistema detecta correctamente mensajes alterados";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px;'>";
    echo " <strong>PRUEBA FALLIDA:</strong> El sistema no detectó la alteración";
    echo "</div>";
}

// Liberar recurso sin warnings
if (is_resource($publicKey)) {
    @openssl_pkey_free($publicKey);
}

echo '<br><div style="text-align: center; margin: 20px 0;">';
echo '<a href="encriptacion.php" style="padding: 12px 24px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">';
echo ' Continuar con Encriptación';
echo '</a>';
echo '</div>';
?>