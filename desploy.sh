#!/bin/bash

echo "🌐 Comprobando y creando redes externas..."
# El "|| true" sirve para que, si la red ya existe, el script no se pare con error
docker network create red-internet || true
docker network create red-interna || true

echo "📥 Actualizando código desde GitHub..."
git pull origin main

echo "🐳 Descargando última imagen de Docker Hub..."
docker pull mcarmen96/despliegue_servidor:latest

echo "🚀 Reiniciando servicios con Docker Compose..."
docker compose up -d --remove-orphans

echo "✅ ¡Todo listo! Estado de los contenedores:"
docker ps
