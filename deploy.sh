#!/bin/bash
# Aseguramos que estamos en la carpeta del proyecto
cd ~/despliegue_servidor

echo "🌐 Configurando redes..."
docker network create red-internet 2>/dev/null || true
docker network create red-interna 2>/dev/null || true

echo "📥 Sincronizando GitHub..."
git pull origin main

echo "� Lanzando infraestructura..."
# COMPOSE_BAKE=false evita el warning de buildx no instalado
COMPOSE_BAKE=false docker compose up -d --build --remove-orphans

echo "✅ Proceso completado. Contenedores activos:"
docker ps
