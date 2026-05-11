#!/bin/bash

# 1. Pedir el nombre del nuevo alumno
read -p "Nombre del nuevo usuario: " USUARIO

# 2. Asignar automáticamente un bloque de 10 puertos por usuario leyendo los usuarios ya creados
PUERTO_INICIO=3000

while IFS= read -r -d '' README_USUARIO; do
   RANGO_USUARIO=$(sudo grep -Eo 'Rango disponible: \*\*[0-9]+-[0-9]+\*\*' "$README_USUARIO" 2>/dev/null | head -n 1 || true)

   if [[ -n "$RANGO_USUARIO" ]]; then
      PUERTO_FIN_ACTUAL=$(echo "$RANGO_USUARIO" | sed -E 's/.*\*\*([0-9]+)-([0-9]+)\*\*.*/\2/')

      if [[ "$PUERTO_FIN_ACTUAL" =~ ^[0-9]+$ ]] && [[ "$PUERTO_FIN_ACTUAL" -ge "$PUERTO_INICIO" ]]; then
         PUERTO_INICIO=$((PUERTO_FIN_ACTUAL + 1))
      fi
   fi
done < <(sudo find /home -mindepth 2 -maxdepth 2 -path '*/apps/README.md' -print0 2>/dev/null)

PUERTO_FIN=$((PUERTO_INICIO + 9))

echo "📋 Puertos asignados a $USUARIO: $PUERTO_INICIO-$PUERTO_FIN"

# 3. Crear el usuario y añadirlo al grupo docker para que pueda desplegar
sudo adduser --gecos "" "$USUARIO"
sudo usermod -aG docker "$USUARIO"

# 4. Crear estructura de carpetas
USER_HOME="/home/$USUARIO"
sudo mkdir -p "$USER_HOME/apps"
sudo chown -R "$USUARIO:$USUARIO" "$USER_HOME/apps"

# 5. Dominio base del servidor
DOMINIO_BASE="servidorgp.somosdelprieto.com"

# 6. Generar el README.md informativo para el alumno
sudo bash -c "cat > $USER_HOME/apps/README.md <<'EOF'
# Guía de despliegue para $USUARIO

## Tu dominio
Tus apps serán accesibles en: https://tu-app.$USUARIO.$DOMINIO_BASE

## Puertos asignados a este usuario
Rango disponible: **$PUERTO_INICIO-$PUERTO_FIN**

Cada aplicación que despliegues debe usar uno de estos puertos internos.
Cuando crees otra app para otro usuario, el sistema le asignará automáticamente el siguiente bloque de 10 puertos.

## Pasos para desplegar

1. Sube tu proyecto a esta carpeta:
   scp -r ./mi-proyecto $USUARIO@servidor:~/apps/

2. Tu proyecto DEBE tener:
   - Un Dockerfile
   - Un docker-compose.yml
   - Un archivo .env con las variables de tu app

3. En tu docker-compose.yml usa estas variables de entorno:
   - VIRTUAL_HOST=tu-app.$USUARIO.$DOMINIO_BASE
   - VIRTUAL_PORT=el puerto interno de tu app dentro del rango $PUERTO_INICIO-$PUERTO_FIN
   - LETSENCRYPT_HOST=tu-app.$USUARIO.$DOMINIO_BASE

4. Conecta tus servicios a las redes del servidor:
   - red-internet (para servicios con dominio público)
   - red-interna (para bases de datos y servicios internos)

5. NO uses 'ports:' en tu compose. El proxy inverso se encarga.

6. Despliega con: docker compose up -d --build

El servidor detectará tu app automáticamente y le asignará HTTPS.
EOF"

echo "✅ Usuario '$USUARIO' creado. Directorio: $USER_HOME/apps/"
echo "🔒 Bloque de puertos asignado: $PUERTO_INICIO-$PUERTO_FIN"
