#!/bin/bash
# Aseguramos que estamos en la carpeta del proyecto
cd ~/despliegue_servidor

echo "🌐 Configurando redes..."
docker network create red-internet 2>/dev/null || true
docker network create red-interna 2>/dev/null || true

echo "📥 Sincronizando GitHub..."
git pull origin main

echo "🐳 Actualizando imagen..."
# Aquí intenta bajar tu imagen de Docker Hub
docker pull mcarmen96/despliegue_servidor:latest || echo "⚠️ No hay imagen nueva en Hub, se usará la local."

echo "🚀 Lanzando infraestructura..."
# Esto arrancará TODO (Nginx, SSL, Grafana, Prometheus y tu App)
 docker compose up -d --build --remove-orphans

echo "✅ Proceso completado. Contenedores activos:"
docker ps
