# NEXOAPP VISUAL DESIGN SYSTEM

Este documento define la estética visual obligatoria para todas las vistas del proyecto.
Cualquier interfaz generada debe adherirse estrictamente a estas reglas de estilo, ignorando los colores o estilos de las imágenes de referencia (wireframes) y aplicando únicamente esta capa visual "Dark Luxury".

## 1. Filosofía Visual (Look & Feel)
* **Estilo:** Minimalismo "High-Fashion" / Brutalismo Suave.
* **Atmósfera:** La interfaz debe sentirse oscura, exclusiva, espaciosa y seria.
* **Referencia Mental:** Piensa en sitios web de marcas de moda de lujo (Balenciaga, Zara, SSENSE) en modo oscuro.

## 2. Paleta de Colores (Strict Dark Mode)
* **Fondo Principal (Canvas):** Gris Carbón Profundo / Casi Negro (ej. `#1a1a1a` o `#121212`). NUNCA usar fondos blancos para contenedores principales.
* **Texto Primario:** Blanco Hueso / Gris Platino (ej. `#F3F4F6`). Evita el blanco puro (`#FFFFFF`) para textos largos para reducir la fatiga visual.
* **Texto Secundario:** Gris Medio (ej. `#9CA3AF`) para etiquetas, placeholders y descripciones.
* **Bordes y Separadores:** Muy sutiles, casi invisibles (ej. `#374151`), solo para estructurar sin saturar.

## 3. Tipografía
* **Familia:** Sans-Serif geométrica y limpia (ej. 'Outfit', 'Manrope', 'Syne').
* **Encabezados (Títulos):**
    * Transformación: MAYÚSCULAS (Uppercase).
    * Espaciado (Tracking): Amplio (Wide/Widest). Las letras deben "respirar".
    * Peso: Bold o Semibold, pero visualmente ligero gracias al espaciado.
* **Cuerpo:** Legible, limpio, con buena altura de línea.

## 4. Componentes UI (Reglas de Construcción)

### A. Inputs (Campos de Formulario)
* **Estilo:** "Invisible" o "Underline".
* **Fondo:** Transparente. NUNCA usar cajas blancas o grises sólidas.
* **Borde:**
    * Estado Normal: Solo borde inferior (border-bottom) o borde completo muy fino (1px) en gris oscuro.
    * Estado Focus: El borde se ilumina a blanco/gris claro.
* **Texto:** Blanco/Claro.

### B. Botones (CTAs)
* **Forma:** Rectangulares. Bordes afilados (border-radius: 0) o mínimamente redondeados (2px). Evita botones totalmente redondos (píldora).
* **Estado Normal:** Fondo Sólido (Blanco o Negro dependiendo del contraste) con Texto opuesto.
* **Interacción (Hover):** INVERSIÓN TOTAL.
    * Si el botón es negro: al pasar el mouse se vuelve blanco con texto negro.
    * Si el botón es blanco: al pasar el mouse se vuelve negro con texto blanco.
    * Transición: Suave (300ms ease-in-out).

### C. Tarjetas y Contenedores
* **Fondo:** Igual al fondo principal o ligeramente más claro (muy sutil) para dar profundidad.
* **Bordes:** Finos (1px) y discretos.
* **Sombras:** Nulas o muy difusas/suaves. Preferimos el diseño plano (flat).

## 5. Layouts y Estructura (Sin medidas fijas)
* **Split-Screen (Pantalla Dividida):** Para registros y logins, usar siempre una división vertical.
    * **Lado Funcional:** Contiene el formulario, logo y textos. Debe tener mucho espacio vacío (padding) alrededor. Alineación vertical centrada.
    * **Lado Visual:** Espacio reservado para imágenes de campaña, texturas o colores sólidos oscuros. Ocupa el resto del espacio disponible.
* **Responsividad:** En móviles, los elementos se apilan (Stack) verticalmente de forma natural.

---
**Instrucción para la IA:** Al generar código, usa clases de utilidad (Tailwind CSS) que cumplan estas reglas visuales. Si te paso un wireframe blanco, ignora sus colores y aplica ESTE sistema oscuro.