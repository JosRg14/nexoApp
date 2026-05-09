<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NexoApp — Videos</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }

        body {
            background: #1a1a1a;
            color: #F3F4F6;
            font-family: 'Inter', system-ui, sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        /* ── Header ── */
        .v-header {
            background: #111;
            border-bottom: 1px solid #2d2d2d;
            padding: 0 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .v-logo {
            font-size: 1.1rem;
            font-weight: 900;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #fff;
        }
        .v-logo span { color: #25B5DA; }
        .v-sep {
            color: #374151;
            font-size: 1.2rem;
        }
        .v-title {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: #9CA3AF;
        }

        /* ── Page ── */
        .v-page {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }

        /* ── Upload card ── */
        .upload-card {
            background: #262626;
            border: 1px solid #374151;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2.5rem;
            transition: border-color .3s;
        }
        .upload-card:focus-within {
            border-color: #25B5DA44;
        }
        .upload-card h2 {
            font-size: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: #fff;
            margin: 0 0 1.5rem;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .upload-card h2 i { color: #25B5DA; }

        .v-label {
            display: block;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #9CA3AF;
            margin-bottom: .4rem;
        }
        .v-input {
            width: 100%;
            background: #1a1a1a;
            border: 1px solid #374151;
            border-radius: .5rem;
            color: #F3F4F6;
            padding: .65rem .9rem;
            font-size: .9rem;
            outline: none;
            transition: border-color .25s, box-shadow .25s;
        }
        .v-input:focus {
            border-color: #25B5DA;
            box-shadow: 0 0 0 3px rgba(37,181,218,.12);
        }
        textarea.v-input { resize: vertical; min-height: 80px; }

        /* ── Drop zone ── */
        .drop-zone {
            border: 2px dashed #374151;
            border-radius: .75rem;
            padding: 2rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: border-color .3s, background .3s;
            background: #1a1a1a;
        }
        .drop-zone.drag-over {
            border-color: #25B5DA;
            background: rgba(37,181,218,.05);
        }
        .drop-zone i { color: #25B5DA; font-size: 2rem; margin-bottom: .6rem; display: block; }
        .drop-zone p { color: #9CA3AF; font-size: .82rem; margin: 0; }
        .drop-zone strong { color: #25B5DA; }
        #file-name {
            margin-top: .5rem;
            font-size: .78rem;
            color: #25B5DA;
            font-weight: 700;
            display: none;
        }

        /* ── Progress bar ── */
        .progress-wrap {
            display: none;
            margin-top: 1rem;
        }
        .progress-bar-bg {
            height: 6px;
            background: #374151;
            border-radius: 9999px;
            overflow: hidden;
        }
        .progress-bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #25B5DA, #1c8fb0);
            border-radius: 9999px;
            transition: width .15s linear;
        }
        .progress-label {
            font-size: .72rem;
            color: #9CA3AF;
            margin-top: .35rem;
            text-align: right;
        }

        /* ── Button ── */
        .btn-primary {
            background: linear-gradient(135deg, #25B5DA, #1c8fb0);
            color: #000;
            font-weight: 900;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .12em;
            border: none;
            border-radius: .6rem;
            padding: .75rem 2rem;
            cursor: pointer;
            transition: opacity .2s, transform .2s, box-shadow .2s;
        }
        .btn-primary:hover:not(:disabled) {
            opacity: .9;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37,181,218,.35);
        }
        .btn-primary:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        /* ── Grid de videos ── */
        .section-title {
            font-size: 1.1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #fff;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .section-title i { color: #25B5DA; }
        .section-title .pill {
            background: #374151;
            color: #9CA3AF;
            font-size: .65rem;
            padding: .2rem .6rem;
            border-radius: 9999px;
            font-weight: 700;
            letter-spacing: .08em;
        }

        .videos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        /* ── Video card ── */
        .video-card {
            background: #262626;
            border: 1px solid #374151;
            border-radius: 1rem;
            overflow: hidden;
            transition: border-color .3s, transform .3s, box-shadow .3s;
        }
        .video-card:hover {
            border-color: #25B5DA55;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(37,181,218,.1);
        }
        .video-card video {
            width: 100%;
            display: block;
            background: #111;
            max-height: 220px;
            object-fit: contain;
        }
        .video-meta {
            padding: 1rem 1.1rem 1.1rem;
        }
        .video-meta h3 {
            font-size: .92rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 .3rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .video-meta p {
            font-size: .78rem;
            color: #9CA3AF;
            margin: 0 0 .75rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .video-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .video-date {
            font-size: .7rem;
            color: #4B5563;
            letter-spacing: .05em;
        }
        .btn-delete {
            background: transparent;
            border: 1px solid #4B5563;
            color: #9CA3AF;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: .3rem .8rem;
            border-radius: .4rem;
            cursor: pointer;
            transition: border-color .2s, color .2s, background .2s;
        }
        .btn-delete:hover {
            border-color: #ef4444;
            color: #ef4444;
            background: rgba(239,68,68,.08);
        }

        /* ── Uploader line ── */
        .video-uploader {
            font-size: .72rem;
            color: #6B7280;
            margin: 0 0 .6rem;
            display: flex;
            align-items: center;
            gap: .35rem;
            line-height: 1;
        }
        .video-uploader i { color: #4B5563; font-size: .7rem; }
        .video-uploader span { color: #9CA3AF; }
        .owner-badge {
            background: rgba(37,181,218,.15);
            color: #25B5DA;
            font-size: .6rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: .1rem .4rem;
            border-radius: 9999px;
            border: 1px solid rgba(37,181,218,.3);
            line-height: 1.4;
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #4B5563;
        }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; }
        .empty-state p { font-size: .9rem; }

        /* ── Toast ── */
        #v-toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: .5rem;
            pointer-events: none;
        }
        .v-toast-item {
            padding: .75rem 1.25rem;
            border-radius: .6rem;
            font-size: .82rem;
            font-weight: 700;
            color: #fff;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity .3s, transform .3s;
            pointer-events: none;
        }
        .v-toast-item.show { opacity: 1; transform: translateY(0); }
        .v-toast-item.success { background: #16a34a; }
        .v-toast-item.error   { background: #dc2626; }

        /* ── Loader ── */
        .spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(0,0,0,.3);
            border-top-color: #000;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            vertical-align: middle;
            margin-right: 6px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Responsivo ── */
        @media (max-width: 640px) {
            .v-page { padding: 1.5rem 1rem 3rem; }
            .upload-card { padding: 1.25rem; }
            .videos-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- ── Header limpio sin menú ── --}}
    <header class="v-header">
        <span class="v-logo">Nexo<span>App</span></span>
        <span class="v-sep">/</span>
        <span class="v-title">Videos</span>
    </header>

    <main class="v-page">

        {{-- ── Formulario de subida ── --}}
        <div class="upload-card">
            <h2><i class="fas fa-cloud-upload-alt"></i> Subir Video</h2>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                <div>
                    <label class="v-label" for="v-titulo">Título <span style="color:#ef4444">*</span></label>
                    <input id="v-titulo" type="text" class="v-input" placeholder="Ej. Tutorial de producto" maxlength="255">
                </div>
                <div>
                    <label class="v-label" for="v-descripcion">Descripción</label>
                    <input id="v-descripcion" type="text" class="v-input" placeholder="Opcional…" maxlength="1000">
                </div>
            </div>

            <label class="v-label" style="margin-bottom:.5rem;">Archivo de video <span style="color:#ef4444">*</span></label>
            <div id="drop-zone" class="drop-zone" onclick="document.getElementById('v-file').click()">
                <i class="fas fa-film"></i>
                <p>Arrastra tu video aquí o <strong>haz clic para seleccionar</strong></p>
                <p style="margin-top:.3rem; font-size:.7rem; color:#4B5563;">mp4 · mov · avi · webm &nbsp;·&nbsp; máx. 500 MB</p>
            </div>
            <div id="file-name"></div>
            <input id="v-file" type="file" accept="video/mp4,video/quicktime,video/x-msvideo,video/webm" style="display:none">

            {{-- Barra de progreso --}}
            <div id="progress-wrap" class="progress-wrap">
                <div class="progress-bar-bg">
                    <div id="progress-fill" class="progress-bar-fill"></div>
                </div>
                <div id="progress-label" class="progress-label">0%</div>
            </div>

            <div style="margin-top:1.25rem; display:flex; justify-content:flex-end;">
                <button id="btn-upload" class="btn-primary" onclick="uploadVideo()">
                    <i class="fas fa-upload" style="margin-right:6px;"></i>Subir Video
                </button>
            </div>
        </div>

        {{-- ── Lista de videos ── --}}
        <div class="section-title">
            <i class="fas fa-play-circle"></i>
            Videos
            <span class="pill" id="count-pill">—</span>
        </div>

        <div id="videos-grid" class="videos-grid">
            {{-- Skeleton --}}
            @for ($i = 0; $i < 3; $i++)
            <div class="video-card" style="opacity:.4; pointer-events:none;">
                <div style="height:160px; background:#374151; animation:pulse 1.5s ease-in-out infinite;"></div>
                <div class="video-meta">
                    <div style="height:14px; background:#374151; border-radius:4px; width:70%; margin-bottom:.5rem;"></div>
                    <div style="height:10px; background:#2d2d2d; border-radius:4px; width:90%; margin-bottom:.4rem;"></div>
                    <div style="height:10px; background:#2d2d2d; border-radius:4px; width:50%;"></div>
                </div>
            </div>
            @endfor
        </div>

    </main>

    {{-- Toast container --}}
    <div id="v-toast"></div>

    <script>
        // ── Datos de sesión ────────────────────────────────────────────────
        const SESSION_USER_ID = @json(session('usuario.id') ?? session('usuario.empleado.id') ?? null);
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // ── Drop zone ──────────────────────────────────────────────────────
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('v-file');
        const fileNameEl = document.getElementById('file-name');

        dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('drag-over'); });
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            const dt = e.dataTransfer;
            if (dt.files.length) {
                fileInput.files = dt.files;
                showFileName(dt.files[0]);
            }
        });
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) showFileName(fileInput.files[0]);
        });
        function showFileName(file) {
            const mb = (file.size / 1024 / 1024).toFixed(1);
            fileNameEl.style.display = 'block';
            fileNameEl.innerHTML = `<i class="fas fa-check-circle" style="margin-right:5px;"></i>${file.name} <span style="color:#9CA3AF;">(${mb} MB)</span>`;
        }

        // ── Upload con XHR (progreso real) ─────────────────────────────────
        async function uploadVideo() {
            const titulo      = document.getElementById('v-titulo').value.trim();
            const descripcion = document.getElementById('v-descripcion').value.trim();
            const file        = fileInput.files[0];

            if (!titulo) { toast('El título es requerido', 'error'); return; }
            if (!file)   { toast('Selecciona un archivo de video', 'error'); return; }

            const btn          = document.getElementById('btn-upload');
            const progressWrap = document.getElementById('progress-wrap');
            const fill         = document.getElementById('progress-fill');
            const label        = document.getElementById('progress-label');

            btn.disabled  = true;
            btn.innerHTML = '<span class="spinner"></span>Subiendo…';
            progressWrap.style.display = 'block';
            fill.style.width = '0%';
            label.textContent = '0%';

            try {
                const CHUNK_SIZE = 5 * 1024 * 1024; // 5MB
                const totalChunks = Math.ceil(file.size / CHUNK_SIZE);
                let finalData = null;

                for (let i = 0; i < totalChunks; i++) {
                    const start = i * CHUNK_SIZE;
                    const end = Math.min(start + CHUNK_SIZE, file.size);
                    const chunk = file.slice(start, end);

                    const fd = new FormData();
                    fd.append('_token', CSRF);
                    fd.append('video', chunk, file.name);
                    fd.append('titulo', titulo);
                    fd.append('descripcion', descripcion);
                    fd.append('chunk_index', i);
                    fd.append('total_chunks', totalChunks);
                    fd.append('file_name', file.name);

                    const response = await fetch('/api-proxy/videos/chunk', {
                        method: 'POST',
                        body: fd
                    });

                    const data = await response.json();
                    
                    if (!response.ok || data.success === false) {
                        throw new Error(data.message || 'Error al subir chunk');
                    }

                    // Si es el último chunk, la respuesta contendrá el data final de la API
                    if (i === totalChunks - 1) {
                        finalData = data;
                    }

                    const pct = Math.round(((i + 1) / totalChunks) * 100);
                    fill.style.width   = pct + '%';
                    label.textContent  = pct + '%';
                }

                // Éxito final
                toast('Video subido correctamente ✓', 'success');
                document.getElementById('v-titulo').value      = '';
                document.getElementById('v-descripcion').value = '';
                fileInput.value = '';
                fileNameEl.style.display = 'none';
                loadVideos();

            } catch (e) {
                console.error('Error de subida:', e);
                toast(e.message || 'Error de conexión al subir el video', 'error');
            } finally {
                btn.disabled  = false;
                btn.innerHTML = '<i class="fas fa-upload" style="margin-right:6px;"></i>Subir Video';
                progressWrap.style.display = 'none';
            }
        }

        // ── Cargar lista de videos ─────────────────────────────────────────
        async function loadVideos() {
            try {
                const res  = await fetch('/api-proxy/videos', {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
                });
                const data = await res.json();
                const videos = data.data ?? data ?? [];
                renderVideos(videos);
            } catch(e) {
                console.error('Error al cargar videos:', e);
                renderVideos([]);
            }
        }

        function renderVideos(videos) {
            const grid  = document.getElementById('videos-grid');
            const pill  = document.getElementById('count-pill');
            pill.textContent = videos.length;

            if (!videos.length) {
                grid.innerHTML = `
                    <div class="empty-state" style="grid-column:1/-1;">
                        <i class="fas fa-film"></i>
                        <p>Aún no hay videos subidos.<br>¡Sube el primero!</p>
                    </div>`;
                return;
            }

            grid.innerHTML = videos.map(v => {
                const isOwner    = v.usuario_id == SESSION_USER_ID || v.user_id == SESSION_USER_ID;
                const uploaderName = escHtml(v.usuario_nombre ?? v.user_name ?? 'Usuario');
                const fecha      = v.created_at
                    ? new Date(v.created_at).toLocaleDateString('es-CL', { day:'2-digit', month:'2-digit', year:'numeric' })
                    : '';

                // URL del video — soporta campo directo o URL de storage
                const videoUrl = v.url ?? v.video_url ?? `/api-proxy/storage/${v.path ?? ''}`;

                return `
                <article class="video-card">
                    <video controls preload="metadata" poster="">
                        <source src="${videoUrl}" type="video/mp4">
                        Tu navegador no soporta reproducción de video.
                    </video>
                    <div class="video-meta">
                        <h3 title="${escHtml(v.titulo ?? v.title ?? 'Sin título')}">${escHtml(v.titulo ?? v.title ?? 'Sin título')}</h3>
                        <p>${escHtml(v.descripcion ?? v.description ?? '')}</p>
                        <p class="video-uploader">
                            <i class="fas fa-user-circle"></i>
                            Subido por: <span>${uploaderName}</span>
                            ${isOwner ? '<span class="owner-badge">Tú</span>' : ''}
                        </p>
                        <div class="video-footer">
                            <span class="video-date"><i class="fas fa-calendar-alt" style="margin-right:4px;color:#374151;"></i>${fecha}</span>
                            ${isOwner ? `<button class="btn-delete" onclick="deleteVideo(${v.id})"><i class="fas fa-trash" style="margin-right:4px;"></i>Eliminar</button>` : ''}
                        </div>
                    </div>
                </article>`;
            }).join('');
        }

        // ── Eliminar video ────────────────────────────────────────────────
        async function deleteVideo(id) {
            if (!confirm('¿Confirmas que deseas eliminar este video? Esta acción no se puede deshacer.')) return;

            try {
                const res  = await fetch(`/api-proxy/videos/${id}`, {
                    method:  'DELETE',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
                });
                const data = await res.json();

                if (res.ok) {
                    toast('Video eliminado correctamente', 'success');
                    loadVideos();
                } else {
                    toast(data.message || 'No se pudo eliminar el video', 'error');
                }
            } catch(e) {
                toast('Error de conexión al eliminar', 'error');
            }
        }

        // ── Toast ─────────────────────────────────────────────────────────
        function toast(msg, type = 'success') {
            const container = document.getElementById('v-toast');
            const el = document.createElement('div');
            el.className = `v-toast-item ${type}`;
            el.textContent = msg;
            container.appendChild(el);
            requestAnimationFrame(() => { requestAnimationFrame(() => el.classList.add('show')); });
            setTimeout(() => {
                el.classList.remove('show');
                setTimeout(() => el.remove(), 350);
            }, 3500);
        }

        // ── Util ──────────────────────────────────────────────────────────
        function escHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g,'&amp;')
                .replace(/</g,'&lt;')
                .replace(/>/g,'&gt;')
                .replace(/"/g,'&quot;');
        }

        // ── Init ──────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', loadVideos);
    </script>
</body>
</html>
