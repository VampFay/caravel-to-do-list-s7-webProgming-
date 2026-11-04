<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fay Notes — Glass Fluid Scratchpad & Docs</title>
    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    
    <!-- Theme Script to Prevent Flash of Wrong Theme -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('fay_theme');
            if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
                    },
                    colors: {
                        duo: {
                            green: '#58cc02',
                            greenDark: '#46a302',
                            greenLight: '#89e219',
                            blue: '#1cb0f6',
                            blueDark: '#1899d6',
                            orange: '#ff9600',
                            orangeDark: '#e58500',
                            rose: '#ff4b4b',
                            roseDark: '#ea2b2b',
                            purple: '#ce82ff',
                            purpleDark: '#a544ee',
                            yellow: '#ffc800',
                            yellowDark: '#e5b200',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* ==========================================================================
           GLASS FLUID UI-UX ARCHITECTURE (Notes Edition)
           ========================================================================== */
        :root {
            --bg-page: #f0f4f9;
            --glass-bg: rgba(255, 255, 255, 0.72);
            --glass-card: rgba(255, 255, 255, 0.82);
            --glass-card-hover: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.85);
            --glass-border-subtle: rgba(226, 232, 240, 0.8);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.08), 0 2px 8px 0 rgba(0, 0, 0, 0.04);
            --glass-shadow-hover: 0 16px 40px 0 rgba(31, 38, 135, 0.14), 0 4px 12px 0 rgba(88, 204, 2, 0.15);
            --text-primary: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --input-glass: rgba(255, 255, 255, 0.9);
            --tag-glass: rgba(241, 245, 249, 0.85);
            --tag-border: rgba(226, 232, 240, 0.9);
            --orb-1: rgba(99, 102, 241, 0.22);
            --orb-2: rgba(56, 189, 248, 0.2);
            --orb-3: rgba(168, 85, 247, 0.18);
            --orb-4: rgba(88, 204, 2, 0.18);
        }

        html.dark {
            --bg-page: #06070a;
            --glass-bg: rgba(13, 17, 26, 0.7);
            --glass-card: rgba(17, 23, 36, 0.72);
            --glass-card-hover: rgba(22, 30, 48, 0.85);
            --glass-border: rgba(255, 255, 255, 0.09);
            --glass-border-subtle: rgba(255, 255, 255, 0.05);
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.55), 0 0 0 1px rgba(255, 255, 255, 0.05);
            --glass-shadow-hover: 0 16px 44px 0 rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(99, 102, 241, 0.35);
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --input-glass: rgba(10, 14, 22, 0.8);
            --tag-glass: rgba(20, 27, 42, 0.8);
            --tag-border: rgba(255, 255, 255, 0.08);
            --orb-1: rgba(99, 102, 241, 0.18);
            --orb-2: rgba(14, 165, 233, 0.15);
            --orb-3: rgba(168, 85, 247, 0.16);
            --orb-4: rgba(88, 204, 2, 0.14);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-primary);
            letter-spacing: -0.012em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transition: background-color 0.4s cubic-bezier(0.16, 1, 0.3, 1), color 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fluid-blob-1 {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(60px, -80px) scale(1.15); }
            66% { transform: translate(-40px, 50px) scale(0.92); }
        }
        @keyframes fluid-blob-2 {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(-70px, 70px) scale(1.2); }
            66% { transform: translate(50px, -60px) scale(0.88); }
        }

        .fluid-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(85px);
            pointer-events: none;
            opacity: 0.85;
            transition: background 0.5s ease;
        }

        .glass-panel {
            background: var(--glass-card);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* 3D Duolingo Tactile Push Buttons */
        .duo-btn-green {
            background-color: #58cc02;
            box-shadow: 0 4px 0 0 #46a302, 0 6px 16px rgba(88, 204, 2, 0.3);
            transition: all 0.12s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .duo-btn-green:hover {
            background-color: #61e002;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 0 #46a302, 0 10px 22px rgba(88, 204, 2, 0.4);
        }
        .duo-btn-green:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 0 #46a302, 0 2px 6px rgba(88, 204, 2, 0.2);
        }

        .duo-btn-glass {
            background: var(--glass-card);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 3px 0 0 var(--glass-border-subtle), var(--glass-shadow);
            transition: all 0.15s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .duo-btn-glass:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 0 0 var(--glass-border-subtle), var(--glass-shadow-hover);
        }
        .duo-btn-glass:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 0 var(--glass-border-subtle);
        }

        /* Active note card glow */
        .note-card-active {
            border-color: rgba(99, 102, 241, 0.75) !important;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.35), 0 12px 32px 0 rgba(99, 102, 241, 0.2) !important;
            background: var(--glass-card-hover) !important;
        }

        /* Spring Drop In Animation */
        @keyframes springDropIn {
            0% { opacity: 0; transform: translateY(-20px) scale(0.95); }
            60% { opacity: 1; transform: translateY(4px) scale(1.02); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .animate-spring-in {
            animation: springDropIn 0.38s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        /* Mascot Mascot Float & Bob */
        @keyframes mascot-bob {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-6px) rotate(2deg); }
        }
        .animate-mascot {
            animation: mascot-bob 3.2s infinite ease-in-out;
            transform-origin: bottom center;
        }

        @keyframes eq-dance-1 { 0%, 100% { height: 4px; } 50% { height: 16px; } }
        @keyframes eq-dance-2 { 0%, 100% { height: 14px; } 50% { height: 5px; } }
        @keyframes eq-dance-3 { 0%, 100% { height: 8px; } 50% { height: 18px; } }
        @keyframes eq-dance-4 { 0%, 100% { height: 16px; } 50% { height: 6px; } }

        .eq-bar-1 { animation: eq-dance-1 0.7s infinite ease-in-out; }
        .eq-bar-2 { animation: eq-dance-2 0.85s infinite ease-in-out; }
        .eq-bar-3 { animation: eq-dance-3 0.65s infinite ease-in-out; }
        .eq-bar-4 { animation: eq-dance-4 0.9s infinite ease-in-out; }

        input[type=range].glass-slider {
            -webkit-appearance: none;
            background: var(--tag-glass);
            height: 4px;
            border-radius: 9999px;
            outline: none;
        }
        input[type=range].glass-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #58cc02;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(88, 204, 2, 0.4);
            transition: transform 0.1s ease;
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--glass-border); border-radius: 4px; }
    </style>
