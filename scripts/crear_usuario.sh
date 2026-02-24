#!/bin/bash

# 1. Pedir el nombre del nuevo alumno
read -p "Nombre del nuevo usuario: " USUARIO

# 2. Crear el usuario y añadirlo al grupo docker para que pueda desplegar
sudo adduser --gecos "" $USUARIO
sudo usermod -aG docker $USUARIO

# 4. Crear estructura de carpetas según el PDF
USER_HOME="/home/$USUARIO"
sudo mkdir -p $USER_HOME/apps
sudo chown -R $USUARIO:$USUARIO $USER_HOME/apps

# 3. YA NO CALCULAMOS PUERTOS (Opcional, pero mejor por dominio)
DOMINIO_BASE=".2daw"

# 5. Generar el README.md informativo (Actualizado al nuevo sistema)
sudo bash -c "cat > $USER_HOME/apps/README.md <<EOF
## Instrucciones para el Alumno
Bienvenido, $USUARIO.

### Cómo desplegar tu App:
1. Sube tus archivos por SCP a: ~/apps/tu-proyecto
2. Tu docker-compose.yml DEBE incluir estas variables:
   - VIRTUAL_HOST=$USUARIO$DOMINIO_BASE
   - LETSENCRYPT_HOST=$USUARIO$DOMINIO_BASE
   - LETSENCRYPT_EMAIL=tu-correo@ejemplo.com
3. NO uses la sección 'ports' en tu compose.
4. Ejecuta: docker-compose up -d

El servidor detectará tu app y le asignará HTTPS automáticamente.
EOF"
