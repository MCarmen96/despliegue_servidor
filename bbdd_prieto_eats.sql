-- ============================================================
-- BBDD Prieto Eats - Dump para importar en producción
-- ============================================================

-- 1. Eliminar tablas en orden inverso de dependencias
DROP TABLE IF EXISTS "public"."product_orders";
DROP TABLE IF EXISTS "public"."product_offers";
DROP TABLE IF EXISTS "public"."orders";
DROP TABLE IF EXISTS "public"."sessions";
DROP TABLE IF EXISTS "public"."products";
DROP TABLE IF EXISTS "public"."offers";
DROP TABLE IF EXISTS "public"."users";
DROP TABLE IF EXISTS "public"."password_reset_tokens";
DROP TABLE IF EXISTS "public"."cache_locks";
DROP TABLE IF EXISTS "public"."cache";
DROP TABLE IF EXISTS "public"."failed_jobs";
DROP TABLE IF EXISTS "public"."job_batches";
DROP TABLE IF EXISTS "public"."jobs";
DROP TABLE IF EXISTS "public"."migrations";

-- 2. Crear tablas sin dependencias

CREATE SEQUENCE IF NOT EXISTS migrations_id_seq;
CREATE TABLE "public"."migrations" (
    "id" int4 NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
    "migration" varchar(255) NOT NULL,
    "batch" int4 NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "public"."password_reset_tokens" (
    "email" varchar(255) NOT NULL,
    "token" varchar(255) NOT NULL,
    "created_at" timestamp(0),
    PRIMARY KEY ("email")
);

CREATE SEQUENCE IF NOT EXISTS users_id_seq;
CREATE TABLE "public"."users" (
    "id" int8 NOT NULL DEFAULT nextval('users_id_seq'::regclass),
    "name" varchar(255) NOT NULL,
    "email" varchar(255) NOT NULL,
    "email_verified_at" timestamp(0),
    "password" varchar(255) NOT NULL,
    "remember_token" varchar(100),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "is_admin" bool NOT NULL DEFAULT false,
    PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX users_email_unique ON public.users USING btree (email);

CREATE TABLE "public"."sessions" (
    "id" varchar(255) NOT NULL,
    "user_id" int8,
    "ip_address" varchar(45),
    "user_agent" text,
    "payload" text NOT NULL,
    "last_activity" int4 NOT NULL,
    PRIMARY KEY ("id")
);
CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);
CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);

CREATE TABLE "public"."cache" (
    "key" varchar(255) NOT NULL,
    "value" text NOT NULL,
    "expiration" int4 NOT NULL,
    PRIMARY KEY ("key")
);

CREATE TABLE "public"."cache_locks" (
    "key" varchar(255) NOT NULL,
    "owner" varchar(255) NOT NULL,
    "expiration" int4 NOT NULL,
    PRIMARY KEY ("key")
);

CREATE SEQUENCE IF NOT EXISTS jobs_id_seq;
CREATE TABLE "public"."jobs" (
    "id" int8 NOT NULL DEFAULT nextval('jobs_id_seq'::regclass),
    "queue" varchar(255) NOT NULL,
    "payload" text NOT NULL,
    "attempts" int2 NOT NULL,
    "reserved_at" int4,
    "available_at" int4 NOT NULL,
    "created_at" int4 NOT NULL,
    PRIMARY KEY ("id")
);
CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);

CREATE TABLE "public"."job_batches" (
    "id" varchar(255) NOT NULL,
    "name" varchar(255) NOT NULL,
    "total_jobs" int4 NOT NULL,
    "pending_jobs" int4 NOT NULL,
    "failed_jobs" int4 NOT NULL,
    "failed_job_ids" text NOT NULL,
    "options" text,
    "cancelled_at" int4,
    "created_at" int4 NOT NULL,
    "finished_at" int4,
    PRIMARY KEY ("id")
);

