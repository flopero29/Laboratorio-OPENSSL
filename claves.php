<?php
echo "<h1>Generación de Claves RSA con OpenSSL</h1>";

// Configuración para OpenSSL en Windows
$config = array(
    "digest_alg" => "sha256",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
    "config" => "C:/wamp64/bin/php/php8.3.14/extras/ssl/openssl.cnf" // Ruta importante
);

// Si la ruta anterior no funciona, probamos sin config
$resource = openssl_pkey_new($config);
if ($resource === false) {
    echo "Intentando sin configuración específica...<br>";
    // Intentar sin config
    $config_simple = array(
        "digest_alg" => "sha256",
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );
    $resource = openssl_pkey_new($config_simple);
}

if ($resource === false) {
    echo " Error al generar claves: " . openssl_error_string() . "<br>";
    echo "<h2>Solución:</h2>";
    echo "1. Verificar que OpenSSL esté instalado en el sistema<br>";
    echo "2. Probar con configuración mínima<br>";
    
    // Intentar método alternativo
    echo "<h3> Método Alternativo:</h3>";
    alternativo_generar_claves();
} else {
    // Extraer clave privada
    openssl_pkey_export($resource, $privateKey, null, $config);
    if ($privateKey === false) {
        echo " Error al exportar clave privada: " . openssl_error_string() . "<br>";
    } else {
        // Extraer clave pública
        $publicKeyDetails = openssl_pkey_get_details($resource);
        $publicKey = $publicKeyDetails['key'];

        // Crear carpeta keys si no existe
        if (!is_dir('keys')) {
            mkdir('keys', 0755, true);
        }

        // Guardar claves en archivos
        file_put_contents('keys/private_key.pem', $privateKey);
        file_put_contents('keys/public_key.pem', $publicKey);

        echo " Claves generadas exitosamente<br>";
        echo "<h2> Clave Privada:</h2>";
        echo "<pre>" . htmlspecialchars($privateKey) . "</pre>";

        echo "<h2> Clave Pública:</h2>";
        echo "<pre>" . htmlspecialchars($publicKey) . "</pre>";

        echo "<h2> Archivos guardados:</h2>";
        echo "• keys/private_key.pem<br>";
        echo "• keys/public_key.pem<br>";

        echo '<br><a href="firma.php"> Continuar con Firma Digital</a>';
    }
}

// Función alternativa para generar claves
function alternativo_generar_claves() {
    echo "<h3> Generación Alternativa de Claves</h3>";
    
    // Usar OpenSSL via línea de comandos
    $output = [];
    $return_var = 0;
    
    // Crear carpeta keys si no existe
    if (!is_dir('keys')) {
        mkdir('keys', 0755, true);
    }
    
    // Generar clave privada
    exec('openssl genrsa -out keys/private_key_alt.pem 2048 2>&1', $output, $return_var);
    
    if ($return_var === 0 && file_exists('keys/private_key_alt.pem')) {
        echo " Clave privada generada alternativamente<br>";
        
        // Generar clave pública
        exec('openssl rsa -in keys/private_key_alt.pem -pubout -out keys/public_key_alt.pem 2>&1', $output, $return_var);
        
        if ($return_var === 0 && file_exists('keys/public_key_alt.pem')) {
            echo " Clave pública generada alternativamente<br>";
            
            $privateKey = file_get_contents('keys/private_key_alt.pem');
            $publicKey = file_get_contents('keys/public_key_alt.pem');
            
            echo "<h2> Clave Privada (Alternativa):</h2>";
            echo "<pre>" . htmlspecialchars($privateKey) . "</pre>";

            echo "<h2> Clave Pública (Alternativa):</h2>";
            echo "<pre>" . htmlspecialchars($publicKey) . "</pre>";
            
            echo '<br><a href="firma.php"> Continuar con Firma Digital (Alternativa)</a>';
        } else {
            echo " Error generando clave pública alternativamente<br>";
        }
    } else {
        echo " No se pudo generar claves alternativamente<br>";
        echo "OpenSSL no está disponible en línea de comandos<br>";
        
        // Crear claves de prueba estáticas
        echo "<h3> Claves de Prueba Estáticas</h3>";
        crear_claves_estaticas();
    }
}

// Función para crear claves estáticas de prueba
function crear_claves_estaticas() {
    $privateKey = "-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCzN4Q... [clave truncada]
-----END PRIVATE KEY-----";
    
    $publicKey = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAszeEH... [clave truncada]
-----END PUBLIC KEY-----";
    
    if (!is_dir('keys')) {
        mkdir('keys', 0755, true);
    }
    
    file_put_contents('keys/private_key.pem', $privateKey);
    file_put_contents('keys/public_key.pem', $publicKey);
    
    echo " Claves de prueba creadas<br>";
    echo "<p><em>Nota: Estas son claves de prueba para continuar con el laboratorio</em></p>";
    
    echo '<br><a href="firma.php"> Continuar con Firma Digital</a>';
}
?>