</head>
<body class="min-h-full flex flex-col md:flex-row antialiased selection:bg-indigo-500/30 selection:text-indigo-400 relative overflow-x-hidden">

    <!-- Fluid Ambient Animated Background Blobs -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="fluid-orb w-96 h-96 -top-20 -left-20" style="background: var(--orb-1); animation: fluid-blob-1 18s infinite ease-in-out;"></div>
        <div class="fluid-orb w-[30rem] h-[30rem] top-1/3 -right-32" style="background: var(--orb-2); animation: fluid-blob-2 22s infinite ease-in-out;"></div>
    </div>

    <!-- Mobile Top Header Bar -->
    <header class="md:hidden flex items-center justify-between border-b px-4 py-3 sticky top-0 z-30 glass-panel"
            style="border-color: var(--glass-border-subtle);">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-duo-purple to-indigo-500 flex items-center justify-center text-white font-mono text-sm font-extrabold shadow-sm">
                N
            </div>
            <div>
                <span class="font-extrabold text-sm tracking-tight block leading-none" style="color: var(--text-primary)">Fay Notes</span>
                <span class="font-mono text-[9px] text-indigo-400 font-bold leading-none">Scratchpad & Docs</span>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('todos.index') }}" class="px-2.5 py-1 rounded-xl border text-xs font-mono font-bold flex items-center gap-1 text-slate-400 hover:text-emerald-400"
               style="background: var(--glass-card); border-color: var(--glass-border);">
                <span>🎯 Tasks</span>
            </a>
            <button type="button" onclick="createNewNoteAsync()" class="p-1.5 rounded-lg duo-btn-green text-slate-950 font-black text-xs">
                + Note
            </button>
            <button type="button" onclick="toggleTheme()" class="p-1.5 text-slate-400 hover:text-amber-500">
                <span id="mobile-theme-icon">☀️</span>
            </button>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="hidden md:flex flex-col w-64 lg:w-72 border-r shrink-0 h-screen sticky top-0 p-4 select-none overflow-y-auto z-20 glass-panel"
           style="border-color: var(--glass-border-subtle); border-radius: 0;">
        
        <!-- Workspace Identification & Mode Switcher -->
        <div class="flex items-center justify-between px-3 py-2.5 mb-3 rounded-2xl border"
             style="background: var(--glass-bg); border-color: var(--glass-border);">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-purple-500 via-indigo-600 to-sky-500 flex items-center justify-center text-white shadow-xs font-mono font-bold text-xs shrink-0">
                    N
                </div>
                <div class="min-w-0">
                    <h2 class="font-extrabold text-xs truncate leading-none" style="color: var(--text-primary)">Fay Workspace</h2>
                    <p class="font-mono text-[9px] mt-1 leading-none truncate text-indigo-400 font-bold">Notes & Scratchpad</p>
                </div>
            </div>

            <!-- Theme Toggle Pill Button -->
            <button type="button" onclick="toggleTheme()" id="theme-toggle-btn" title="Toggle Light / Dark Mode (T)"
                    class="flex items-center gap-1 font-mono text-[10px] px-2 py-1 rounded-xl border font-bold transition active:scale-90"
                    style="background: var(--glass-card); border-color: var(--glass-border); color: var(--text-secondary);">
                <span id="theme-icon">☀️</span>
                <span id="theme-label">Light</span>
            </button>
        </div>

        <!-- Primary Dual-Mode Navigation Switcher (Tasks vs Notes) -->
        <div class="grid grid-cols-2 gap-1.5 p-1 mb-3.5 rounded-2xl border"
             style="background: var(--glass-bg); border-color: var(--glass-border);">
            <a href="{{ route('todos.index') }}"
               class="py-2 px-2.5 rounded-xl text-center text-xs font-mono font-bold transition flex items-center justify-center gap-1.5 text-slate-400 hover:text-slate-200 hover:bg-white/5">
                <span>🎯 Tasks</span>
            </a>
            <a href="{{ route('notes.index') }}"
               class="py-2 px-2.5 rounded-xl text-center text-xs font-mono font-bold transition flex items-center justify-center gap-1.5 shadow-sm"
               style="background: var(--glass-card); border: 1px solid var(--glass-border); color: var(--text-primary);">
                <span>📝 Notes</span>
            </a>
        </div>

        <!-- Lo-Fi Music & Focus Engine Strip -->
        <div class="p-3 mb-3.5 rounded-2xl border transition-all"
             style="background: var(--glass-bg); border-color: var(--glass-border);">
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono text-[10px] font-bold flex items-center gap-1.5" style="color: var(--text-primary)">
                    <span class="text-sm">🎵</span> Lo-Fi Focus Beats
                </span>
                <div id="equalizer-bars" class="hidden flex items-end gap-0.5 h-4">
                    <span class="w-1 bg-duo-green rounded-full eq-bar-1"></span>
                    <span class="w-1 bg-duo-blue rounded-full eq-bar-2"></span>
                    <span class="w-1 bg-duo-purple rounded-full eq-bar-3"></span>
                    <span class="w-1 bg-amber-400 rounded-full eq-bar-4"></span>
                </div>
            </div>

            <!-- Track Switcher Pills -->
            <div class="grid grid-cols-2 gap-1 mb-2">
                <button type="button" onclick="setLofiTrack('cafe')" id="track-btn-cafe"
                        class="py-1 px-1.5 rounded-lg border text-[10px] font-mono font-bold transition flex items-center justify-center gap-1 bg-indigo-500/15 border-indigo-500/40 text-indigo-400">
                    <span>☕️</span> Cafe 72
                </button>
                <button type="button" onclick="setLofiTrack('midnight')" id="track-btn-midnight"
                        class="py-1 px-1.5 rounded-lg border text-[10px] font-mono font-bold transition flex items-center justify-center gap-1 text-slate-400 border-transparent hover:border-slate-500/30">
                    <span>🌌</span> Night 52
                </button>
            </div>

            <button type="button" onclick="toggleLofiMusic()" id="lofi-music-btn"
                    class="w-full py-2 px-3 rounded-xl duo-btn-glass flex items-center justify-between text-xs font-mono font-bold transition group">
                <span class="flex items-center gap-2 text-[11px] text-indigo-500 dark:text-indigo-300">
                    <span id="lofi-play-icon">▶</span>
                    <span id="lofi-status-text">Play Lo-Fi Beats</span>
                </span>
                <span id="lofi-bpm-text" class="text-[9px] text-slate-400 font-mono">72 BPM</span>
            </button>

            <!-- Frosted Glass Volume Slider -->
            <div class="mt-2.5 pt-2 border-t flex items-center justify-between gap-2 text-[10px] font-mono" style="border-color: var(--glass-border-subtle)">
                <span class="text-xs select-none">🔈</span>
                <input type="range" min="0" max="100" value="75" id="lofi-volume-slider" oninput="setLofiVolume(this.value)" class="glass-slider flex-1">
                <span id="lofi-volume-label" class="text-[9px] w-7 text-right font-bold" style="color: var(--text-muted)">75%</span>
            </div>
        </div>

        <!-- Notes Quick Stats Metric Strip -->
        <div class="mb-4 p-3 rounded-2xl border" style="background: var(--glass-bg); border-color: var(--glass-border);">
            <div class="flex items-center justify-between text-xs font-mono">
                <span class="font-bold flex items-center gap-1.5" style="color: var(--text-secondary)">
                    <span>📚</span> All Notes:
                </span>
                <span id="sidebar-notes-count" class="font-black text-indigo-400 font-mono">{{ $stats['total'] }}</span>
            </div>
            <div class="flex items-center justify-between text-xs font-mono mt-2 pt-2 border-t" style="border-color: var(--glass-border-subtle)">
                <span class="font-bold flex items-center gap-1.5" style="color: var(--text-secondary)">
                    <span>📌</span> Pinned:
                </span>
                <span id="sidebar-pinned-count" class="font-black text-amber-500 font-mono">{{ $stats['pinned'] }}</span>
            </div>
            <div class="flex items-center justify-between text-xs font-mono mt-2 pt-2 border-t" style="border-color: var(--glass-border-subtle)">
                <span class="font-bold flex items-center gap-1.5" style="color: var(--text-secondary)">
                    <span>✍️</span> Total Words:
                </span>
                <span id="sidebar-words-count" class="font-black text-emerald-500 font-mono">{{ number_format($stats['words']) }}</span>
            </div>
        </div>

        <!-- Filter Tags -->
        @if($categories->isNotEmpty())
            <div class="mb-4">
                <p class="font-mono text-[10px] uppercase tracking-widest mb-1.5 px-2 font-extrabold" style="color: var(--text-muted)">Note Tags</p>
                <div class="space-y-0.5 text-xs font-medium">
                    <a href="{{ route('notes.index') }}"
                       class="flex items-center justify-between px-3 py-1.5 rounded-xl transition-all {{ $category === 'all' ? 'font-bold shadow-xs' : 'hover:scale-[1.01]' }}"
                       style="{{ $category === 'all' ? 'background: var(--glass-card); border: 1px solid var(--glass-border); color: var(--text-primary);' : 'color: var(--text-secondary);' }}">
                        <span>#All Notes</span>
                        <span class="font-mono text-[10px]">{{ $stats['total'] }}</span>
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('notes.index', ['category' => $cat->category]) }}"
                           class="flex items-center justify-between px-3 py-1.5 rounded-xl transition-all {{ $category === $cat->category ? 'font-bold shadow-xs' : 'hover:scale-[1.01]' }}"
                           style="{{ $category === $cat->category ? 'background: var(--glass-card); border: 1px solid var(--glass-border); color: var(--text-primary);' : 'color: var(--text-secondary);' }}">
                            <span class="font-mono text-[11px]">#{{ $cat->category }}</span>
                            <span class="font-mono text-[10px]">{{ $cat->count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Mascot Mascot Footer -->
        <div class="mt-auto pt-3 border-t px-1" style="border-color: var(--glass-border-subtle)">
            <div onclick="petMascot(event)" class="cursor-pointer group flex items-center gap-3 p-3 rounded-2xl border transition-all active:scale-95 glass-panel"
                 style="border-color: var(--glass-border);">
                <div id="mascot-avatar" class="w-10 h-10 shrink-0 relative animate-mascot">
                    <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md">
                        <ellipse cx="50" cy="55" rx="35" ry="38" fill="#58cc02"/>
                        <circle cx="37" cy="46" r="13" fill="#ffffff"/>
                        <circle cx="37" cy="46" r="6" fill="#1b212f"/>
                        <circle cx="63" cy="46" r="13" fill="#ffffff"/>
                        <circle cx="63" cy="46" r="6" fill="#1b212f"/>
                        <polygon points="46,52 54,52 50,62" fill="#ff9600"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-extrabold group-hover:text-duo-green transition" style="color: var(--text-primary)">
                        Duo-Fay Scribe ✍️
                    </p>
                    <p class="font-mono text-[9px] truncate" style="color: var(--text-muted)">Brain-dump & focus</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Workspace Stage (Dual-Pane Notes Experience) -->
    <main class="flex-1 min-w-0 flex flex-col lg:flex-row h-screen overflow-hidden z-10 relative">

        <!-- Left Column: Notes List Pane -->
        <section class="w-full lg:w-80 lg:shrink-0 border-r flex flex-col h-full overflow-hidden glass-panel"
                 style="border-color: var(--glass-border-subtle); border-radius: 0;">
            
            <!-- List Header: Title, Search & New Note Button -->
            <div class="p-4 border-b space-y-3" style="border-color: var(--glass-border-subtle)">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-black tracking-tight" style="color: var(--text-primary)">Notes</h1>
                        <p class="font-mono text-[10px]" style="color: var(--text-muted)"><span id="header-notes-count">{{ $notes->count() }}</span> thoughts documented</p>
                    </div>
                    <button type="button" onclick="createNewNoteAsync()" class="duo-btn-green px-3.5 py-1.5 rounded-xl text-slate-950 font-black text-xs flex items-center gap-1 shadow-sm">
                        <span>+ Note</span>
                        <kbd class="font-mono text-[9px] opacity-75">N</kbd>
                    </button>
                </div>

                <!-- Instant Search Input -->
                <form action="{{ route('notes.index') }}" method="GET" class="relative">
                    <svg class="w-3.5 h-3.5 absolute left-3 top-2.5 pointer-events-none" style="color: var(--text-muted)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search notes (/)..." id="notes-search-input"
                           class="w-full pl-8 pr-4 py-1.5 font-mono text-xs rounded-xl border outline-none focus:ring-2 focus:ring-indigo-500/40 glass-panel"
                           style="border-color: var(--glass-border); color: var(--text-primary)">
                </form>
            </div>

            <!-- Notes List Scrollable Feed -->
            <div class="flex-1 overflow-y-auto p-3 space-y-2" id="notes-list-container">
                @if($notes->isEmpty())
                    <div class="text-center py-16 px-4">
                        <div class="text-3xl mb-2">📝</div>
                        <h4 class="text-xs font-bold" style="color: var(--text-primary)">No Notes Found</h4>
                        <p class="text-[11px] font-mono mt-1" style="color: var(--text-muted)">Create a note or clear search filter.</p>
                        <button type="button" onclick="createNewNoteAsync()" class="mt-3 duo-btn-green px-3 py-1.5 text-slate-950 font-bold text-xs rounded-xl">
                            Create First Note
                        </button>
                    </div>
                @else
                    @foreach($notes as $note)
                        <div onclick="selectNote({{ $note->id }})" id="note-row-{{ $note->id }}"
                             class="note-card p-3 rounded-2xl border cursor-pointer transition-all hover:scale-[1.01] active:scale-[0.99] {{ optional($activeNote)->id === $note->id ? 'note-card-active' : '' }}"
                             style="background: var(--glass-card); border-color: var(--glass-border);">
                            <div class="flex items-start justify-between gap-1 mb-1">
                                <h3 id="note-card-title-{{ $note->id }}" class="text-xs font-black truncate flex-1" style="color: var(--text-primary)">
                                    {{ $note->title }}
                                </h3>
                                @if($note->is_pinned)
                                    <span id="note-card-pin-{{ $note->id }}" class="text-xs shrink-0" title="Pinned Note">📌</span>
                                @else
                                    <span id="note-card-pin-{{ $note->id }}" class="text-xs shrink-0 hidden">📌</span>
                                @endif
                            </div>
                            <p id="note-card-snippet-{{ $note->id }}" class="text-[11px] line-clamp-2 font-mono leading-relaxed" style="color: var(--text-secondary)">
                                {{ $note->snippet }}
                            </p>
                            <div class="flex items-center justify-between text-[9px] font-mono mt-2 pt-1.5 border-t" style="border-color: var(--glass-border-subtle); color: var(--text-muted)">
                                <span>{{ $note->updated_ago }}</span>
                                @if($note->category)
                                    <span class="px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-400 font-bold">#{{ $note->category }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </section>

        <!-- Right Column: Note Editor Canvas -->
        <section class="flex-1 flex flex-col h-full overflow-hidden bg-transparent relative">
            
            @if($activeNote)
                <!-- Editor Top Action Bar -->
                <div class="p-4 border-b flex items-center justify-between flex-wrap gap-3 glass-panel"
                     style="border-color: var(--glass-border-subtle); border-radius: 0;">
                    
                    <!-- Auto-save Status & Stats -->
                    <div class="flex items-center gap-2.5 font-mono text-xs">
                        <span id="autosave-dot" class="w-2 h-2 rounded-full bg-duo-green animate-pulse"></span>
                        <span id="autosave-status" class="font-bold text-duo-green">Saved</span>
                        <span style="color: var(--text-muted)">•</span>
                        <span id="note-word-count-badge" style="color: var(--text-muted)">{{ $activeNote->word_count }} words</span>
                    </div>

                    <!-- Note Action Tools: Color Picker, Pin, Convert to Task, Delete -->
                    <div class="flex items-center gap-1.5">
                        
                        <!-- Color Selector Dots -->
                        <div class="flex items-center gap-1 px-2 py-1 rounded-xl border glass-panel" style="border-color: var(--glass-border)">
                            <button type="button" onclick="setNoteColor('default')" title="Classic Glass" class="w-3.5 h-3.5 rounded-full border border-slate-400 bg-slate-300 dark:bg-slate-700 hover:scale-125 transition"></button>
                            <button type="button" onclick="setNoteColor('amber')" title="Warm Amber" class="w-3.5 h-3.5 rounded-full bg-amber-400 hover:scale-125 transition"></button>
                            <button type="button" onclick="setNoteColor('emerald')" title="Mint Emerald" class="w-3.5 h-3.5 rounded-full bg-duo-green hover:scale-125 transition"></button>
                            <button type="button" onclick="setNoteColor('sky')" title="Sky Blue" class="w-3.5 h-3.5 rounded-full bg-sky-400 hover:scale-125 transition"></button>
                            <button type="button" onclick="setNoteColor('purple')" title="Lavender Purple" class="w-3.5 h-3.5 rounded-full bg-purple-400 hover:scale-125 transition"></button>
                            <button type="button" onclick="setNoteColor('rose')" title="Coral Rose" class="w-3.5 h-3.5 rounded-full bg-rose-400 hover:scale-125 transition"></button>
                        </div>

                        <!-- Pin Toggle Button -->
                        <button type="button" onclick="toggleNotePinAsync()" id="btn-pin-note"
                                class="px-2.5 py-1.5 rounded-xl border text-xs font-mono font-bold flex items-center gap-1 transition active:scale-95 glass-panel"
                                style="border-color: var(--glass-border); color: var(--text-primary)">
                            <span id="pin-icon">{{ $activeNote->is_pinned ? '📌 Pinned' : '📌 Pin' }}</span>
                        </button>

                        <!-- Convert to Task Button -->
                        <button type="button" onclick="convertNoteToTaskAsync()" title="Convert this note into a task in Fay Tasks"
                                class="px-3 py-1.5 rounded-xl border text-xs font-mono font-bold flex items-center gap-1.5 transition active:scale-95 bg-emerald-500/15 border-emerald-500/40 text-emerald-500 hover:bg-emerald-500/25">
                            <span>⚡️ Convert to Task</span>
                        </button>

                        <!-- Delete Note Button -->
                        <button type="button" onclick="deleteCurrentNoteAsync()" title="Delete Note"
                                class="p-1.5 rounded-xl border text-slate-400 hover:text-rose-500 hover:bg-rose-500/10 transition active:scale-95 glass-panel"
                                style="border-color: var(--glass-border);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                </div>

                <!-- Markdown Formatting Helper Strip -->
                <div class="px-6 py-2 border-b flex items-center gap-1 text-xs font-mono select-none" style="border-color: var(--glass-border-subtle)">
                    <button type="button" onclick="insertMarkdown('**', '**')" class="px-2 py-0.5 rounded hover:bg-white/10 font-bold" title="Bold">B</button>
                    <button type="button" onclick="insertMarkdown('*', '*')" class="px-2 py-0.5 rounded hover:bg-white/10 italic" title="Italic">I</button>
                    <button type="button" onclick="insertMarkdown('### ')" class="px-2 py-0.5 rounded hover:bg-white/10 font-bold" title="Heading">H3</button>
                    <button type="button" onclick="insertMarkdown('- ')" class="px-2 py-0.5 rounded hover:bg-white/10" title="Bullet List">• List</button>
                    <button type="button" onclick="insertMarkdown('- [ ] ')" class="px-2 py-0.5 rounded hover:bg-white/10 text-duo-green font-bold" title="Checklist">☑ Todo</button>
                    <button type="button" onclick="insertMarkdown('```\n', '\n```')" class="px-2 py-0.5 rounded hover:bg-white/10 font-mono text-[10px]" title="Code Block">&lt;/&gt;</button>
                    
                    <div class="ml-auto flex items-center gap-2">
                        <span class="text-[10px]" style="color: var(--text-muted)">Tag:</span>
                        <input type="text" id="editor-category" value="{{ $activeNote->category }}" placeholder="e.g. Ideas" oninput="scheduleAutoSave()"
                               class="font-mono text-xs px-2 py-0.5 rounded-lg border outline-none w-28 glass-panel"
                               style="border-color: var(--glass-border); color: var(--text-primary)">
                    </div>
                </div>

                <!-- Scrollable Writing Canvas -->
                <div class="flex-1 overflow-y-auto p-6 lg:p-8 flex flex-col">
                    <input type="hidden" id="current-note-id" value="{{ $activeNote->id }}">
                    <input type="hidden" id="current-note-color" value="{{ $activeNote->color }}">
                    <input type="hidden" id="current-note-pinned" value="{{ $activeNote->is_pinned ? '1' : '0' }}">

                    <!-- Note Title -->
                    <input type="text" id="editor-title" value="{{ $activeNote->title }}" placeholder="Note Title…" oninput="scheduleAutoSave()"
                           class="w-full text-2xl lg:text-3xl font-black bg-transparent outline-none tracking-tight mb-4"
                           style="color: var(--text-primary)">

                    <!-- Note Content Body -->
                    <textarea id="editor-content" rows="18" placeholder="Type your thoughts, markdown notes, meeting memos, or code snippets here…" oninput="scheduleAutoSave()"
                              class="w-full flex-1 bg-transparent outline-none resize-none text-sm lg:text-base font-sans leading-relaxed placeholder:text-slate-500"
                              style="color: var(--text-secondary)">{{ $activeNote->content }}</textarea>
                </div>
            @else
                <!-- No Active Note Placeholder -->
                <div class="flex-1 flex flex-col items-center justify-center p-8 text-center">
                    <div class="text-5xl mb-3">✍️</div>
                    <h3 class="text-base font-extrabold" style="color: var(--text-primary)">No Note Selected</h3>
                    <p class="text-xs font-mono mt-1 mb-4" style="color: var(--text-muted)">Create a note or select one from the left to start writing.</p>
                    <button type="button" onclick="createNewNoteAsync()" class="duo-btn-green px-4 py-2 rounded-xl text-slate-950 font-black text-xs">
                        + Create New Note
                    </button>
                </div>
            @endif

        </section>

    </main>

    <!-- Lo-Fi Synthesizer & Notes Auto-Save JavaScript Engine -->
    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ==========================================================================
        // ROBUST WEB AUDIO LO-FI SYNTHESIZER
        // ==========================================================================
        let audioCtx = null;
        let isAudioEnabled = localStorage.getItem('fay_audio_enabled') !== 'false';
        let isLofiPlaying = false;
        let lofiInterval = null;
        let lofiVinylNode = null;
        let lofiChordIndex = 0;
        let currentLofiTrack = localStorage.getItem('fay_lofi_track') || 'cafe';
        let lofiVolume = parseFloat(localStorage.getItem('fay_lofi_vol') || '0.75');
        let lofiMasterGainNode = null;

        function getAudioContext() {
            if (!audioCtx) {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (AudioContextClass) audioCtx = new AudioContextClass();
            }
            if (audioCtx && audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            return audioCtx;
        }

        function unlockAudioSafely() {
            const ctx = getAudioContext();
            if (ctx && ctx.state === 'suspended') ctx.resume();
        }
        ['click', 'touchstart', 'keydown'].forEach(evt => window.addEventListener(evt, unlockAudioSafely, { passive: true }));

        function getLofiMasterGain() {
            const ctx = getAudioContext();
            if (!ctx) return null;
            if (!lofiMasterGainNode) {
                lofiMasterGainNode = ctx.createGain();
                lofiMasterGainNode.gain.setValueAtTime(lofiVolume, ctx.currentTime);
                lofiMasterGainNode.connect(ctx.destination);
            }
            return lofiMasterGainNode;
        }

        function setLofiVolume(val) {
            lofiVolume = Math.max(0, Math.min(1, val / 100));
            localStorage.setItem('fay_lofi_vol', lofiVolume);
            const lbl = document.getElementById('lofi-volume-label');
            if (lbl) lbl.textContent = `${Math.round(lofiVolume * 100)}%`;
            if (lofiMasterGainNode && audioCtx) {
                lofiMasterGainNode.gain.setValueAtTime(lofiVolume, audioCtx.currentTime);
            }
        }

        const cafeChords = [
            [146.83, 174.61, 220.00, 261.63, 329.63],
            [98.00, 174.61, 246.94, 329.63, 440.00],
            [130.81, 164.81, 196.00, 246.94, 293.66],
            [110.00, 196.00, 261.63, 329.63, 493.88]
        ];
        const midnightChords = [
            [174.61, 220.00, 261.63, 329.63, 392.00],
            [164.81, 196.00, 246.94, 293.66, 392.00],
            [146.83, 174.61, 220.00, 261.63, 349.23],
            [130.81, 164.81, 196.00, 246.94, 392.00]
        ];

        function playLofiChord() {
            if (!isLofiPlaying) return;
            const ctx = getAudioContext();
            if (!ctx) return;
            const masterGain = getLofiMasterGain();
            const chords = currentLofiTrack === 'cafe' ? cafeChords : midnightChords;
            const chord = chords[lofiChordIndex];
            lofiChordIndex = (lofiChordIndex + 1) % chords.length;

            const now = ctx.currentTime;
            const filter = ctx.createBiquadFilter();
            filter.type = 'lowpass';
            filter.frequency.setValueAtTime(currentLofiTrack === 'cafe' ? 650 : 420, now);
            filter.connect(masterGain || ctx.destination);

            chord.forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = i % 2 === 0 ? 'sine' : 'triangle';
                osc.frequency.setValueAtTime(freq, now + i * 0.03);
                gain.gain.setValueAtTime(0, now + i * 0.03);
                gain.gain.linearRampToValueAtTime(0.04, now + i * 0.03 + 0.3);
                gain.gain.exponentialRampToValueAtTime(0.0005, now + 3.8);
                osc.connect(gain);
                gain.connect(filter);
                osc.start(now + i * 0.03);
                osc.stop(now + 3.9);
            });
        }

        function startVinylAtmosphere() {
            const ctx = getAudioContext();
            if (!ctx) return;
            const bufferSize = ctx.sampleRate * 2;
            const buffer = ctx.createBuffer(1, bufferSize, ctx.sampleRate);
            const data = buffer.getChannelData(0);
            for (let i = 0; i < bufferSize; i++) data[i] = (Math.random() * 2 - 1) * 0.015;

            const noise = ctx.createBufferSource();
            noise.buffer = buffer;
            noise.loop = true;
            const filter = ctx.createBiquadFilter();
            filter.type = 'bandpass';
            filter.frequency.setValueAtTime(800, ctx.currentTime);
            const gain = ctx.createGain();
            gain.gain.setValueAtTime(0.08, ctx.currentTime);
            noise.connect(filter);
            filter.connect(gain);
            gain.connect(getLofiMasterGain() || ctx.destination);
            noise.start();
            lofiVinylNode = { source: noise, gain: gain };
        }

        function stopVinylAtmosphere() {
            if (lofiVinylNode) {
                try { lofiVinylNode.source.stop(); lofiVinylNode.source.disconnect(); } catch(e){}
                lofiVinylNode = null;
            }
        }

        function toggleLofiMusic() {
            unlockAudioSafely();
            isLofiPlaying = !isLofiPlaying;
            const statusText = document.getElementById('lofi-status-text');
            const playIcon = document.getElementById('lofi-play-icon');
            const eqBars = document.getElementById('equalizer-bars');

            if (isLofiPlaying) {
                if (statusText) statusText.textContent = 'Pause Lo-Fi Beats';
                if (playIcon) playIcon.textContent = '❚❚';
                if (eqBars) eqBars.classList.remove('hidden');
                startVinylAtmosphere();
                playLofiChord();
                lofiInterval = setInterval(playLofiChord, currentLofiTrack === 'cafe' ? 3800 : 4900);
            } else {
                if (statusText) statusText.textContent = 'Play Lo-Fi Beats';
                if (playIcon) playIcon.textContent = '▶';
                if (eqBars) eqBars.classList.add('hidden');
                clearInterval(lofiInterval);
                stopVinylAtmosphere();
            }
        }

        function setLofiTrack(track) {
            unlockAudioSafely();
            currentLofiTrack = track;
            localStorage.setItem('fay_lofi_track', track);
            const btnCafe = document.getElementById('track-btn-cafe');
            const btnMid = document.getElementById('track-btn-midnight');
            const bpmText = document.getElementById('lofi-bpm-text');

            if (track === 'cafe') {
                if (btnCafe) btnCafe.className = 'py-1 px-1.5 rounded-lg border text-[10px] font-mono font-bold transition flex items-center justify-center gap-1 bg-indigo-500/15 border-indigo-500/40 text-indigo-400';
                if (btnMid) btnMid.className = 'py-1 px-1.5 rounded-lg border text-[10px] font-mono font-bold transition flex items-center justify-center gap-1 text-slate-400 border-transparent hover:border-slate-500/30';
                if (bpmText) bpmText.textContent = '72 BPM';
            } else {
                if (btnMid) btnMid.className = 'py-1 px-1.5 rounded-lg border text-[10px] font-mono font-bold transition flex items-center justify-center gap-1 bg-purple-500/15 border-purple-500/40 text-purple-400';
                if (btnCafe) btnCafe.className = 'py-1 px-1.5 rounded-lg border text-[10px] font-mono font-bold transition flex items-center justify-center gap-1 text-slate-400 border-transparent hover:border-slate-500/30';
                if (bpmText) bpmText.textContent = '52 BPM';
            }
            if (isLofiPlaying) {
                clearInterval(lofiInterval);
                playLofiChord();
                lofiInterval = setInterval(playLofiChord, track === 'cafe' ? 3800 : 4900);
            }
        }

        function playPopSound() {
            if (!isAudioEnabled) return;
            const ctx = getAudioContext();
            if (!ctx) return;
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'triangle';
            osc.frequency.setValueAtTime(350, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(700, ctx.currentTime + 0.1);
            gain.gain.setValueAtTime(0.18, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.12);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.12);
        }

        function toggleTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('fay_theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('fay_theme', 'dark');
            }
            updateThemeIcons();
            playPopSound();
        }

        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            const icon = document.getElementById('theme-icon');
            const label = document.getElementById('theme-label');
            const mobileIcon = document.getElementById('mobile-theme-icon');
            if (icon) icon.textContent = isDark ? '🌙' : '☀️';
            if (label) label.textContent = isDark ? 'Dark' : 'Light';
            if (mobileIcon) mobileIcon.textContent = isDark ? '🌙' : '☀️';
        }

        // ==========================================================================
        // NOTES DEBOUNCED AUTO-SAVE ENGINE & REAL-TIME INTERACTION
        // ==========================================================================
        let autoSaveTimer = null;

        function scheduleAutoSave() {
            const status = document.getElementById('autosave-status');
            const dot = document.getElementById('autosave-dot');
            if (status) {
                status.textContent = 'Saving…';
                status.className = 'font-bold text-amber-500';
            }
            if (dot) dot.className = 'w-2 h-2 rounded-full bg-amber-500 animate-ping';

            updateWordCountPreview();

            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(performAutoSave, 450);
        }

        function updateWordCountPreview() {
            const content = document.getElementById('editor-content');
            const badge = document.getElementById('note-word-count-badge');
            if (content && badge) {
                const words = content.value.trim() ? content.value.trim().split(/\s+/).length : 0;
                badge.textContent = `${words} words`;
            }
        }

        async function performAutoSave() {
            const noteId = document.getElementById('current-note-id')?.value;
            if (!noteId) return;

            const title = document.getElementById('editor-title')?.value.trim() || 'Untitled Note';
            const content = document.getElementById('editor-content')?.value || '';
            const category = document.getElementById('editor-category')?.value.trim() || null;
            const color = document.getElementById('current-note-color')?.value || 'default';
            const isPinned = document.getElementById('current-note-pinned')?.value === '1';

            try {
                const response = await fetch(`/notes/${noteId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        title: title,
                        content: content,
                        category: category,
                        color: color,
                        is_pinned: isPinned
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    const status = document.getElementById('autosave-status');
                    const dot = document.getElementById('autosave-dot');
                    if (status) {
                        status.textContent = 'Saved';
                        status.className = 'font-bold text-duo-green';
                    }
                    if (dot) dot.className = 'w-2 h-2 rounded-full bg-duo-green';

                    // Update note card in list
                    const cardTitle = document.getElementById(`note-card-title-${noteId}`);
                    const cardSnippet = document.getElementById(`note-card-snippet-${noteId}`);
                    if (cardTitle) cardTitle.textContent = title;
                    if (cardSnippet && data.note) cardSnippet.textContent = data.note.snippet;
                }
            } catch(e) {
                console.error('Auto-save error:', e);
            }
        }

        async function createNewNoteAsync() {
            unlockAudioSafely();
            playPopSound();
            try {
                const res = await fetch("{{ route('notes.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ title: 'Untitled Note', content: '' })
                });
                const data = await res.json();
                if (data.success && data.note) {
                    window.location.href = `/notes?note=${data.note.id}`;
                }
            } catch(e) {
                console.error(e);
            }
        }

        function selectNote(id) {
            unlockAudioSafely();
            playPopSound();
            window.location.href = `/notes?note=${id}`;
        }

        async function toggleNotePinAsync() {
            unlockAudioSafely();
            const noteId = document.getElementById('current-note-id')?.value;
            if (!noteId) return;

            playPopSound();
            try {
                const res = await fetch(`/notes/${noteId}/pin`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    const pinBtn = document.getElementById('pin-icon');
                    const pinInput = document.getElementById('current-note-pinned');
                    const cardPin = document.getElementById(`note-card-pin-${noteId}`);
                    if (pinBtn) pinBtn.textContent = data.is_pinned ? '📌 Pinned' : '📌 Pin';
                    if (pinInput) pinInput.value = data.is_pinned ? '1' : '0';
                    if (cardPin) {
                        if (data.is_pinned) cardPin.classList.remove('hidden');
                        else cardPin.classList.add('hidden');
                    }
                }
            } catch(e) {
                console.error(e);
            }
        }

        function setNoteColor(color) {
            const colorInput = document.getElementById('current-note-color');
            if (colorInput) {
                colorInput.value = color;
                scheduleAutoSave();
            }
        }

        async function convertNoteToTaskAsync() {
            unlockAudioSafely();
            const noteId = document.getElementById('current-note-id')?.value;
            if (!noteId) return;

            if (typeof confetti === 'function') {
                confetti({ particleCount: 75, spread: 80, origin: { y: 0.6 } });
            }

            try {
                const res = await fetch(`/notes/${noteId}/convert-to-todo`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    alert(`⚡️ Converted into task: "${data.todo.title}"!\nYou can find it in your Fay Tasks workspace.`);
                }
            } catch(e) {
                console.error(e);
            }
        }

        async function deleteCurrentNoteAsync() {
            unlockAudioSafely();
            const noteId = document.getElementById('current-note-id')?.value;
            if (!noteId) return;

            if (!confirm('Are you sure you want to delete this note?')) return;

            try {
                const res = await fetch(`/notes/${noteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    window.location.href = "{{ route('notes.index') }}";
                }
            } catch(e) {
                console.error(e);
            }
        }

        function insertMarkdown(prefix, suffix = '') {
            const textarea = document.getElementById('editor-content');
            if (!textarea) return;

            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selected = textarea.value.substring(start, end);

            const replacement = prefix + selected + suffix;
            textarea.setRangeText(replacement, start, end, 'select');
            textarea.focus();
            scheduleAutoSave();
        }

        function petMascot() {
            unlockAudioSafely();
            playPopSound();
            const avatar = document.getElementById('mascot-avatar');
            if (avatar) {
                avatar.classList.remove('animate-mascot');
                void avatar.offsetWidth;
                avatar.classList.add('animate-mascot');
            }
        }

        document.addEventListener('keydown', (e) => {
            if ((e.metaKey || e.ctrlKey) && (e.key === 's' || e.key === 'S')) {
                e.preventDefault();
                performAutoSave();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            updateThemeIcons();
            const volSlider = document.getElementById('lofi-volume-slider');
            if (volSlider) volSlider.value = Math.round(lofiVolume * 100);
            setLofiTrack(currentLofiTrack);
        });
    </script>
</body>
</html>
