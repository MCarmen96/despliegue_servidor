# Servidor de Despliegue de Aplicaciones Web

Servidor compartido basado en Docker que permite a cualquier usuario desplegar su aplicación web con HTTPS automático, sin necesidad de configurar puertos ni certificados manualmente.

---

## Arquitectura del servidor

### Visión general

El servidor ejecuta un conjunto de servicios de infraestructura mediante Docker Compose. Cualquier usuario del sistema puede desplegar su propia aplicación de forma independiente, con su propio `docker-compose.yml`, y el servidor la detecta automáticamente gracias al proxy inverso.

```
Internet
   │
   ▼
┌──────────────────────────────────────────────────┐
│              nginx-proxy (:80 / :443)            │
│         (proxy inverso + terminación SSL)        │
│              letsencrypt-companion               │
│         (certificados HTTPS automáticos)         │
└──────────┬───────────┬───────────┬───────────────┘
           │           │           │
     red-internet      │     red-internet
           │           │           │
     ┌─────▼─────┐  ┌──▼───┐  ┌───▼────────┐
     │  App del   │  │Portai│  │  Grafana   │
     │  usuario   │  │ner   │  │ Prometheus │
     └─────┬─────┘  └──────┘  └────────────┘
           │
      red-interna
           │
     ┌─────▼─────┐
     │    BBDD   │
     │  del user │
     └───────────┘
```

### Componentes de infraestructura

Estos servicios los gestiona el administrador y están siempre activos:

| Servicio | Función | Dominio |
|---|---|---|
| **nginx-proxy** | Proxy inverso. Enruta el tráfico a cada app por su dominio | - |
| **letsencrypt-companion** | Genera y renueva certificados HTTPS automáticamente | - |
| **Portainer** | Panel web para gestionar contenedores Docker | `portainer.<subdominio>` |
| **Prometheus** | Recolección de métricas del servidor | `prometheus.<subdominio>` |
| **Grafana** | Dashboards de monitorización | `grafana.<subdominio>` |
| **Node Exporter** | Exporta métricas del sistema (CPU, RAM, disco) | Solo interno |

### Redes Docker

| Red | Tipo | Propósito |
|---|---|---|
| `red-internet` | Externa | Conecta servicios públicos con el proxy inverso. Las apps de los usuarios **deben** conectarse aquí. |
| `red-interna` | Externa | Red privada para servicios internos (bases de datos, node-exporter). **No** es accesible desde Internet. |

> **Importante:** ambas redes ya existen en el servidor. Los usuarios solo deben referenciarlas con `external: true` en su compose.

### Cómo funciona el descubrimiento automático

1. nginx-proxy escucha en el socket de Docker y detecta cada contenedor que arranca.
2. Si un contenedor tiene la variable `VIRTUAL_HOST=midominio.com`, nginx-proxy crea automáticamente una entrada de proxy que enruta ese dominio al contenedor.
3. letsencrypt-companion detecta la variable `LETSENCRYPT_HOST=midominio.com` y solicita un certificado HTTPS a Let's Encrypt.
4. Todo esto ocurre sin intervención del usuario, basta con poner las variables de entorno correctas.

---

## Guía de administrador

### Requisitos previos del servidor

- Docker y Docker Compose instalados
- Puertos 80 y 443 abiertos y accesibles desde Internet
- DNS configurado: `*.servidorgp.somosdelprieto.com` apuntando a la IP del servidor

### Desplegar la infraestructura

```bash
git clone https://github.com/MCarmen96/despliegue_servidor.git ~/despliegue_servidor
cd ~/despliegue_servidor
bash deploy.sh
```

El script `deploy.sh` crea las redes Docker si no existen, hace `git pull` y levanta todos los servicios de infraestructura.

### Crear un nuevo usuario

```bash
sudo bash ~/despliegue_servidor/scripts/crear_usuario.sh
```

El script:
1. Crea el usuario en el sistema
2. Lo añade al grupo `docker` (para que pueda usar Docker sin sudo)
3. Crea el directorio `~/apps/` con los permisos correctos
4. Genera un README con instrucciones personalizadas en su carpeta

---

## Guía de usuario: Cómo desplegar tu aplicación

### Paso 1: Acceder al servidor

Conéctate por SSH con tu usuario:

```bash
ssh tu-usuario@servidor
```

### Paso 2: Subir tu proyecto

Desde tu máquina local, sube tu proyecto al servidor:

```bash
scp -r ./mi-proyecto tu-usuario@servidor:~/apps/mi-proyecto
```

Tu proyecto debe tener esta estructura mínima:

```
~/apps/mi-proyecto/
├── docker-compose.yml    # Orquestación de tus servicios
├── Dockerfile            # Cómo construir tu app
├── .env                  # Variables de entorno (BBDD, claves, etc.)
└── (tu código fuente)
```

### Paso 3: Configurar tu docker-compose.yml

Este es el punto clave. Tu `docker-compose.yml` debe:

1. **Conectar tu app a `red-internet`** para que el proxy la detecte
2. **Conectar tu BBDD a `red-interna`** para que no sea accesible desde Internet
3. **Definir las variables de entorno** `VIRTUAL_HOST`, `VIRTUAL_PORT` y `LETSENCRYPT_HOST`
4. **NO usar `ports:`** en ningún servicio público (el proxy se encarga)

