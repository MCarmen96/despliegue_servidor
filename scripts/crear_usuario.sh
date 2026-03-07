#!/bin/bash

# 1. Pedir el nombre del nuevo alumno
read -p "Nombre del nuevo usuario: " USUARIO

# 2. Crear el usuario y añadirlo al grupo docker para que pueda desplegar
sudo adduser --gecos "" "$USUARIO"
sudo usermod -aG docker "$USUARIO"

# 3. Crear estructura de carpetas
USER_HOME="/home/$USUARIO"
sudo mkdir -p "$USER_HOME/apps"
sudo chown -R "$USUARIO:$USUARIO" "$USER_HOME/apps"

# 4. Dominio base del servidor
DOMINIO_BASE="servidorgp.somosdelprieto.com"

# 5. Generar el README.md informativo para el alumno
sudo bash -c "cat > $USER_HOME/apps/README.md <<'EOF'
# Guía de despliegue para $USUARIO

## Tu dominio
Tus apps serán accesibles en: https://tu-app.$USUARIO.$DOMINIO_BASE

## Pasos para desplegar

1. Sube tu proyecto a esta carpeta:
   scp -r ./mi-proyecto $USUARIO@servidor:~/apps/

2. Tu proyecto DEBE tener:
   - Un Dockerfile
   - Un docker-compose.yml
   - Un archivo .env con las variables de tu app

3. En tu docker-compose.yml usa estas variables de entorno:
   - VIRTUAL_HOST=tu-app.$USUARIO.$DOMINIO_BASE
   - VIRTUAL_PORT=80 (o el puerto que use tu app)
   - LETSENCRYPT_HOST=tu-app.$USUARIO.$DOMINIO_BASE

4. Conecta tus servicios a las redes del servidor:
   - red-internet (para servicios con dominio público)
   - red-interna (para bases de datos y servicios internos)

5. NO uses 'ports:' en tu compose. El proxy inverso se encarga.

6. Despliega con: docker compose up -d --build

El servidor detectará tu app automáticamente y le asignará HTTPS.
EOF"

echo "✅ Usuario '$USUARIO' creado. Directorio: $USER_HOME/apps/"
