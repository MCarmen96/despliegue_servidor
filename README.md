
# 📘 Runbook: Servidor de Aplicaciones Web (Sistemas)

Este documento detalla la operativa para la administración, despliegue y mantenimiento del servidor basado en Docker. La arquitectura está diseñada para ser escalable, segura y monitorizada en tiempo real mediante un sistema de Proxy Inverso y segmentación de redes.

---

## 🌐 1. Arquitectura de Red y Requisitos
El sistema opera bajo un modelo de **redes segmentadas** para garantizar el aislamiento y la seguridad:

* **`red-internet` (Frontend):** Red externa donde conviven el Proxy Inverso y las aplicaciones de los alumnos. Es la única red que acepta tráfico HTTP/HTTPS (Puertos 80/443).
* **`red-interna` (Backend):** Red privada y aislada para los servicios de infraestructura (Prometheus, Node Exporter). Las aplicaciones de los usuarios no tienen visibilidad sobre esta red.
* **Resolución DNS:** Se requiere que los dominios asignados (ej: `*.mcarmen.2daw`) apunten a la IP de la Máquina Virtual configurada en el servidor BIND9 del aula.

---

## 👤 2. Gestión de Usuarios de Despliegue
Para dar de alta a un alumno y automatizar su entorno se utiliza el script `crear_usuario.sh`.

**Procedimiento:**
1. Ejecutar el script: `sudo ./scripts/crear_usuario.sh`.
2. El script realizará automáticamente:
    * Creación del usuario en el sistema operativo.
    * Asignación al grupo `docker`.
    * Creación de la estructura de directorios `~/apps/` con los permisos de usuario correctos.
    * Generación de un archivo informativo en el HOME del alumno con sus datos de dominio.

---

## 🚀 3. Procedimiento Estándar de Despliegue
El despliegue se realiza mediante **Nginx Proxy Inverso**, eliminando la necesidad de gestionar puertos manuales.

**Pasos para el alumno:**
1. **Envío de archivos:** Subir la carpeta del proyecto (con el código estático o carpeta `dist`) mediante SCP:
   `scp -r ./mi-app usuario@servidor:~/apps/`
2. **Configuración:** Crear un `docker-compose.yml` en la carpeta del proyecto siguiendo esta plantilla:
   ```yaml
   services:
     web:
       image: nginx:alpine
       environment:
         - VIRTUAL_HOST=mi-app.mcarmen.2daw
         - VIRTUAL_PORT=80
         - LETSENCRYPT_HOST=mi-app.mcarmen.2daw
         - LETSENCRYPT_EMAIL=alumno@correo.com
       volumes:
         - ./dist:/usr/share/nginx/html:ro
       networks:
         - red-internet

   networks:
     red-internet:
       external: true

    ```

3. **Levantamiento:** Ejecutar `docker-compose up -d`. La app será accesible en `http://mi-app.mcarmen.2daw`.

---

## 🔒 4. Gestión de Dominios y HTTPS Real

El servidor implementa certificados SSL/TLS de Let's Encrypt de forma automatizada mediante el protocolo **ACME**.

* **Validación:** Se utiliza el método **HTTP-01**. El contenedor `letsencrypt-companion` monitoriza las etiquetas del alumno, solicita el certificado a la CA y lo renueva automáticamente antes de su expiración.
* **Persistencia:** Los certificados se almacenan en un volumen persistente para evitar re-solicitudes innecesarias y bloqueos por parte de la CA.

---

## 📊 5. Monitorización y Métricas

El estado del servidor es accesible mediante los nombres de dominio de infraestructura:

* **Grafana:** Acceso vía `http://grafana.mcarmen.2daw`.
* **Portainer:** Acceso vía `http://portainer.mcarmen.2daw` para gestión visual de contenedores.
* **Comprobación:** Consultar el Dashboard **"Node Exporter Full"** para monitorizar CPU, RAM y tráfico de red en tiempo real.

---

## 🛠️ 6. Mantenimiento Básico

Comandos esenciales para el administrador en la carpeta `/plataforma`:

| Tarea | Comando |
| --- | --- |
| **Ver estado global** | `docker ps` |
| **Reiniciar infraestructura** | `docker-compose restart` |
| **Ver logs de certificados** | `docker logs -f letsencrypt-companion` |
| **Actualizar imágenes** | `docker-compose pull && docker-compose up -d` |
| **Eliminar recursos huérfanos** | `docker system prune -f` |
