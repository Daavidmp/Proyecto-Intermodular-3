-- ============================================================
-- SISTEMA DE MISIONES - MRTN
-- Adaptado al esquema real de la base de datos
-- ============================================================

-- 1. Añadir columnas a logros (puntos y dificultad)
ALTER TABLE public.logros ADD COLUMN IF NOT EXISTS puntos INTEGER DEFAULT 0;
ALTER TABLE public.logros ADD COLUMN IF NOT EXISTS dificultad TEXT DEFAULT 'facil';

-- 2. Asignar puntos y dificultad a cada misión existente
UPDATE public.logros SET puntos = 5,   dificultad = 'facil'      WHERE nombre = 'Iniciar sesion';
UPDATE public.logros SET puntos = 5,   dificultad = 'facil'      WHERE nombre = 'Tu primer fan';
UPDATE public.logros SET puntos = 10,  dificultad = 'facil'      WHERE nombre = 'Señal de Afinidad';
UPDATE public.logros SET puntos = 10,  dificultad = 'facil'      WHERE nombre = 'Voto de Contraste';
UPDATE public.logros SET puntos = 15,  dificultad = 'normal'     WHERE nombre = 'Romper el silencio';
UPDATE public.logros SET puntos = 15,  dificultad = 'normal'     WHERE nombre = 'Apuesta al Destino';
UPDATE public.logros SET puntos = 20,  dificultad = 'normal'     WHERE nombre = 'Seguir a una persona';
UPDATE public.logros SET puntos = 30,  dificultad = 'dificil'    WHERE nombre = 'Los primeros 10 seguidores';
UPDATE public.logros SET puntos = 50,  dificultad = 'dificil'    WHERE nombre = 'Los Primeros 100 Seguidores';
UPDATE public.logros SET puntos = 100, dificultad = 'epico'      WHERE nombre = 'Tu Primera Comunidad (1K Seguidores)';
UPDATE public.logros SET puntos = 200, dificultad = 'epico'      WHERE nombre = 'Creador Establecido (100K Seguidores)';
UPDATE public.logros SET puntos = 500, dificultad = 'legendario' WHERE nombre = 'Contenido Viral';

-- 3. Añadir columna recompensa_recogida a logros_obtenidos (ya existe la tabla)
ALTER TABLE public.logros_obtenidos ADD COLUMN IF NOT EXISTS recompensa_recogida BOOLEAN DEFAULT FALSE;

-- 4. Crear tabla de notificaciones
CREATE TABLE IF NOT EXISTS public.notificaciones (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    usuario_id UUID NOT NULL REFERENCES public.usuarios(id) ON DELETE CASCADE,
    tipo TEXT NOT NULL CHECK (tipo IN ('mision', 'mensaje')),
    titulo TEXT NOT NULL,
    descripcion TEXT,
    leida BOOLEAN DEFAULT FALSE,
    dato_extra TEXT,
    fecha TIMESTAMP WITH TIME ZONE DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_notificaciones_usuario ON public.notificaciones(usuario_id);
CREATE INDEX IF NOT EXISTS idx_notificaciones_no_leidas ON public.notificaciones(usuario_id, leida);
