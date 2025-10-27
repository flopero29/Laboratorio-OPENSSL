#  Laboratorio 5 – OPENSSL

### Universidad Tecnológica de Panamá  
**Facultad de Sistemas Computacionales – Licenciatura en Ingeniería de Software**  
**Curso:** Ingeniería Web  
**Estudiante:** Jose Bustamante – 8-1011-1717, Abigail Koo - 8-997-974  
**Facilitador:** Irina Fong  
**Grupo:** 1SF131  
**Año:** 2025  

---
##  Introducción

Este laboratorio implementa funciones criptográficas avanzadas utilizando la biblioteca OpenSSL en PHP, aplicando estándares industriales de seguridad de la información. Se abordan los fundamentos de firmas digitales, verificación de integridad, encriptación simétrica y gestión de claves asimétricas, integrando prácticas que garantizan la autenticidad y confidencialidad de los datos.

---

##  Tecnologías Usadas

- **OpenSSL 3.0+** – Librería para operaciones criptográficas
- **PHP** con extensión OpenSSL
- **RSA-2048** – Criptografía asimétrica
- **AES-256-CBC** – Encriptación simétrica
- **SHA256** – Función hash segura

---
## Objetivos del Laboratorio

- Implementar la generación de pares de claves RSA (2048 bits) usando OpenSSL.
- Crear un sistema de firmas digitales para la verificación de integridad.
- Desarrollar mecanismos de validación que detecten alteraciones en datos firmados.
- Aplicar encriptación simétrica con AES-256 para proteger información confidencial.
- Comprender el flujo criptográfico completo, desde la generación de claves hasta la encriptación y verificación.

---
##  Instalación y Configuración

###  Requisitos Previos
Antes de ejecutar el proyecto, asegúrate de tener instalado:
- [XAMPP](https://www.apachefriends.org/es/index.html) o [WAMP](https://www.wampserver.com/)  
- **PHP 8.0+**  
- **OpenSSL 3.0+** instalado en tu sistema 
- Un navegador web moderno (Chrome, Firefox, Edge)
###  Instalación y Configuración

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/flopero29/Laboratorio-OPENSSL.git
   ```
   o descarga el repositorio como .zip y extrae el contenido en la carpeta htdocs de XAMPPo www de WAMPP.

2. **Verificar la extensión OpenSSL**
   - Abre el archivo php.ini
   - Asegúrate de que la línea siguiente no esté comentada:
   ```ini
   extension=openssl
   ```
  
3. **Iniciar el servidor local**
- Desde el Panel de Control de XAMPP, activa Apache o activa los servicios en WAMPP.
- Luego accede en tu navegador a:
```bash
http://localhost/Laboratorio-OPENSSL/claves.php
```

4. **Ejecutar las funciones**
- claves.php → Genera claves públicas y privadas (PEM).
- firma.php → Crea una firma digital de un mensaje.
- verificación_firma.php → Comprueba la autenticidad del mensaje.
- encriptacion.php → Encripta y desencripta datos usando AES-256-CBC.
---

##  Aspectos de Seguridad Implementados

### **Fortaleza Criptográfica**
- RSA 2048 bits: resistente a ataques de fuerza bruta.
- SHA256: algoritmo hash criptográficamente seguro.
- AES-256: estándar industrial para encriptación.
- IV único por operación: previene ataques por patrones.

### **Buenas Prácticas**
- Gestión segura de claves: almacenamiento en archivos .pem.
- Verificación de integridad: detección de alteraciones en los datos.
- Manejo de errores controlado: mensajes claros en fallos.

### **Prevención de Ataques**
- **Firmas digitales**: evitan suplantación y manipulación.
- **Encriptación fuerte**: protege la confidencialidad de los datos. 
- **Verificación rigurosa**: detecta cualquier alteración. 
- **Claves robustas**: resistentes ante la computación cuántica básica. 

---


## Capturas de Pantalla

1. Generación de claves 
2. Firma digital
3. Verificación de firma  
4. Encriptación AES-256 

(Disclaimer: Las imágenes están en la carpeta Imagenes)
---


## Conclusiones

Durante el desarrollo del laboratorio se implementó un sistema completo de criptografía con OpenSSL, demostrando la correcta aplicación de los principios de seguridad, integridad y confidencialidad.
Se comprendió el uso de firmas digitales, encriptación simétrica y criptografía asimétrica, aplicando mecanismos de verificación que fortalecen la protección de la información. 

Entre los principales aprendizajes destacan:
- La importancia de las firmas digitales para garantizar la autenticidad e integridad.
- El rol de los pares de claves en la criptografía asimétrica.
- La necesidad de IVs únicos en operaciones de encriptación. 
- La diferenciación entre hashing, firma y encriptación en aplicaciones reales. 
