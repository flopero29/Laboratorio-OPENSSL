<?php
// Ocultar warnings de deprecated (solo para este archivo)
error_reporting(E_ALL & ~E_DEPRECATED);

echo "<h1> Firma Digital con OpenSSL</h1>";

// Buscar archivos de claves disponibles
$privateKeyFile = file_exists('keys/private_key.pem') ? 'keys/private_key.pem' : 'keys/private_key_alt.pem';
$publicKeyFile = file_exists('keys/public_key.pem') ? 'keys/public_key.pem' : 'keys/public_key_alt.pem';

if (!file_exists($privateKeyFile) || !file_exists($publicKeyFile)) {
    die(" No se encontraron claves. <a href='generar_claves.php'>Generar claves primero</a>");
}

// Cargar clave privada
$privateKeyPem = file_get_contents($privateKeyFile);
$privateKey = openssl_pkey_get_private($privateKeyPem);

if ($privateKey === false) {
    die(" Error al cargar clave privada: " . openssl_error_string());
}

// Mensaje a firmar
$mensaje = "Mensaje importante firmado digitalmente para el laboratorio. Fecha: " . date('Y-m-d H:i:s');

echo "<h2> Mensaje Original:</h2>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #007bff;'>";
echo htmlspecialchars($mensaje);
echo "</div>";

// Firmar el mensaje
$firma = '';
if (openssl_sign($mensaje, $firma, $privateKey, OPENSSL_ALGO_SHA256)) {
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
    echo " <strong>Firma digital creada exitosamente</strong>";
    echo "</div>";
    
    // Codificar firma en base64
    $firmaBase64 = base64_encode($firma);
    
    echo "<h2> Firma Digital (Base64):</h2>";
    echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; font-family: monospace; word-break: break-all;'>";
    echo $firmaBase64;
    echo "</div>";
    
    echo "<h2> Información Técnica:</h2>";
    echo "<ul>";
    echo "<li><strong>Longitud de la firma:</strong> " . strlen($firma) . " bytes</li>";
    echo "<li><strong>Longitud en Base64:</strong> " . strlen($firmaBase64) . " caracteres</li>";
    echo "<li><strong>Algoritmo de hash:</strong> SHA256</li>";
    echo "<li><strong>Algoritmo de firma:</strong> RSA</li>";
    echo "</ul>";
    
    // Guardar archivos para verificación
    file_put_contents('keys/mensaje.txt', $mensaje);
    file_put_contents('keys/firma.bin', $firma);
    file_put_contents('keys/firma_base64.txt', $firmaBase64);
    
    echo "<h2> Archivos Guardados:</h2>";
    echo "<div style='background: #e7f3ff; padding: 15px; border-radius: 5px;'>";
    echo "• keys/mensaje.txt<br>";
    echo "• keys/firma.bin (binario)<br>";
    echo "• keys/firma_base64.txt (texto)<br>";
    echo "</div>";
    
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px;'>";
    echo " Error al firmar el mensaje: " . openssl_error_string();
    echo "</div>";
}

// Liberar recurso sin warnings
if (is_resource($privateKey)) {
    @openssl_pkey_free($privateKey); // @ suprime warnings
}

echo '<br><div style="text-align: center; margin: 20px 0;">';
echo '<a href="verificacion_firma.php" style="padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;">';
echo ' Continuar con Verificación de Firma';
echo '</a>';
echo '</div>';
?>