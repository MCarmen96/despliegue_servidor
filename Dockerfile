# Usamos una imagen que ya tenga Docker y Compose (Docker-in-Docker)
FROM docker:24-dind

# Creamos la carpeta de la app
WORKDIR /home/servidor

# Copiamos TODO tu proyecto (compose, carpetas de prometheus, certs, etc.)
COPY . .

# Exponemos el puerto del Proxy
EXPOSE 80

# Al arrancar, esta imagen levantará tu infraestructura
CMD ["docker-compose", "up"]