#### Ejemplo completo para una app con PostgreSQL:

```yaml
services:
  db:
    image: postgres:15
    container_name: mi-app-db
    restart: always
    environment:
      POSTGRES_DB: ${DB_DATABASE}
      POSTGRES_USER: ${DB_USERNAME}
      POSTGRES_PASSWORD: ${DB_PASSWORD}
    volumes:
      - db_data:/var/lib/postgresql/data
    networks:
      - red-interna

  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: mi-app
    restart: always
    env_file:
      - .env
    environment:
      - VIRTUAL_HOST=mi-app.tu-usuario.servidorgp.somosdelprieto.com
      - VIRTUAL_PORT=80
      - LETSENCRYPT_HOST=mi-app.tu-usuario.servidorgp.somosdelprieto.com
    networks:
      - red-internet
      - red-interna
    depends_on:
      - db

networks:
  red-internet:
    external: true
  red-interna:
    external: true

volumes:
  db_data:
```

#### Ejemplo para una app estática (HTML/CSS/JS):

```yaml
services:
  web:
    image: nginx:alpine
    container_name: mi-web
    restart: always
    environment:
      - VIRTUAL_HOST=mi-web.tu-usuario.servidorgp.somosdelprieto.com
      - VIRTUAL_PORT=80
      - LETSENCRYPT_HOST=mi-web.tu-usuario.servidorgp.somosdelprieto.com
    volumes:
      - ./dist:/usr/share/nginx/html:ro
    networks:
      - red-internet

networks:
  red-internet:
    external: true
```

### Paso 4: Configurar tu archivo .env

Tu `.env` debe incluir las credenciales de tu base de datos. **Importante**: el `DB_HOST` debe ser el nombre del servicio de la BBDD en tu compose (por ejemplo `db`), NO `localhost`.

```env
DB_HOST=db
DB_PORT=5432
DB_DATABASE=mi_base_de_datos
DB_USERNAME=mi_usuario
DB_PASSWORD=mi_contraseña_segura
```

### Paso 5: Desplegar

Dentro del servidor, entra en tu carpeta y levanta los servicios:

```bash
cd ~/apps/mi-proyecto
docker compose up -d --build
```

En unos segundos tu app estará disponible en:

```
https://mi-app.tu-usuario.servidorgp.somosdelprieto.com
```

El certificado HTTPS se genera automáticamente (puede tardar 1-2 minutos la primera vez).

### Paso 6: Verificar

```bash
# Ver que tus contenedores están corriendo
docker ps

# Ver los logs de tu app
docker compose logs -f app

# Ver los logs del proxy (si algo no funciona)
docker logs nginx-proxy
docker logs letsencrypt-companion
```

---

## Gestión de la base de datos

### Acceder a la BBDD desde el servidor

Para entrar a la consola de PostgreSQL de tu app:

```bash
docker exec -it mi-app-db psql -U mi_usuario -d mi_base_de_datos
```

Comandos útiles dentro de `psql`:

| Comando | Qué hace |
|---|---|
| `\dt` | Listar todas las tablas |
| `\d nombre_tabla` | Ver estructura de una tabla |
| `SELECT * FROM tabla;` | Ver registros |
| `\q` | Salir |

### Importar datos desde un dump

Si tienes un dump de tu base de datos local (`.sql` o `.dump` con formato plano):

```bash
# Copiar el dump al servidor
scp mi_dump.sql tu-usuario@servidor:~/apps/mi-proyecto/

# Importar dentro del contenedor de la BBDD
docker cp mi_dump.sql mi-app-db:/tmp/
docker exec -i mi-app-db psql -U mi_usuario -d mi_base_de_datos -f /tmp/mi_dump.sql
```

### Exportar un backup

```bash
docker exec mi-app-db pg_dump -U mi_usuario mi_base_de_datos > backup.sql
```

---

## Comandos útiles para el administrador

| Tarea | Comando |
|---|---|
| Ver estado de todos los contenedores | `docker ps` |
| Reiniciar la infraestructura | `cd ~/despliegue_servidor && docker compose restart` |
| Ver logs de certificados SSL | `docker logs -f letsencrypt-companion` |
| Actualizar imágenes de infraestructura | `cd ~/despliegue_servidor && docker compose pull && docker compose up -d` |
| Limpiar recursos huérfanos | `docker system prune -f` |
| Crear un nuevo usuario | `sudo bash ~/despliegue_servidor/scripts/crear_usuario.sh` |

---

## Resolución de problemas frecuentes

| Problema | Causa probable | Solución |
|---|---|---|
| La app no es accesible | Falta `VIRTUAL_HOST` o no está en `red-internet` | Revisar variables de entorno y redes en el compose |
| Error 502 Bad Gateway | La app no arranca o `VIRTUAL_PORT` es incorrecto | `docker compose logs app` para ver el error |
| HTTPS no funciona | DNS no apunta al servidor o puerto 80 bloqueado | Verificar DNS y que el puerto 80 esté abierto |
| La app no conecta a la BBDD | `DB_HOST` incorrecto en `.env` | Debe ser el nombre del servicio del compose (ej: `db`), no `localhost` |
| Certificado tarda en generarse | Let's Encrypt necesita validar por HTTP | Esperar 1-2 min y verificar con `docker logs letsencrypt-companion` |