CREATE SEQUENCE IF NOT EXISTS failed_jobs_id_seq;
CREATE TABLE "public"."failed_jobs" (
    "id" int8 NOT NULL DEFAULT nextval('failed_jobs_id_seq'::regclass),
    "uuid" varchar(255) NOT NULL,
    "connection" text NOT NULL,
    "queue" text NOT NULL,
    "payload" text NOT NULL,
    "exception" text NOT NULL,
    "failed_at" timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX failed_jobs_uuid_unique ON public.failed_jobs USING btree (uuid);

-- 3. Crear tablas con dependencias (nivel 1)

CREATE SEQUENCE IF NOT EXISTS products_id_seq;
CREATE TABLE "public"."products" (
    "id" int8 NOT NULL DEFAULT nextval('products_id_seq'::regclass),
    "name" varchar(100) NOT NULL,
    "description" text,
    "price" numeric(10,2) NOT NULL,
    "image" varchar(100),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

CREATE SEQUENCE IF NOT EXISTS offers_id_seq;
CREATE TABLE "public"."offers" (
    "id" int8 NOT NULL DEFAULT nextval('offers_id_seq'::regclass),
    "date_delivery" date NOT NULL,
    "time_delivery" varchar(255) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    PRIMARY KEY ("id")
);

CREATE SEQUENCE IF NOT EXISTS orders_id_seq;
CREATE TABLE "public"."orders" (
    "id" int8 NOT NULL DEFAULT nextval('orders_id_seq'::regclass),
    "user_id" int8 NOT NULL,
    "total" numeric(10,2) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "orders_user_id_foreign" FOREIGN KEY ("user_id") REFERENCES "public"."users"("id") ON DELETE CASCADE,
    PRIMARY KEY ("id")
);

-- 4. Crear tablas con dependencias (nivel 2)

CREATE SEQUENCE IF NOT EXISTS product_offers_id_seq;
CREATE TABLE "public"."product_offers" (
    "id" int8 NOT NULL DEFAULT nextval('product_offers_id_seq'::regclass),
    "offer_id" int8 NOT NULL,
    "product_id" int8 NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "product_offers_offer_id_foreign" FOREIGN KEY ("offer_id") REFERENCES "public"."offers"("id") ON DELETE CASCADE,
    CONSTRAINT "product_offers_product_id_foreign" FOREIGN KEY ("product_id") REFERENCES "public"."products"("id") ON DELETE CASCADE,
    PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX product_offers_offer_id_product_id_unique ON public.product_offers USING btree (offer_id, product_id);

-- 5. Crear tablas con dependencias (nivel 3)

CREATE SEQUENCE IF NOT EXISTS product_orders_id_seq;
CREATE TABLE "public"."product_orders" (
    "id" int8 NOT NULL DEFAULT nextval('product_orders_id_seq'::regclass),
    "order_id" int8 NOT NULL,
    "product_id" int8 NOT NULL,
    "quantity" int4 NOT NULL DEFAULT 1,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    CONSTRAINT "product_orders_order_id_foreign" FOREIGN KEY ("order_id") REFERENCES "public"."orders"("id") ON DELETE CASCADE,
    CONSTRAINT "product_orders_product_id_foreign" FOREIGN KEY ("product_id") REFERENCES "public"."product_offers"("id"),
    PRIMARY KEY ("id")
);
CREATE UNIQUE INDEX product_orders_order_id_product_id_unique ON public.product_orders USING btree (order_id, product_id);

-- ============================================================
-- DATOS
-- ============================================================

INSERT INTO "public"."migrations" ("id", "migration", "batch") VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_20_179998_offers', 1),
(5, '2025_12_20_175956_products', 1),
(6, '2025_12_20_175958_product_offers', 1),
(7, '2025_12_20_181699_order', 1),
(8, '2025_12_20_181700_product_orders', 1),
(9, '2026_01_19_121834_role_admin_users', 1);

INSERT INTO "public"."users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "is_admin") VALUES
(2, 'carmen', 'carmen@gmail.com', NULL, '$2y$12$OWZF9Obsvwi/7U80gi8g0Ohb8xWOFjyXcEcRAe5N9Wrv3NmyNCuK6', NULL, '2026-03-04 09:00:40', '2026-03-04 09:00:40', 'f'),
(3, 'admin', 'admin@gmail.com', NULL, '$2y$12$3UhhrL9WeDbLDjEk07NfpeQdgfVZcv4614q5EzMFEirfGk7qHwveW', NULL, '2026-03-04 09:53:17', '2026-03-04 09:53:17', 't');

INSERT INTO "public"."products" ("id", "name", "description", "price", "image", "created_at", "updated_at") VALUES
(2, 'solomillo', 'dfgdfh', 12.00, NULL, '2026-02-03 19:41:55', '2026-02-03 19:41:55'),
(7, 'pollo', 'ertregdf', 12.00, NULL, '2026-02-04 16:52:54', '2026-02-04 16:52:54'),
(10, 'salmon', 'dfgdg', 12.00, NULL, '2026-02-04 17:01:15', '2026-02-04 17:01:15'),
(11, 'Albondigas', 'safasd', 4.00, NULL, '2026-02-04 17:01:28', '2026-02-04 17:01:28'),
(12, 'Pollo', 'Pollo al curry', 8.00, 'uploads/bXdtPQ9vEOo9D8NtYtGKSf1p0Eh60qdIWg57QOxT.png', '2026-03-04 09:38:21', '2026-03-04 09:38:21'),
(14, 'Hamburguesa', 'Hamburguesa clasica', 10.00, 'uploads/PRai0mdbTgo3GgsvK7fspsayDQauJlStC6RgLkqi.png', '2026-03-04 09:46:50', '2026-03-04 09:46:50');

INSERT INTO "public"."offers" ("id", "date_delivery", "time_delivery", "created_at", "updated_at") VALUES
(4, '2026-02-26', '13:30-14:30', '2026-02-16 17:20:59', '2026-02-16 17:20:59'),
(9, '2026-03-18', '13:30-14:30', '2026-03-04 09:38:50', '2026-03-04 09:38:50'),
(10, '2026-03-25', '13:30-14:30', '2026-03-04 09:47:08', '2026-03-04 09:47:08');

INSERT INTO "public"."orders" ("id", "user_id", "total", "created_at", "updated_at") VALUES
(5, 2, 12.00, '2026-03-04 09:23:07', '2026-03-04 09:23:07');

INSERT INTO "public"."product_offers" ("id", "offer_id", "product_id", "created_at", "updated_at") VALUES
(4, 4, 2, '2026-02-16 17:20:59', '2026-02-16 17:20:59'),
(9, 9, 12, '2026-03-04 09:38:50', '2026-03-04 09:38:50'),
(10, 10, 14, '2026-03-04 09:47:08', '2026-03-04 09:47:08');

INSERT INTO "public"."product_orders" ("id", "order_id", "product_id", "quantity", "created_at", "updated_at") VALUES
(5, 5, 4, 1, '2026-03-04 09:23:07', '2026-03-04 09:23:07');
