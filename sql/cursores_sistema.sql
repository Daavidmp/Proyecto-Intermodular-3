-- ============================================================
-- SISTEMA DE CURSORES - MRTN
-- Ejecutar una sola vez en la base de datos
-- ============================================================

-- 1. Tabla de cursores obtenidos por usuario
CREATE TABLE IF NOT EXISTS public.cursores_obtenidos (
    id          UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    usuario_id  UUID NOT NULL REFERENCES public.usuarios(id) ON DELETE CASCADE,
    nombre_cursor TEXT NOT NULL,
    rareza      TEXT NOT NULL DEFAULT 'comun',
    fecha       TIMESTAMP WITH TIME ZONE DEFAULT NOW(),
    UNIQUE (usuario_id, nombre_cursor)
);

CREATE INDEX IF NOT EXISTS idx_cursores_usuario ON public.cursores_obtenidos(usuario_id);

-- 2. Columna cursor_activo en usuarios (NULL = cursor por defecto del navegador)
ALTER TABLE public.usuarios ADD COLUMN IF NOT EXISTS cursor_activo TEXT DEFAULT NULL;
