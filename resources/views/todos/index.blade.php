<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fay Tasks — Gamified Duolingo-Grade Task Dashboard</title>
    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Canvas Confetti CDN -->
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
        /* CSS Variables for Seamless Light & Dark Modes */
        :root {
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --bg-card-hover: #f1f5f9;
            --bg-sidebar: #ffffff;
            --border-subtle: #e2e8f0;
            --border-card: #e5e7eb;
            --border-card-hover: #cbd5e1;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --card-shadow: 0 4px 14px -2px rgba(0, 0, 0, 0.05), 0 2px 6px -1px rgba(0, 0, 0, 0.03);
            --btn-card-bg: #f8fafc;
            --btn-card-border: #e2e8f0;
            --btn-card-shadow: #cbd5e1;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --metric-bg: #f1f5f9;
            --metric-border: #e2e8f0;
            --tag-bg: #f1f5f9;
            --tag-border: #e2e8f0;
            --tag-text: #475569;
            --pill-active-bg: #ffffff;
            --pill-active-border: #cbd5e1;
            --pill-active-text: #0f172a;
            --pill-active-shadow: 0 2px 6px rgba(0,0,0,0.06);
            --calendar-inactive-bg: #f1f5f9;
            --calendar-inactive-border: #e2e8f0;
            --calendar-inactive-text: #94a3b8;
            --accent-glow: rgba(88, 204, 2, 0.2);
            --shimmer-track: #e2e8f0;
            --focus-banner-bg: #f0fdf4;
            --focus-banner-border: #bbf7d0;
        }

        html.dark {
            --bg-page: #08090d;
            --bg-card: #0e1118;
            --bg-card-hover: #141822;
            --bg-sidebar: #0b0d13;
            --border-subtle: #181d29;
            --border-card: #1a1f2c;
            --border-card-hover: #2b354d;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --card-shadow: 0 10px 28px -4px rgba(0, 0, 0, 0.55), 0 0 0 1px rgba(99, 102, 241, 0.18);
            --btn-card-bg: #121622;
            --btn-card-border: #20273a;
            --btn-card-shadow: #1d2436;
            --input-bg: #10131a;
            --input-border: #1e2433;
            --metric-bg: #0e1118;
            --metric-border: #1a1f2c;
            --tag-bg: #141822;
            --tag-border: #1e2433;
            --tag-text: #94a3b8;
            --pill-active-bg: #181e2b;
            --pill-active-border: #273045;
            --pill-active-text: #ffffff;
            --pill-active-shadow: 0 2px 8px rgba(0,0,0,0.3);
            --calendar-inactive-bg: #181e2b;
            --calendar-inactive-border: #2b354a;
            --calendar-inactive-text: #64748b;
            --accent-glow: rgba(99, 102, 241, 0.18);
            --shimmer-track: #1b202e;
            --focus-banner-bg: #0f1c15;
            --focus-banner-border: #1a3d28;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-primary);
            letter-spacing: -0.011em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transition: background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1), color 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* 3D Duolingo Tactile Push Buttons */
        .duo-btn-green {
            background-color: #58cc02;
            box-shadow: 0 4px 0 0 #46a302;
            transition: all 0.12s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .duo-btn-green:hover {
            background-color: #61e002;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 0 #46a302;
        }
        .duo-btn-green:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 0 #46a302;
        }

        .duo-btn-primary {
            background-color: #6366f1;
            box-shadow: 0 4px 0 0 #4338ca;
            transition: all 0.12s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .duo-btn-primary:hover {
            background-color: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 0 #4338ca;
        }
        .duo-btn-primary:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 0 #4338ca;
        }

        .duo-btn-card {
            background-color: var(--btn-card-bg);
            border: 1px solid var(--btn-card-border);
            box-shadow: 0 3px 0 0 var(--btn-card-shadow);
            transition: all 0.12s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .duo-btn-card:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 5px 0 0 var(--btn-card-shadow);
        }
        .duo-btn-card:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 0 var(--btn-card-shadow);
        }

        /* Animated Flame with Sparkles */
        @keyframes flame-pulse {
            0%, 100% { transform: scale(1) rotate(-4deg); filter: drop-shadow(0 0 6px rgba(245, 158, 11, 0.6)); }
            50% { transform: scale(1.22) rotate(4deg); filter: drop-shadow(0 0 14px rgba(239, 68, 68, 0.85)); }
        }
        .animate-flame {
            display: inline-block;
            animation: flame-pulse 1.1s infinite ease-in-out;
            transform-origin: bottom center;
        }

        /* Floating XP Pop Animation */
        @keyframes xp-float {
            0% { opacity: 0; transform: translateY(10px) scale(0.6); }
            25% { opacity: 1; transform: translateY(-16px) scale(1.25); }
            70% { opacity: 1; transform: translateY(-32px) scale(1.05); }
            100% { opacity: 0; transform: translateY(-56px) scale(0.85); }
        }
        .animate-xp-float {
            position: fixed;
            z-index: 999;
            pointer-events: none;
            animation: xp-float 1.2s forwards cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Combo Popup Animation */
        @keyframes combo-burst {
            0% { transform: scale(0.4) rotate(-10deg); opacity: 0; }
            40% { transform: scale(1.25) rotate(4deg); opacity: 1; }
            70% { transform: scale(1) rotate(0deg); opacity: 1; }
            100% { transform: scale(1.05) translateY(-20px); opacity: 0; }
        }
        .animate-combo-burst {
            animation: combo-burst 1.6s forwards cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Mascot Mascot Float, Bob & Wings */
        @keyframes mascot-bob {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(2deg); }
        }
        .animate-mascot {
            animation: mascot-bob 3.2s infinite ease-in-out;
            transform-origin: bottom center;
        }

        @keyframes wing-flutter-left {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(-15deg); }
        }
        @keyframes wing-flutter-right {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(15deg); }
        }
        .wing-left {
            animation: wing-flutter-left 2.5s infinite ease-in-out;
            transform-origin: top right;
        }
        .wing-right {
            animation: wing-flutter-right 2.5s infinite ease-in-out;
            transform-origin: top left;
        }

        /* Mascot Jump / Excited Flip */
        @keyframes mascot-cheer {
            0% { transform: scale(1) translateY(0); }
            30% { transform: scale(1.3) translateY(-24px) rotate(-8deg); }
            60% { transform: scale(1.2) translateY(-12px) rotate(8deg); }
            100% { transform: scale(1) translateY(0); }
        }
        .animate-mascot-cheer {
            animation: mascot-cheer 0.75s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Eye Blinking */
        @keyframes eye-blink {
            0%, 92%, 100% { transform: scaleY(1); }
            95% { transform: scaleY(0.1); }
        }
        .mascot-eye-lid {
            animation: eye-blink 4s infinite;
            transform-origin: center;
        }

        /* Speech Bubble Pop */
        @keyframes bubble-pop {
            0% { transform: scale(0.6) translateY(10px); opacity: 0; }
            70% { transform: scale(1.08) translateY(-2px); opacity: 1; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .animate-bubble-pop {
            animation: bubble-pop 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        /* Floating Hearts / Stars on Mascot Pet */
        @keyframes float-heart {
            0% { opacity: 1; transform: translateY(0) scale(0.6); }
            100% { opacity: 0; transform: translateY(-40px) scale(1.3); }
        }
        .animate-float-heart {
            position: absolute;
            pointer-events: none;
            animation: float-heart 0.9s forwards ease-out;
        }

        /* Shimmer Liquid Progress Bar */
        @keyframes shimmer-sweep {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(250%); }
        }
        .shimmer-bar::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            animation: shimmer-sweep 2s infinite ease-in-out;
        }

        /* Checkbox Bounce Pop */
        .checkbox-bounce {
            transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1), background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .checkbox-bounce:hover {
            transform: scale(1.22) rotate(6deg);
            box-shadow: 0 0 12px rgba(88, 204, 2, 0.4);
        }
        .checkbox-bounce:active {
            transform: scale(0.85);
        }

        /* Spring Drop In Animation for newly added tasks */
        @keyframes springDropIn {
            0% { opacity: 0; transform: translateY(-24px) scale(0.92); }
            60% { opacity: 1; transform: translateY(6px) scale(1.02); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .animate-spring-in {
            animation: springDropIn 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        /* Slide Out Collapse for Deletion or Filter Out */
        .animate-slide-out {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
            transform: translateX(100px) scale(0.9) !important;
            opacity: 0 !important;
            max-height: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            overflow: hidden !important;
            border-width: 0 !important;
        }

        /* Task Card Hover Spring & Shadow */
        .task-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-card);
            box-shadow: var(--card-shadow);
            transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
        }
        .task-card:hover {
            transform: translateY(-3px) scale(1.004);
            border-color: var(--border-card-hover);
            box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.12), 0 0 0 1px var(--accent-glow);
        }
        html.dark .task-card:hover {
            box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.6), 0 0 0 1px var(--accent-glow);
        }

        /* Staggered Entrance for Tasks */
        @keyframes fadeInUpStagger {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .task-stagger {
            animation: fadeInUpStagger 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        /* Strikethrough Smooth Draw Transition */
        .task-done {
            text-decoration: line-through;
            text-decoration-color: #58cc02;
            text-decoration-thickness: 2px;
            color: var(--text-muted) !important;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Wiggle for Mystery Chest */
        @keyframes chest-wiggle {
            0%, 100% { transform: rotate(0deg) scale(1); }
            15% { transform: rotate(-10deg) scale(1.12); }
            30% { transform: rotate(10deg) scale(1.12); }
            45% { transform: rotate(-7deg) scale(1.06); }
            60% { transform: rotate(7deg) scale(1.06); }
            75% { transform: rotate(0deg) scale(1); }
        }
        .animate-chest {
            animation: chest-wiggle 2.6s infinite ease-in-out;
            transform-origin: bottom center;
        }

        /* Ambient floating fireflies */
        @keyframes float-particle {
            0% { transform: translateY(0) translateX(0); opacity: 0; }
            50% { opacity: 0.75; }
            100% { transform: translateY(-130px) translateX(30px); opacity: 0; }
        }
        .particle {
            position: absolute;
            pointer-events: none;
            border-radius: 9999px;
            animation: float-particle 6s infinite ease-in-out;
        }

        /* Streak Day Node Glow */
        .streak-active-node {
            background: linear-gradient(135deg, #ff9600, #ff4b4b);
            box-shadow: 0 0 12px rgba(255, 150, 0, 0.5);
        }

        /* Theme Toggle Icon Spin */
        .theme-icon-spin {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .theme-icon-spin:active {
            transform: rotate(360deg) scale(0.8);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--border-subtle);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }
    </style>
</head>
<body class="min-h-full flex flex-col md:flex-row antialiased selection:bg-indigo-500/30 selection:text-indigo-400 relative overflow-x-hidden">

    <!-- Ambient Subtle Particles in Background -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0 opacity-40">
        <div class="particle bg-indigo-500/40 w-1.5 h-1.5" style="top: 80%; left: 15%; animation-delay: 0s;"></div>
        <div class="particle bg-amber-400/40 w-2 h-2" style="top: 70%; left: 45%; animation-delay: 2s;"></div>
        <div class="particle bg-emerald-400/40 w-1 h-1" style="top: 85%; left: 75%; animation-delay: 4s;"></div>
        <div class="particle bg-purple-400/40 w-2 h-2" style="top: 90%; left: 88%; animation-delay: 1.5s;"></div>
        <div class="particle bg-pink-400/40 w-1.5 h-1.5" style="top: 60%; left: 30%; animation-delay: 3s;"></div>
    </div>

    <!-- Mobile Top Header Bar -->
    <header class="md:hidden flex items-center justify-between border-b px-4 py-3 sticky top-0 z-30 transition-colors duration-300"
            style="background-color: var(--bg-card); border-color: var(--border-subtle);">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-duo-green to-emerald-400 border border-emerald-300/30 flex items-center justify-center text-slate-950 font-mono text-sm font-extrabold shadow-xs">
                F
            </div>
            <div>
                <span class="font-bold text-sm tracking-tight block leading-none" style="color: var(--text-primary)">Fay Tasks</span>
                <span class="font-mono text-[9px] text-amber-500 font-semibold leading-none">⚡️ Lvl <span id="mobile-lvl-val">3</span></span>
            </div>
        </div>
        
        <!-- Mobile Streak, Chest, Focus, Theme & Sound -->
        <div class="flex items-center gap-1.5">
            <button type="button" onclick="toggleFocusMode()" title="Focus Mode" class="p-1.5 text-emerald-500 hover:scale-110 transition">
                ⏱️
            </button>
            <button type="button" onclick="toggleTheme()" title="Toggle Theme" class="p-1.5 text-slate-400 hover:text-amber-500 theme-icon-spin">
                <span id="mobile-theme-icon" class="text-base">☀️</span>
            </button>
            <button type="button" onclick="openMysteryChest()" title="Claim Daily Reward" class="text-base animate-chest p-1">
                🎁
            </button>
            <div class="flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-mono font-bold text-amber-500 border"
                 style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
                <span class="animate-flame">🔥</span>
                <span id="mobile-streak-val">3</span>
            </div>
            <button type="button" onclick="toggleAudio()" id="mobile-audio-btn" title="Toggle Sound" class="p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                🔊
            </button>
            <button type="button" onclick="document.getElementById('sidebar').classList.toggle('hidden')" class="p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="hidden md:flex flex-col w-64 lg:w-72 border-r shrink-0 h-screen sticky top-0 p-4 select-none overflow-y-auto z-20 transition-colors duration-300"
           style="background-color: var(--bg-sidebar); border-color: var(--border-subtle);">
        
        <!-- Workspace Identification & Command / Theme Bar -->
        <div class="flex items-center justify-between px-2.5 py-2 mb-3.5 rounded-2xl border"
             style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-indigo-500 via-indigo-600 to-purple-600 flex items-center justify-center text-white shadow-xs font-mono font-bold text-xs shrink-0">
                    F
                </div>
                <div class="min-w-0">
                    <h2 class="font-bold text-xs truncate leading-none" style="color: var(--text-primary)">Fay Tasks</h2>
                    <p class="font-mono text-[10px] mt-1 leading-none truncate" style="color: var(--text-muted)">High-Velocity Flow</p>
                </div>
            </div>

            <!-- Theme Toggle Pill Button -->
            <button type="button" onclick="toggleTheme()" id="theme-toggle-btn" title="Toggle Light / Dark Mode (T)"
                    class="flex items-center gap-1 font-mono text-[10px] px-2 py-1 rounded-lg border font-semibold transition active:scale-90 theme-icon-spin"
                    style="background-color: var(--bg-card); border-color: var(--border-card); color: var(--text-secondary);">
                <span id="theme-icon">☀️</span>
                <span id="theme-label">Light</span>
            </button>
        </div>

        <!-- Quick Access: Pomodoro & Command Palette Buttons -->
        <div class="grid grid-cols-2 gap-1.5 mb-3.5">
            <button type="button" onclick="toggleFocusMode()"
                    class="py-1.5 px-2 rounded-xl border flex items-center justify-center gap-1.5 text-xs font-mono font-bold transition hover:scale-[1.02] active:scale-95"
                    style="background-color: var(--focus-banner-bg); border-color: var(--focus-banner-border); color: #15803d;">
                <span>⏱️</span>
                <span id="sidebar-focus-label">Focus Mode</span>
            </button>
            <button type="button" onclick="openCommandPalette()"
                    class="py-1.5 px-2 rounded-xl border flex items-center justify-center gap-1.5 text-xs font-mono font-medium transition hover:scale-[1.02] active:scale-95"
                    style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-secondary);">
                <span>⌘K</span>
                <span>Actions</span>
            </button>
        </div>

        <!-- Duolingo Streak, XP & Level Card -->
        <div class="mb-3.5 p-3.5 rounded-2xl border shadow-xs"
             style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
            
            <!-- Streak Header -->
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <span class="text-2xl animate-flame">🔥</span>
                    <div>
                        <span class="font-mono text-xs font-extrabold text-amber-500 leading-none block">
                            <span id="streak-counter">3</span> Day Streak!
                        </span>
                        <span class="text-[9px] font-mono" style="color: var(--text-muted)">Unstoppable pace</span>
                    </div>
                </div>

                <!-- Sound Toggle Button -->
                <button type="button" onclick="toggleAudio()" id="audio-toggle-btn" title="Toggle audio chime (M)"
                        class="text-[10px] px-2 py-0.5 rounded-md border font-mono transition active:scale-95"
                        style="background-color: var(--bg-card); border-color: var(--border-card); color: var(--text-secondary);">
                    🔊 Sound
                </button>
            </div>

            <!-- Duolingo 7-Day Weekly Streak Row -->
            <div class="mt-2.5 mb-3 rounded-xl p-2 border"
                 style="background-color: var(--bg-card); border-color: var(--border-card);">
                <div class="flex items-center justify-between text-[10px] font-mono mb-1.5 px-0.5">
                    <span class="text-[9px] uppercase tracking-wider font-bold" style="color: var(--text-muted)">Streak Calendar</span>
                    <span class="text-[9px] text-sky-500 font-bold flex items-center gap-1 cursor-pointer hover:underline" onclick="triggerFreezeShield()" title="1 Streak Freeze Active">
                        <span>🧊</span> 1 Shield
                    </span>
                </div>
                <div class="grid grid-cols-7 gap-1 text-center font-mono text-[10px]">
                    <!-- M -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] mb-0.5" style="color: var(--text-muted)">M</span>
                        <div class="w-6 h-6 rounded-full streak-active-node flex items-center justify-center text-slate-950 font-bold text-[10px] transition-transform hover:scale-110">✓</div>
                    </div>
                    <!-- T -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] mb-0.5" style="color: var(--text-muted)">T</span>
                        <div class="w-6 h-6 rounded-full streak-active-node flex items-center justify-center text-slate-950 font-bold text-[10px] transition-transform hover:scale-110">✓</div>
                    </div>
                    <!-- W (Today) -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] text-amber-500 font-bold mb-0.5">W</span>
                        <div class="w-6 h-6 rounded-full streak-active-node ring-2 ring-amber-300 flex items-center justify-center text-slate-950 font-bold text-[10px] animate-pulse">🔥</div>
                    </div>
                    <!-- T -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] mb-0.5" style="color: var(--text-muted)">T</span>
                        <div class="w-6 h-6 rounded-full border flex items-center justify-center text-[9px]"
                             style="background-color: var(--calendar-inactive-bg); border-color: var(--calendar-inactive-border); color: var(--calendar-inactive-text);">•</div>
                    </div>
                    <!-- F -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] mb-0.5" style="color: var(--text-muted)">F</span>
                        <div class="w-6 h-6 rounded-full border flex items-center justify-center text-[9px]"
                             style="background-color: var(--calendar-inactive-bg); border-color: var(--calendar-inactive-border); color: var(--calendar-inactive-text);">•</div>
                    </div>
                    <!-- S -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] mb-0.5" style="color: var(--text-muted)">S</span>
                        <div class="w-6 h-6 rounded-full border flex items-center justify-center text-[9px]"
                             style="background-color: var(--calendar-inactive-bg); border-color: var(--calendar-inactive-border); color: var(--calendar-inactive-text);">•</div>
                    </div>
                    <!-- S -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] mb-0.5" style="color: var(--text-muted)">S</span>
                        <div class="w-6 h-6 rounded-full border flex items-center justify-center text-[9px]"
                             style="background-color: var(--calendar-inactive-bg); border-color: var(--calendar-inactive-border); color: var(--calendar-inactive-text);">•</div>
                    </div>
                </div>
            </div>

            <!-- XP Progress Bar -->
            <div>
                <div class="flex justify-between items-center text-[10px] font-mono mb-1">
                    <span class="flex items-center gap-1 text-amber-500 font-bold">
                        <span>⚡️</span> <span id="current-xp-val">45</span> XP
                    </span>
                    <span style="color: var(--text-muted)">Target: <span id="goal-xp-val">60</span> XP</span>
                </div>
                <div class="relative w-full h-2.5 rounded-full overflow-hidden shimmer-bar border"
                     style="background-color: var(--shimmer-track); border-color: var(--border-subtle);">
                    <div id="xp-progress-bar"
                         class="h-full bg-gradient-to-r from-amber-400 via-orange-500 to-duo-green rounded-full transition-all duration-700 ease-out"
                         style="width: 75%"></div>
                </div>
                <div class="flex justify-between items-center text-[9px] font-mono mt-1.5">
                    <span id="user-rank-title" class="font-bold" style="color: var(--text-secondary)">Lvl 3: Focus Archer</span>
                    <span id="daily-status-text" class="text-amber-500 font-medium">15 XP to Goal</span>
                </div>
            </div>

            <!-- Mystery Daily Reward Chest Button -->
            <button type="button" onclick="openMysteryChest()"
                    class="mt-3 w-full py-1.5 px-2.5 rounded-xl duo-btn-card flex items-center justify-between text-xs transition group">
                <span class="flex items-center gap-1.5 text-[11px] font-mono text-amber-500 font-bold">
                    <span class="text-sm animate-chest">🎁</span>
                    <span>Daily Mystery Chest</span>
                </span>
                <span class="text-[10px] font-mono font-semibold transition" style="color: var(--text-muted)">Claim →</span>
            </button>
        </div>

        <!-- Duolingo Daily Quests Widget -->
        <div class="mb-3.5 p-3 rounded-2xl border"
             style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono text-[10px] uppercase tracking-wider font-bold flex items-center gap-1" style="color: var(--text-secondary)">
                    <span>🎯</span> Daily Quests
                </span>
                <span class="font-mono text-[9px] text-duo-green font-bold" id="quests-completed-count">1/3 Done</span>
            </div>

            <!-- Quest List -->
            <div class="space-y-1.5 text-xs font-mono">
                <!-- Quest 1 -->
                <div class="p-1.5 rounded-xl border flex items-center justify-between"
                     style="background-color: var(--bg-card); border-color: var(--border-card);">
                    <div class="min-w-0 pr-1">
                        <p class="text-[10px] font-semibold truncate" style="color: var(--text-primary)">Finish 1 high-pri task</p>
                        <p class="text-[9px] text-amber-500 font-bold">+25 XP</p>
                    </div>
                    <button type="button" onclick="claimQuest(1, 25, this)" id="quest-btn-1"
                            class="px-2.5 py-1 text-[9px] font-bold rounded-lg duo-btn-green text-slate-950 shadow-xs">
                        Claim
                    </button>
                </div>

                <!-- Quest 2 -->
                <div class="p-1.5 rounded-xl border flex items-center justify-between"
                     style="background-color: var(--bg-card); border-color: var(--border-card);">
                    <div class="min-w-0 pr-1">
                        <p class="text-[10px] font-semibold truncate" style="color: var(--text-primary)">Hit a 2x Combo streak</p>
                        <p class="text-[9px] text-amber-500 font-bold">+20 XP</p>
                    </div>
                    <span class="text-[9px] font-mono px-1.5 py-0.5" style="color: var(--text-muted)">Active</span>
                </div>
            </div>
        </div>

        <!-- Primary Views -->
        <div class="mb-4">
            <p class="font-mono text-[10px] uppercase tracking-widest mb-1.5 px-2.5 font-bold" style="color: var(--text-muted)">Views</p>
            <nav class="space-y-1 text-xs font-medium">
                
                <!-- All Tasks -->
                <a href="{{ route('todos.index', ['filter' => 'all', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'font-bold shadow-xs' : 'hover:scale-[1.01]' }}"
                   style="{{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'background-color: var(--pill-active-bg); border: 1px solid var(--pill-active-border); color: var(--pill-active-text); box-shadow: var(--pill-active-shadow);' : 'color: var(--text-secondary);' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                        <span>All Tasks</span>
                    </div>
                    <span id="stat-total" class="font-mono text-[10px] px-1.5 py-0.2 rounded-md font-bold"
                          style="background-color: var(--metric-bg); color: var(--text-secondary);">
                        {{ $totalCount }}
                    </span>
                </a>

                <!-- Due Today -->
                <a href="{{ route('todos.index', ['filter' => 'today', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'today' ? 'font-bold shadow-xs' : 'hover:scale-[1.01]' }}"
                   style="{{ $filter === 'today' ? 'background-color: var(--pill-active-bg); border: 1px solid var(--pill-active-border); color: var(--pill-active-text); box-shadow: var(--pill-active-shadow);' : 'color: var(--text-secondary);' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        <span>Due Today</span>
                    </div>
                    <span id="stat-today" class="font-mono text-[10px] px-1.5 py-0.2 rounded-md font-bold bg-amber-500/20 text-amber-600 dark:text-amber-300">
                        {{ $todayCount }}
                    </span>
                </a>

                <!-- Active -->
                <a href="{{ route('todos.index', ['filter' => 'active', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'active' ? 'font-bold shadow-xs' : 'hover:scale-[1.01]' }}"
                   style="{{ $filter === 'active' ? 'background-color: var(--pill-active-bg); border: 1px solid var(--pill-active-border); color: var(--pill-active-text); box-shadow: var(--pill-active-shadow);' : 'color: var(--text-secondary);' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>In Progress</span>
                    </div>
                    <span id="stat-remaining" class="font-mono text-[10px] px-1.5 py-0.2 rounded-md font-bold bg-sky-500/20 text-sky-600 dark:text-sky-300">
                        {{ $remainingCount }}
                    </span>
                </a>

                <!-- Important -->
                <a href="{{ route('todos.index', ['filter' => 'important', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'important' ? 'font-bold shadow-xs' : 'hover:scale-[1.01]' }}"
                   style="{{ $filter === 'important' ? 'background-color: var(--pill-active-bg); border: 1px solid var(--pill-active-border); color: var(--pill-active-text); box-shadow: var(--pill-active-shadow);' : 'color: var(--text-secondary);' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <span>High Priority</span>
                    </div>
                    <span id="stat-important" class="font-mono text-[10px] px-1.5 py-0.2 rounded-md font-bold bg-rose-500/20 text-rose-600 dark:text-rose-300">
                        {{ $importantCount }}
                    </span>
                </a>

                <!-- Completed -->
                <a href="{{ route('todos.index', ['filter' => 'done', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'done' ? 'font-bold shadow-xs' : 'hover:scale-[1.01]' }}"
                   style="{{ $filter === 'done' ? 'background-color: var(--pill-active-bg); border: 1px solid var(--pill-active-border); color: var(--pill-active-text); box-shadow: var(--pill-active-shadow);' : 'color: var(--text-secondary);' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-duo-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Completed</span>
                    </div>
                    <span id="stat-completed" class="font-mono text-[10px] px-1.5 py-0.2 rounded-md font-bold bg-emerald-500/20 text-emerald-600 dark:text-emerald-300">
                        {{ $completedCount }}
                    </span>
                </a>
            </nav>
        </div>

        <!-- Tags / Categories -->
        @if($categories->isNotEmpty())
            <div class="mb-4 pt-3 border-t" style="border-color: var(--border-subtle)">
                <p class="font-mono text-[10px] uppercase tracking-widest mb-1.5 px-2.5 font-bold" style="color: var(--text-muted)">Tags</p>
                <div class="space-y-0.5 text-xs font-medium">
                    @foreach($categories as $cat)
                        <a href="{{ route('todos.index', ['category' => $cat->category, 'sort' => $sort]) }}"
                           class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $category === $cat->category ? 'font-bold shadow-xs' : 'hover:scale-[1.01]' }}"
                           style="{{ $category === $cat->category ? 'background-color: var(--pill-active-bg); border: 1px solid var(--pill-active-border); color: var(--pill-active-text); box-shadow: var(--pill-active-shadow);' : 'color: var(--text-secondary);' }}">
                            <span class="font-mono text-[11px]">#{{ $cat->category }}</span>
                            <span class="font-mono text-[10px]" style="color: var(--text-muted)">{{ $cat->count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Interactive Animated Mascot with Eye Tracking (Duo-Fay the Owl) -->
        <div class="mt-auto pt-3 border-t px-1 relative" style="border-color: var(--border-subtle)">
            
            <!-- Speech Bubble that dynamically pops up -->
            <div id="mascot-speech-bubble" class="hidden mb-2 text-[11px] font-medium p-2.5 rounded-2xl shadow-xl relative animate-bubble-pop border"
                 style="background-color: var(--bg-card); border-color: #58cc02; color: var(--text-primary)">
                <span id="mascot-quote-text">Let's keep the streak blazing! 🔥</span>
                <div class="absolute -bottom-1.5 left-6 w-3 h-3 border-r border-b transform rotate-45"
                     style="background-color: var(--bg-card); border-color: #58cc02;"></div>
            </div>

            <!-- Clickable Vector Owl Character -->
            <div onclick="petMascot(event)" id="mascot-card"
                 class="cursor-pointer group flex items-center gap-3 p-2.5 rounded-2xl border transition-all select-none shadow-xs active:scale-95 relative"
                 style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
                
                <!-- SVG Owl Mascot with animated eyes and wings -->
                <div id="mascot-avatar" class="w-11 h-11 shrink-0 relative animate-mascot">
                    <svg viewBox="0 0 100 100" id="mascot-svg" class="w-full h-full drop-shadow-md">
                        <!-- Left Wing -->
                        <path class="wing-left" d="M 22 45 C 10 50, 8 70, 24 75 C 26 70, 24 55, 22 45 Z" fill="#46a302"/>
                        <!-- Right Wing -->
                        <path class="wing-right" d="M 78 45 C 90 50, 92 70, 76 75 C 74 70, 76 55, 78 45 Z" fill="#46a302"/>
                        <!-- Owl Body -->
                        <ellipse cx="50" cy="55" rx="35" ry="38" fill="#58cc02"/>
                        <!-- Feather tufts / ears -->
                        <polygon points="25,28 35,42 18,38" fill="#46a302"/>
                        <polygon points="75,28 65,42 82,38" fill="#46a302"/>
                        <!-- Belly -->
                        <ellipse cx="50" cy="64" rx="23" ry="24" fill="#89e219"/>
                        <!-- Belly feathers marks -->
                        <path d="M 42 62 Q 50 67 58 62 M 44 70 Q 50 75 56 70" stroke="#46a302" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                        <!-- Big Eye Left -->
                        <circle cx="37" cy="46" r="13" fill="#ffffff"/>
                        <g class="mascot-eye-lid">
                            <circle id="pupil-left" cx="37" cy="46" r="6.5" fill="#1b212f"/>
                            <circle id="gleam-left" cx="35" cy="44" r="2.5" fill="#ffffff"/>
                        </g>
                        <!-- Big Eye Right -->
                        <circle cx="63" cy="46" r="13" fill="#ffffff"/>
                        <g class="mascot-eye-lid">
                            <circle id="pupil-right" cx="63" cy="46" r="6.5" fill="#1b212f"/>
                            <circle id="gleam-right" cx="61" cy="44" r="2.5" fill="#ffffff"/>
                        </g>
                        <!-- Beak -->
                        <polygon points="46,52 54,52 50,62" fill="#ff9600"/>
                        <!-- Feet -->
                        <ellipse cx="40" cy="91" rx="6" ry="3" fill="#ff9600"/>
                        <ellipse cx="60" cy="91" rx="6" ry="3" fill="#ff9600"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold group-hover:text-duo-green transition flex items-center gap-1" style="color: var(--text-primary)">
                        <span>Duo-Fay</span>
                        <span class="text-[10px] text-amber-500">⚡️</span>
                    </p>
                    <p class="font-mono text-[9px] mt-0.5 truncate" style="color: var(--text-muted)">I'm watching your focus!</p>
                </div>
            </div>
        </div>

    </aside>

    <!-- Main Workspace Stage -->
    <main class="flex-1 min-w-0 p-5 sm:p-8 lg:p-10 max-w-5xl mx-auto w-full flex flex-col justify-between z-10 relative">

        <div>
            <!-- Interactive Pomodoro Focus Bar (Collapsible / Dynamic) -->
            <div id="focus-bar" class="hidden mb-6 p-4 rounded-2xl border transition-all animate-spring-in"
                 style="background-color: var(--focus-banner-bg); border-color: var(--focus-banner-border);">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <!-- Circular Progress SVG -->
                        <div class="relative w-12 h-12 flex items-center justify-center shrink-0">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-slate-300 dark:text-slate-800" stroke-width="3" stroke="currentColor" fill="none"
                                      d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                <path id="focus-circle-progress" class="text-emerald-500 transition-all duration-1000 ease-linear" stroke-width="3.5"
                                      stroke-dasharray="100, 100" stroke-dashoffset="0" stroke-linecap="round" stroke="currentColor" fill="none"
                                      d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            </svg>
                            <span id="focus-timer-text" class="absolute font-mono text-xs font-black text-emerald-600 dark:text-emerald-400">25:00</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-emerald-700 dark:text-emerald-300 flex items-center gap-1.5">
                                <span>Deep Work Pomodoro</span>
                                <span class="text-[10px] font-mono px-1.5 py-0.2 rounded bg-emerald-500/20 text-emerald-600 dark:text-emerald-300">+50 XP Reward</span>
                            </h3>
                            <p class="font-mono text-[10px] text-emerald-600/80 dark:text-emerald-400/70 mt-0.5">Focus uninterrupted on your top task!</p>
                        </div>
                    </div>

                    <!-- Focus Controls -->
                    <div class="flex items-center gap-2 font-mono text-xs">
                        <button type="button" onclick="toggleLoFiSound()" id="lofi-toggle-btn"
                                class="px-2.5 py-1 rounded-xl border text-[11px] font-semibold transition active:scale-95"
                                style="background-color: var(--bg-card); border-color: var(--focus-banner-border); color: #15803d;">
                            🌧️ Ambient Sound: Off
                        </button>
                        <button type="button" onclick="startOrPauseFocusTimer()" id="focus-action-btn"
                                class="duo-btn-green px-4 py-1.5 rounded-xl text-slate-950 font-black text-xs">
                            Start Focus ▶
                        </button>
                        <button type="button" onclick="resetFocusTimer()" class="p-1 text-slate-400 hover:text-slate-600 dark:hover:text-white" title="Reset">
                            ↺
                        </button>
                        <button type="button" onclick="toggleFocusMode()" class="p-1 text-slate-400 hover:text-slate-600 dark:hover:text-white" title="Close Focus Bar">
                            ✕
                        </button>
                    </div>
                </div>
            </div>

            <!-- Top View Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 mb-6 border-b" style="border-color: var(--border-subtle)">
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight flex items-center gap-2.5" style="color: var(--text-primary)">
                        @if($filter === 'today')
                            <span>Due Today</span>
                            <span class="text-amber-500 text-lg">☀️</span>
                        @elseif($filter === 'important')
                            <span>Important Tasks</span>
                            <span class="text-rose-500 text-lg">⚡️</span>
                        @elseif($filter === 'active')
                            <span>In Progress</span>
                            <span class="text-sky-500 text-lg">🎯</span>
                        @elseif($filter === 'done')
                            <span>Completed Tasks</span>
                            <span class="text-duo-green text-lg">✓</span>
                        @elseif($category !== 'all')
                            <span>Tag: #{{ $category }}</span>
                        @elseif($priority !== 'all')
                            <span>{{ ucfirst($priority) }} Priority</span>
                        @else
                            <span>All Tasks</span>
                        @endif
                    </h1>
                    <p class="font-mono text-[11px] mt-0.5" style="color: var(--text-muted)">
                        {{ now()->translatedFormat('l, M j, Y') }} • Fast, keyboard-first task manager
                    </p>
                </div>

                <!-- Instant Search & Sort -->
                <div class="flex items-center gap-2">
                    <form action="{{ route('todos.index') }}" method="GET" class="relative">
                        <input type="hidden" name="filter" value="{{ $filter }}">
                        <input type="hidden" name="priority" value="{{ $priority }}">
                        <input type="hidden" name="category" value="{{ $category }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">

                        <div class="relative flex items-center">
                            <svg class="w-3.5 h-3.5 absolute left-3 pointer-events-none" style="color: var(--text-muted)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Filter (/ or ⌘K)" id="search-input"
                                   class="pl-8 pr-7 py-1.5 font-mono text-xs rounded-xl border focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition-all w-36 sm:w-48 focus:w-56"
                                   style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-primary)">
                            @if($search)
                                <a href="{{ route('todos.index', ['filter' => $filter, 'priority' => $priority, 'category' => $category, 'sort' => $sort]) }}"
                                   class="absolute right-2.5 text-xs hover:opacity-80" style="color: var(--text-muted)">✕</a>
                            @endif
                        </div>
                    </form>

                    <form action="{{ route('todos.index') }}" method="GET">
                        <input type="hidden" name="filter" value="{{ $filter }}">
                        <input type="hidden" name="priority" value="{{ $priority }}">
                        <input type="hidden" name="category" value="{{ $category }}">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <select name="sort" onchange="this.form.submit()"
                                class="font-mono text-xs rounded-xl px-2.5 py-1.5 border outline-none cursor-pointer focus:ring-2 focus:ring-indigo-500/30 transition"
                                style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-secondary)">
                            <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Recent</option>
                            <option value="due_date" {{ $sort === 'due_date' ? 'selected' : '' }}>Due Date</option>
                            <option value="priority" {{ $sort === 'priority' ? 'selected' : '' }}>Priority</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Dynamic Flash / Live Status Notification Banner -->
            <div id="live-toast-banner" class="hidden mb-5 flex items-center justify-between border rounded-2xl px-4 py-2.5 text-xs font-mono shadow-xs transition-all duration-300"
                 style="background-color: var(--bg-card); border-color: #58cc02; color: #58cc02;">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-duo-green animate-ping"></span>
                    <span id="live-toast-text" class="font-bold">Task updated!</span>
                </div>
                <button type="button" onclick="document.getElementById('live-toast-banner').classList.add('hidden')" class="text-xs font-bold ml-3 hover:opacity-75">✕</button>
            </div>

            <!-- High-Precision Metric Strip with Shimmer & XP Rate -->
            <div class="rounded-2xl px-4 py-3 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs border"
                 style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
                <div class="flex items-center gap-4 font-mono text-[11px]" style="color: var(--text-secondary)">
                    <span class="font-bold"><span id="metric-total-val" style="color: var(--text-primary)">{{ $totalCount }}</span> total</span>
                    <span style="color: var(--text-muted)">•</span>
                    <span class="text-amber-500 font-bold"><span id="metric-remaining-val">{{ $remainingCount }}</span> active</span>
                    <span style="color: var(--text-muted)">•</span>
                    <span class="text-duo-green font-bold"><span id="metric-completed-val">{{ $completedCount }}</span> completed</span>
                </div>

                <div class="flex items-center gap-3">
                    <span class="font-mono text-[10px]" style="color: var(--text-muted)">Progress:</span>
                    <div class="relative w-36 h-2.5 rounded-full overflow-hidden shimmer-bar border"
                         style="background-color: var(--shimmer-track); border-color: var(--border-subtle);">
                        <div id="metric-progress-bar" class="bg-gradient-to-r from-indigo-500 via-duo-blue to-duo-green h-full rounded-full transition-all duration-500 ease-out"
                             style="width: {{ $completionPercentage }}%"></div>
                    </div>
                    <span id="metric-percentage-val" class="font-mono text-[10px] font-extrabold" style="color: var(--text-primary)">{{ $completionPercentage }}%</span>
                </div>
            </div>

            <!-- Duolingo-Tactile Command Bar (3D Push Button with Instant Optimistic Submission) -->
            <div class="rounded-2xl p-3.5 mb-6 transition-all border shadow-sm"
                 style="background-color: var(--bg-card); border-color: var(--border-card);">
                <form id="add-task-form" onsubmit="handleAddTaskAsync(event)">
                    @csrf
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="hidden" name="filter_priority" value="{{ $priority }}">
                    <input type="hidden" name="filter_category" value="{{ $category }}">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="sort" value="{{ $sort }}">

                    <div class="flex items-center gap-2">
                        <span class="text-duo-green text-base font-mono font-extrabold select-none pl-1">+</span>
                        <input type="text" name="title" id="task-title-input" placeholder="Create new task… (press Return to save)"
                               value="{{ old('title') }}" required autofocus
                               class="flex-1 text-sm bg-transparent outline-none"
                               style="color: var(--text-primary)">
                        
                        <!-- Tactile 3D Push Button -->
                        <button type="submit" id="add-task-btn" class="duo-btn-green text-slate-950 font-black text-xs px-4 py-2 rounded-xl flex items-center gap-1.5 shadow-sm">
                            <span>Add</span>
                            <kbd class="font-mono text-[10px] opacity-75">↵</kbd>
                        </button>
                    </div>

                    <!-- Quick Metadata Controls -->
                    <div class="flex flex-wrap items-center gap-2.5 mt-2.5 pt-2.5 border-t text-xs pl-4 font-mono" style="border-color: var(--border-subtle)">
                        
                        <!-- Priority -->
                        <div class="flex items-center gap-1 text-[11px]" style="color: var(--text-secondary)">
                            <span style="color: var(--text-muted)">pri:</span>
                            <select name="priority" id="task-priority-select" class="rounded-lg px-2 py-0.5 border outline-none cursor-pointer"
                                    style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-secondary)">
                                <option value="low">Low (I)</option>
                                <option value="medium" selected>Medium (II)</option>
                                <option value="high">High (III)</option>
                            </select>
                        </div>

                        <!-- Due Date -->
                        <div class="flex items-center gap-1 text-[11px]" style="color: var(--text-secondary)">
                            <span style="color: var(--text-muted)">due:</span>
                            <input type="date" name="due_date" id="task-due-date-input"
                                   class="rounded-lg px-1.5 py-0.5 border outline-none cursor-pointer"
                                   style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-secondary)">
                        </div>

                        <!-- Tag -->
                        <div class="flex items-center gap-1 text-[11px]" style="color: var(--text-secondary)">
                            <span style="color: var(--text-muted)">tag:</span>
                            <input type="text" name="category" id="task-category-input" placeholder="e.g. Core"
                                   class="rounded-lg px-2 py-0.5 border outline-none w-24"
                                   style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-secondary)">
                        </div>

                        <!-- Notes toggle -->
                        <button type="button" onclick="document.getElementById('notes-field').classList.toggle('hidden')" class="text-[11px] ml-auto transition hover:underline" style="color: var(--text-muted)">
                            + description
                        </button>
                    </div>

                    <!-- Expandable Context Notes -->
                    <div id="notes-field" class="hidden mt-2.5 pl-4">
                        <textarea name="description" id="task-desc-input" rows="2" placeholder="Task notes, links, or context…"
                                  class="w-full text-xs font-mono rounded-xl p-2.5 border outline-none focus:ring-2 focus:ring-indigo-500/30"
                                  style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-primary)"></textarea>
                    </div>
                </form>
            </div>

            <!-- Task List Table / Rows Container -->
            <div class="space-y-2.5 mb-6" id="tasks-container">
                @if($todos->isEmpty())
                    <div id="empty-state" class="text-center py-16 px-4 rounded-2xl border"
                         style="background-color: var(--bg-card); border-color: var(--border-card);">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl border flex items-center justify-center text-duo-green font-mono text-2xl animate-bounce"
                             style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
                            ✓
                        </div>
                        <h3 class="text-sm font-bold mb-1" style="color: var(--text-primary)">All Clear & Tidy!</h3>
                        <p class="text-xs font-mono" style="color: var(--text-muted)">
                            @if($filter === 'done')
                                No completed tasks yet. Tap a circle to finish one!
                            @elseif($remainingCount === 0 && $totalCount > 0)
                                All tasks resolved! Daily streak fully defended. 🔥
                            @elseif($search)
                                No items match query "{{ $search }}".
                            @else
                                No tasks registered in this view. Add one above!
                            @endif
                        </p>
                    </div>
                @else
                    @foreach($todos as $todo)
                        <div class="task-card task-stagger group rounded-2xl p-3.5" id="todo-row-{{ $todo->id }}"
                             data-id="{{ $todo->id }}" data-priority="{{ $todo->priority }}" data-completed="{{ $todo->completed ? 'true' : 'false' }}"
                             style="animation-delay: {{ $loop->index * 0.05 }}s;">
                            
                            <!-- Row Content -->
                            <div class="flex items-start gap-3.5" id="view-mode-{{ $todo->id }}">
                                
                                <!-- Bouncy Tactile Checkbox Toggle (Instant Async!) -->
                                <button type="button" onclick="handleToggleAsync({{ $todo->id }}, this)" id="check-btn-{{ $todo->id }}"
                                        class="checkbox-bounce w-5 h-5 rounded-md border flex items-center justify-center cursor-pointer mt-0.5 shrink-0 {{ $todo->completed ? 'bg-duo-green border-duo-green text-slate-950 font-bold shadow-xs' : 'text-transparent hover:border-duo-green' }}"
                                        style="{{ !$todo->completed ? 'background-color: var(--input-bg); border-color: var(--input-border);' : '' }}">
                                    <svg class="w-3.5 h-3.5 fill-current stroke-current" stroke-width="2.5" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </button>

                                <!-- Title, Tags & Indicators -->
                                <div class="flex-1 min-w-0" ondblclick="showEditMode({{ $todo->id }})">
                                    <div class="flex flex-wrap items-center gap-2">
                                        
                                        <!-- Priority Pills -->
                                        @if($todo->priority === 'high')
                                            <span class="font-mono text-[9px] px-1.5 py-0.2 rounded bg-rose-500/10 text-rose-500 border border-rose-500/30 font-bold tracking-tight" title="High Priority (+25 XP)">HIGH</span>
                                        @elseif($todo->priority === 'medium')
                                            <span class="font-mono text-[9px] px-1.5 py-0.2 rounded bg-amber-500/10 text-amber-500 border border-amber-500/30 font-bold tracking-tight" title="Medium Priority (+15 XP)">MED</span>
                                        @else
                                            <span class="font-mono text-[9px] px-1.5 py-0.2 rounded bg-slate-500/10 border border-slate-500/20 font-medium tracking-tight" style="color: var(--text-muted)" title="Low Priority (+10 XP)">LOW</span>
                                        @endif

                                        <span id="title-text-{{ $todo->id }}" class="text-sm font-semibold tracking-tight break-words {{ $todo->completed ? 'task-done' : '' }}" style="{{ !$todo->completed ? 'color: var(--text-primary);' : '' }}">
                                            {{ $todo->title }}
                                        </span>

                                        <!-- Tag Pill -->
                                        @if($todo->category)
                                            <a href="{{ route('todos.index', ['category' => $todo->category, 'sort' => $sort]) }}"
                                               class="font-mono text-[10px] px-1.5 py-0.2 rounded-md transition hover:scale-105 border"
                                               style="background-color: var(--tag-bg); border-color: var(--tag-border); color: var(--tag-text);">
                                                #{{ $todo->category }}
                                            </a>
                                        @endif

                                        <!-- Due Date Badge -->
                                        @if($todo->due_date)
                                            <span class="font-mono text-[10px] {{ $todo->isOverdue() ? 'text-rose-500 font-bold' : ($todo->isDueToday() ? 'text-amber-500 font-bold' : '') }}" style="{{ !$todo->isOverdue() && !$todo->isDueToday() ? 'color: var(--text-muted);' : '' }}">
                                                {{ $todo->isDueToday() ? 'Today' : ($todo->isOverdue() ? 'Overdue' : $todo->due_date->format('M j')) }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($todo->description)
                                        <p id="desc-text-{{ $todo->id }}" class="text-xs mt-1 line-clamp-1 font-mono {{ $todo->completed ? 'task-done' : '' }}" style="color: var(--text-secondary)">
                                            {{ $todo->description }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Actions Toolbar on Hover -->
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1" style="color: var(--text-muted)">
                                    <button type="button" onclick="showEditMode({{ $todo->id }})" title="Edit Task"
                                            class="p-1.5 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200 dark:hover:bg-[#1a202c] rounded-lg transition-transform active:scale-90">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <button type="button" onclick="handleDeleteAsync({{ $todo->id }}, this)" title="Delete Task"
                                            class="p-1.5 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-transform active:scale-90">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                            </div>

                            <!-- Inline Edit Mode Panel -->
                            <div id="edit-mode-{{ $todo->id }}" class="hidden pt-2">
                                <form onsubmit="handleEditAsync(event, {{ $todo->id }})" class="space-y-2.5 p-3 rounded-xl border"
                                      style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
                                    <input type="text" name="title" id="edit-title-{{ $todo->id }}" value="{{ $todo->title }}" required
                                           class="w-full text-xs font-semibold rounded-lg p-2 border outline-none focus:ring-2 focus:ring-indigo-500/30"
                                           style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-primary)">

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 font-mono text-xs">
                                        <select name="priority" id="edit-priority-{{ $todo->id }}" class="rounded-lg p-1.5 border outline-none"
                                                style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-secondary)">
                                            <option value="low" {{ $todo->priority === 'low' ? 'selected' : '' }}>Low (I)</option>
                                            <option value="medium" {{ $todo->priority === 'medium' ? 'selected' : '' }}>Medium (II)</option>
                                            <option value="high" {{ $todo->priority === 'high' ? 'selected' : '' }}>High (III)</option>
                                        </select>

                                        <input type="date" name="due_date" id="edit-due-date-{{ $todo->id }}" value="{{ $todo->due_date ? $todo->due_date->format('Y-m-d') : '' }}"
                                               class="rounded-lg p-1.5 border outline-none"
                                               style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-secondary)">

                                        <input type="text" name="category" id="edit-category-{{ $todo->id }}" value="{{ $todo->category }}" placeholder="Tag"
                                               class="rounded-lg p-1.5 border outline-none"
                                               style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-secondary)">
                                    </div>

                                    <textarea name="description" id="edit-desc-{{ $todo->id }}" rows="2" placeholder="Notes…" class="w-full font-mono text-xs rounded-lg p-2 border outline-none"
                                              style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-primary)">{{ $todo->description }}</textarea>

                                    <div class="flex items-center justify-end gap-2 pt-1 text-xs">
                                        <button type="button" onclick="hideEditMode({{ $todo->id }})" class="px-2 py-1 font-mono hover:underline" style="color: var(--text-muted)">
                                            Cancel
                                        </button>
                                        <button type="submit" class="duo-btn-green text-slate-950 font-bold px-3.5 py-1.5 rounded-lg transition-colors">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Bottom Productivity Actions (Instant Async Bulk Operations) -->
            <div class="flex items-center justify-between text-xs pt-3 border-t font-mono" style="border-color: var(--border-subtle); color: var(--text-muted)">
                <span><span id="stat-active-pending">{{ $remainingCount }}</span> active pending</span>

                <div class="flex items-center gap-3">
                    <button type="button" onclick="handleMarkAllDoneAsync()" class="hover:text-duo-green font-semibold transition-colors">Mark all done</button>
                    <span>•</span>
                    <button type="button" onclick="handleClearCompletedAsync()" class="hover:text-rose-500 font-semibold transition-colors">Clear completed</button>
                </div>
            </div>

        </div>

        <!-- Subtle Footer -->
        <footer class="mt-8 text-center font-mono text-[10px] flex items-center justify-center gap-3" style="color: var(--text-muted)">
            <span>Fay Tasks • Gamified Task Dashboard</span>
            <span>•</span>
            <button type="button" onclick="openLeaderboard()" class="text-amber-500 hover:underline font-bold">🏆 League</button>
            <span>•</span>
            <button type="button" onclick="toggleShortcutsModal()" class="hover:underline">Shortcuts (?)</button>
        </footer>

    </main>

    <!-- Command Palette Modal (Linear / Raycast Style ⌘K) -->
    <div id="command-palette" class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-xs flex items-start justify-center pt-20 p-4">
        <div class="rounded-3xl max-w-lg w-full p-4 shadow-2xl relative border animate-spring-in"
             style="background-color: var(--bg-card); border-color: var(--border-card);">
            
            <div class="flex items-center gap-2.5 pb-3 border-b" style="border-color: var(--border-subtle)">
                <span class="text-slate-400 font-mono text-sm">⌘</span>
                <input type="text" id="palette-search-input" placeholder="Type a command or search tasks…" oninput="filterPalette(this.value)"
                       class="flex-1 text-sm bg-transparent outline-none font-sans" style="color: var(--text-primary)">
                <kbd class="px-1.5 py-0.5 rounded text-[10px] font-mono border" style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-muted)">ESC</kbd>
            </div>

            <!-- Command List -->
            <div class="mt-2 space-y-1 max-h-72 overflow-y-auto text-xs font-mono" id="palette-items">
                <button type="button" onclick="focusNewTask(); closeCommandPalette();"
                        class="w-full flex items-center justify-between p-2 rounded-xl text-left hover:bg-indigo-500/10 hover:text-indigo-400 transition">
                    <span>➕ Create new task</span>
                    <kbd class="text-[10px] opacity-60">N</kbd>
                </button>
                <button type="button" onclick="toggleFocusMode(); closeCommandPalette();"
                        class="w-full flex items-center justify-between p-2 rounded-xl text-left hover:bg-emerald-500/10 hover:text-emerald-400 transition">
                    <span>⏱️ Toggle Pomodoro Focus Mode (25m)</span>
                    <kbd class="text-[10px] opacity-60">F</kbd>
                </button>
                <button type="button" onclick="toggleTheme(); closeCommandPalette();"
                        class="w-full flex items-center justify-between p-2 rounded-xl text-left hover:bg-amber-500/10 hover:text-amber-400 transition">
                    <span>☀️ Toggle Light / Dark Theme</span>
                    <kbd class="text-[10px] opacity-60">T</kbd>
                </button>
                <button type="button" onclick="toggleAudio(); closeCommandPalette();"
                        class="w-full flex items-center justify-between p-2 rounded-xl text-left hover:bg-sky-500/10 hover:text-sky-400 transition">
                    <span>🔊 Toggle Sound Synthesizer</span>
                    <kbd class="text-[10px] opacity-60">M</kbd>
                </button>
                <button type="button" onclick="openMysteryChest(); closeCommandPalette();"
                        class="w-full flex items-center justify-between p-2 rounded-xl text-left hover:bg-purple-500/10 hover:text-purple-400 transition">
                    <span>🎁 Open Mystery Daily Reward Chest</span>
                    <kbd class="text-[10px] opacity-60">C</kbd>
                </button>
                <button type="button" onclick="openLeaderboard(); closeCommandPalette();"
                        class="w-full flex items-center justify-between p-2 rounded-xl text-left hover:bg-amber-500/10 hover:text-amber-400 transition">
                    <span>🏆 View Obsidian League Leaderboard</span>
                    <kbd class="text-[10px] opacity-60">L</kbd>
                </button>
            </div>
        </div>
    </div>

    <!-- Duolingo League Leaderboard Modal -->
    <div id="leaderboard-modal" class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="rounded-3xl max-w-sm w-full p-6 shadow-2xl relative border animate-spring-in"
             style="background-color: var(--bg-card); border-color: var(--border-card);">
            <div class="flex items-center justify-between mb-3 pb-3 border-b" style="border-color: var(--border-subtle)">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🏆</span>
                    <div>
                        <h3 class="text-sm font-extrabold" style="color: var(--text-primary)">Obsidian League</h3>
                        <p class="text-[9px] font-mono text-amber-500">Top 3 advance to Diamond League</p>
                    </div>
                </div>
                <button type="button" onclick="closeLeaderboard()" class="font-mono text-sm hover:opacity-75" style="color: var(--text-muted)">✕</button>
            </div>

            <!-- Leaderboard Rows -->
            <div class="space-y-2 font-mono text-xs mb-4">
                <div class="flex items-center justify-between p-2 rounded-xl bg-amber-500/10 border border-amber-500/30">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-amber-500">1</span>
                        <span class="w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-bold flex items-center justify-center text-[10px]">👑</span>
                        <span class="font-bold" style="color: var(--text-primary)">Fay (You)</span>
                    </div>
                    <span class="font-bold text-amber-500"><span id="leaderboard-user-xp">145</span> XP</span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-xl border" style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-400">2</span>
                        <span class="w-6 h-6 rounded-full bg-slate-300 dark:bg-slate-700 font-bold flex items-center justify-center text-[10px]">🦉</span>
                        <span style="color: var(--text-secondary)">Zari</span>
                    </div>
                    <span style="color: var(--text-muted)">120 XP</span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-xl border" style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-amber-700 dark:text-amber-600">3</span>
                        <span class="w-6 h-6 rounded-full bg-slate-300 dark:bg-slate-700 font-bold flex items-center justify-center text-[10px]">🐱</span>
                        <span style="color: var(--text-secondary)">Bea</span>
                    </div>
                    <span style="color: var(--text-muted)">95 XP</span>
                </div>
                <div class="flex items-center justify-between p-2 rounded-xl border" style="background-color: var(--metric-bg); border-color: var(--border-subtle);">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-500">4</span>
                        <span class="w-6 h-6 rounded-full bg-slate-300 dark:bg-slate-700 font-bold flex items-center justify-center text-[10px]">🦊</span>
                        <span style="color: var(--text-secondary)">Lin</span>
                    </div>
                    <span style="color: var(--text-muted)">80 XP</span>
                </div>
            </div>

            <button type="button" onclick="closeLeaderboard()" class="w-full duo-btn-green py-2.5 rounded-2xl text-slate-950 font-bold text-xs uppercase tracking-wider">
                Keep Leading! 🚀
            </button>
        </div>
    </div>

    <!-- Daily Mystery Chest Modal Overlay -->
    <div id="chest-modal" class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl relative animate-combo-burst border"
             style="background-color: var(--bg-card); border-color: var(--border-card);">
            <div class="w-16 h-16 mx-auto mb-3 text-5xl animate-chest">
                🎁
            </div>
            <h3 class="text-lg font-extrabold mb-1" style="color: var(--text-primary)">Daily Reward Unlocked!</h3>
            <p class="text-xs mb-4" id="chest-reward-message" style="color: var(--text-secondary)">
                You earned bonus XP for keeping your streak alive!
            </p>
            <div class="font-mono text-2xl font-black text-amber-500 mb-6 tracking-tight">
                ⚡️ +50 BONUS XP
            </div>
            <button type="button" onclick="closeMysteryChest()"
                    class="duo-btn-green w-full py-3 rounded-2xl text-slate-950 font-black text-xs uppercase tracking-wider shadow-md">
                Claim & Keep Crushing! 🚀
            </button>
        </div>
    </div>

    <!-- Keyboard Shortcuts Modal -->
    <div id="shortcuts-modal" class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="rounded-3xl max-w-md w-full p-6 shadow-2xl relative border"
             style="background-color: var(--bg-card); border-color: var(--border-card);">
            <div class="flex items-center justify-between mb-4 pb-3 border-b" style="border-color: var(--border-subtle)">
                <h3 class="text-sm font-bold flex items-center gap-2" style="color: var(--text-primary)">
                    <span>⚡️</span> Keyboard Shortcuts
                </h3>
                <button type="button" onclick="toggleShortcutsModal()" class="font-mono text-sm hover:opacity-75" style="color: var(--text-muted)">✕</button>
            </div>
            <div class="space-y-2 font-mono text-xs">
                <div class="flex justify-between items-center py-1">
                    <span style="color: var(--text-secondary)">Command Palette</span>
                    <kbd class="px-2 py-0.5 rounded border" style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-primary)">⌘K / Ctrl+K</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span style="color: var(--text-secondary)">New Task Focus</span>
                    <kbd class="px-2 py-0.5 rounded border" style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-primary)">N</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span style="color: var(--text-secondary)">Search / Filter</span>
                    <kbd class="px-2 py-0.5 rounded border" style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-primary)">/</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span style="color: var(--text-secondary)">Toggle Focus Mode (Pomodoro)</span>
                    <kbd class="px-2 py-0.5 rounded border" style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-primary)">F</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span style="color: var(--text-secondary)">Toggle Light / Dark Mode</span>
                    <kbd class="px-2 py-0.5 rounded border" style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-primary)">T</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span style="color: var(--text-secondary)">Toggle Audio Synthesizer</span>
                    <kbd class="px-2 py-0.5 rounded border" style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-primary)">M</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span style="color: var(--text-secondary)">Open Mystery Chest</span>
                    <kbd class="px-2 py-0.5 rounded border" style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-primary)">C</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span style="color: var(--text-secondary)">Pet Mascot</span>
                    <kbd class="px-2 py-0.5 rounded border" style="background-color: var(--metric-bg); border-color: var(--border-subtle); color: var(--text-primary)">P</kbd>
                </div>
            </div>
            <button type="button" onclick="toggleShortcutsModal()" class="mt-5 w-full duo-btn-card py-2.5 rounded-xl font-bold text-xs" style="color: var(--text-primary)">
                Got it
            </button>
        </div>
    </div>

    <!-- Web Audio Synthesizer, Optimistic AJAX, Pomodoro, Mascot Tracking & Gamification -->
    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const CURRENT_FILTER = "{{ $filter }}";

        // Web Audio Synthesizer
        let audioCtx = null;
        let isAudioEnabled = localStorage.getItem('fay_audio_enabled') !== 'false';
        let lofiNoiseNode = null;
        let isLofiPlaying = false;

        // Combo Multiplier System
        let lastCompletionTime = 0;
        let comboCount = 0;

        function getAudioContext() {
            if (!audioCtx) {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (AudioContextClass) {
                    audioCtx = new AudioContextClass();
                }
            }
            if (audioCtx && audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            return audioCtx;
        }

        function toggleAudio() {
            isAudioEnabled = !isAudioEnabled;
            localStorage.setItem('fay_audio_enabled', isAudioEnabled);
            updateAudioButtonText();
            if (isAudioEnabled) {
                playTaskCompleteSound(15, 1);
            }
        }

        function updateAudioButtonText() {
            const btn = document.getElementById('audio-toggle-btn');
            const mBtn = document.getElementById('mobile-audio-btn');
            if (btn) btn.textContent = isAudioEnabled ? '🔊 Sound' : '🔇 Muted';
            if (mBtn) mBtn.textContent = isAudioEnabled ? '🔊' : '🔇';
        }

        // Theme Toggle: Light / Dark Mode
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
            playTaskAddSound();
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

        // Duolingo Signature Major Chime on Task Complete (with combo pitch escalation!)
        function playTaskCompleteSound(xp, combo) {
            if (!isAudioEnabled) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            const pitchShift = Math.min(6, (combo - 1) * 2);
            const baseC = 523.25 * Math.pow(1.059463, pitchShift);
            const baseE = 659.25 * Math.pow(1.059463, pitchShift);
            const baseG = 783.99 * Math.pow(1.059463, pitchShift);
            const baseC2 = 1046.50 * Math.pow(1.059463, pitchShift);

            const notes = xp >= 25 ? [baseC, baseE, baseG, baseC2] : [baseC, baseE, baseG];
            const startTime = ctx.currentTime;

            notes.forEach((freq, index) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();

                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, startTime + index * 0.07);

                gain.gain.setValueAtTime(0, startTime + index * 0.07);
                gain.gain.linearRampToValueAtTime(0.24, startTime + index * 0.07 + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.001, startTime + index * 0.07 + 0.35);

                osc.connect(gain);
                gain.connect(ctx.destination);

                osc.start(startTime + index * 0.07);
                osc.stop(startTime + index * 0.07 + 0.35);
            });
        }

        // Mascot Cute Chirp Sound
        function playMascotChirp() {
            if (!isAudioEnabled) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'triangle';
            osc.frequency.setValueAtTime(650, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(980, ctx.currentTime + 0.1);

            gain.gain.setValueAtTime(0.2, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.18);

            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.18);
        }

        // Fanfare Sound for Daily Chest / Goal
        function playFanfareSound() {
            if (!isAudioEnabled) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            const chords = [523.25, 659.25, 783.99, 1046.50, 1318.51];
            const startTime = ctx.currentTime;

            chords.forEach((freq, index) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(freq, startTime + index * 0.09);
                gain.gain.setValueAtTime(0, startTime + index * 0.09);
                gain.gain.linearRampToValueAtTime(0.28, startTime + index * 0.09 + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.001, startTime + index * 0.09 + 0.45);
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.start(startTime + index * 0.09);
                osc.stop(startTime + index * 0.09 + 0.45);
            });
        }

        // Soft Pop Sound on Task Add / Action
        function playTaskAddSound() {
            if (!isAudioEnabled) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            const osc = ctx.createOscillator();
            const gain = ctx.createGain();

            osc.type = 'triangle';
            osc.frequency.setValueAtTime(330, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(660, ctx.currentTime + 0.12);

            gain.gain.setValueAtTime(0.2, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.15);

            osc.connect(gain);
            gain.connect(ctx.destination);

            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.15);
        }

        // Whoosh Sound on Task Delete
        function playWhooshSound() {
            if (!isAudioEnabled) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(400, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(100, ctx.currentTime + 0.2);
            gain.gain.setValueAtTime(0.15, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.2);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start(ctx.currentTime);
            osc.stop(ctx.currentTime + 0.2);
        }

        // Synthesized Lo-Fi Ambient Rain/Noise for Deep Focus
        function toggleLoFiSound() {
            const btn = document.getElementById('lofi-toggle-btn');
            const ctx = getAudioContext();
            if (!ctx) return;

            if (isLofiPlaying) {
                if (lofiNoiseNode) {
                    lofiNoiseNode.stop();
                    lofiNoiseNode.disconnect();
                    lofiNoiseNode = null;
                }
                isLofiPlaying = false;
                if (btn) btn.textContent = '🌧️ Ambient Sound: Off';
            } else {
                const bufferSize = ctx.sampleRate * 2;
                const buffer = ctx.createBuffer(1, bufferSize, ctx.sampleRate);
                const data = buffer.getChannelData(0);
                for (let i = 0; i < bufferSize; i++) {
                    data[i] = (Math.random() * 2 - 1) * 0.035;
                }
                const whiteNoise = ctx.createBufferSource();
                whiteNoise.buffer = buffer;
                whiteNoise.loop = true;

                const filter = ctx.createBiquadFilter();
                filter.type = 'lowpass';
                filter.frequency.setValueAtTime(450, ctx.currentTime);

                whiteNoise.connect(filter);
                filter.connect(ctx.destination);
                whiteNoise.start();

                lofiNoiseNode = whiteNoise;
                isLofiPlaying = true;
                if (btn) btn.textContent = '🌧️ Ambient Sound: Playing ♫';
            }
        }

        // Confetti Particle Physics Burst
        function triggerConfetti(x, y) {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 55,
                    spread: 70,
                    origin: {
                        x: x ? x / window.innerWidth : 0.5,
                        y: y ? y / window.innerHeight : 0.5
                    },
                    colors: ['#58cc02', '#1cb0f6', '#ff9600', '#ce82ff', '#ffc800', '#6366f1']
                });
            }
        }

        function triggerMegaConfetti() {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 160,
                    spread: 120,
                    origin: { y: 0.6 },
                    colors: ['#58cc02', '#1cb0f6', '#ff9600', '#ce82ff', '#ffc800', '#6366f1']
                });
            }
        }

        // Floating +XP Badge Animation
        function spawnFloatingXP(x, y, xp, combo) {
            const badge = document.createElement('div');
            badge.className = 'animate-xp-float font-mono font-black text-xs px-2.5 py-1 rounded-full bg-duo-green text-slate-950 border border-emerald-300 shadow-xl flex items-center gap-1';
            
            if (combo > 1) {
                badge.innerHTML = `<span>⚡️</span> +${xp} XP <span class="text-[10px] text-indigo-950 bg-white/50 px-1 rounded font-black">${combo}x!</span>`;
            } else {
                badge.innerHTML = `<span>⚡️</span> +${xp} XP`;
            }

            badge.style.left = `${x - 20}px`;
            badge.style.top = `${y - 15}px`;
            document.body.appendChild(badge);

            setTimeout(() => badge.remove(), 1200);
        }

        // Dynamic Combo Display Banner
        function showComboBanner(combo) {
            const banner = document.createElement('div');
            banner.className = 'animate-combo-burst fixed top-24 left-1/2 -translate-x-1/2 z-50 font-mono font-black text-sm px-4 py-2 rounded-2xl bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 text-white shadow-2xl border border-amber-300/40 pointer-events-none flex items-center gap-2';
            banner.innerHTML = `<span>🔥</span> ${combo}x TASK STREAK COMBO!`;
            document.body.appendChild(banner);
            setTimeout(() => banner.remove(), 1600);
        }

        // Show Live Dynamic Toast
        function showLiveToast(message) {
            const toast = document.getElementById('live-toast-banner');
            const text = document.getElementById('live-toast-text');
            if (toast && text) {
                text.textContent = message;
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 3500);
            }
        }

        // Update Global Metrics Live
        function updateLiveStats(stats) {
            if (!stats) return;
            const setVal = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.textContent = val;
            };

            setVal('metric-total-val', stats.total);
            setVal('stat-total', stats.total);
            setVal('metric-remaining-val', stats.remaining);
            setVal('stat-remaining', stats.remaining);
            setVal('stat-active-pending', stats.remaining);
            setVal('metric-completed-val', stats.completed);
            setVal('stat-completed', stats.completed);
            setVal('stat-today', stats.today);
            setVal('stat-important', stats.important);
            setVal('metric-percentage-val', `${stats.completionPercentage}%`);

            const bar = document.getElementById('metric-progress-bar');
            if (bar) bar.style.width = `${stats.completionPercentage}%`;
        }

        // 1. OPTIMISTIC INSTANT ASYNC TASK TOGGLE
        async function handleToggleAsync(id, buttonEl) {
            const row = document.getElementById(`todo-row-${id}`);
            const titleEl = document.getElementById(`title-text-${id}`);
            const descEl = document.getElementById(`desc-text-${id}`);
            const isCurrentlyDone = row.getAttribute('data-completed') === 'true';
            const priority = row.getAttribute('data-priority') || 'medium';

            const newDoneState = !isCurrentlyDone;
            row.setAttribute('data-completed', newDoneState ? 'true' : 'false');

            const rect = buttonEl.getBoundingClientRect();
            const clickX = rect.left + rect.width / 2;
            const clickY = rect.top + rect.height / 2;

            if (newDoneState) {
                // Streak combo calculation
                const now = Date.now();
                if (now - lastCompletionTime < 25000) {
                    comboCount++;
                } else {
                    comboCount = 1;
                }
                lastCompletionTime = now;

                const baseXP = priority === 'high' ? 25 : (priority === 'medium' ? 15 : 10);
                const awardedXP = baseXP * comboCount;

                // Visual updates
                buttonEl.classList.remove('text-transparent');
                buttonEl.classList.add('bg-duo-green', 'border-duo-green', 'text-slate-950', 'scale-125');
                if (titleEl) titleEl.classList.add('task-done');
                if (descEl) descEl.classList.add('task-done');

                spawnFloatingXP(clickX, clickY, awardedXP, comboCount);
                if (comboCount > 1) showComboBanner(comboCount);
                triggerConfetti(clickX, clickY);
                playTaskCompleteSound(awardedXP, comboCount);
                addXP(awardedXP);

                // Mascot animation
                const avatar = document.getElementById('mascot-avatar');
                if (avatar) avatar.classList.add('animate-mascot-cheer');

                // If on 'active' view, smoothly slide away after brief celebration
                if (CURRENT_FILTER === 'active') {
                    setTimeout(() => {
                        row.classList.add('animate-slide-out');
                        setTimeout(() => row.remove(), 350);
                    }, 500);
                }
            } else {
                buttonEl.classList.remove('bg-duo-green', 'border-duo-green', 'text-slate-950', 'scale-125');
                buttonEl.classList.add('text-transparent');
                if (titleEl) titleEl.classList.remove('task-done');
                if (descEl) descEl.classList.remove('task-done');
                playTaskAddSound();

                if (CURRENT_FILTER === 'done') {
                    setTimeout(() => {
                        row.classList.add('animate-slide-out');
                        setTimeout(() => row.remove(), 350);
                    }, 300);
                }
            }

            try {
                const response = await fetch(`/todos/${id}/toggle`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.stats) updateLiveStats(data.stats);
            } catch (err) {
                console.error('Toggle error:', err);
            }
        }

        // 2. OPTIMISTIC INSTANT ASYNC TASK ADD
        async function handleAddTaskAsync(event) {
            event.preventDefault();
            const form = event.target;
            const titleInput = document.getElementById('task-title-input');
            const priSelect = document.getElementById('task-priority-select');
            const dateInput = document.getElementById('task-due-date-input');
            const catInput = document.getElementById('task-category-input');
            const descInput = document.getElementById('task-desc-input');

            const title = titleInput.value.trim();
            if (!title) return;

            const priority = priSelect ? priSelect.value : 'medium';
            const due_date = dateInput ? dateInput.value : '';
            const category = catInput ? catInput.value.trim() : '';
            const description = descInput ? descInput.value.trim() : '';

            // Play instant pop audio
            playTaskAddSound();

            // Clear input and focus
            titleInput.value = '';
            if (descInput) descInput.value = '';
            document.getElementById('notes-field').classList.add('hidden');

            const formData = new FormData(form);

            try {
                const response = await fetch('/todos', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await response.json();

                if (data.success && data.todo) {
                    const todo = data.todo;
                    const container = document.getElementById('tasks-container');
                    const emptyState = document.getElementById('empty-state');
                    if (emptyState) emptyState.remove();

                    // Construct new task element with spring entrance
                    const card = document.createElement('div');
                    card.className = 'task-card animate-spring-in group rounded-2xl p-3.5';
                    card.id = `todo-row-${todo.id}`;
                    card.setAttribute('data-id', todo.id);
                    card.setAttribute('data-priority', todo.priority);
                    card.setAttribute('data-completed', 'false');

                    let priBadge = todo.priority === 'high' 
                        ? '<span class="font-mono text-[9px] px-1.5 py-0.2 rounded bg-rose-500/10 text-rose-500 border border-rose-500/30 font-bold tracking-tight">HIGH</span>'
                        : (todo.priority === 'medium'
                            ? '<span class="font-mono text-[9px] px-1.5 py-0.2 rounded bg-amber-500/10 text-amber-500 border border-amber-500/30 font-bold tracking-tight">MED</span>'
                            : '<span class="font-mono text-[9px] px-1.5 py-0.2 rounded bg-slate-500/10 border border-slate-500/20 font-medium tracking-tight" style="color: var(--text-muted)">LOW</span>');

                    let catBadge = todo.category ? `<span class="font-mono text-[10px] px-1.5 py-0.2 rounded-md border" style="background-color: var(--tag-bg); border-color: var(--tag-border); color: var(--tag-text);">#${todo.category}</span>` : '';
                    let descHtml = todo.description ? `<p id="desc-text-${todo.id}" class="text-xs mt-1 line-clamp-1 font-mono" style="color: var(--text-secondary)">${todo.description}</p>` : '';

                    card.innerHTML = `
                        <div class="flex items-start gap-3.5" id="view-mode-${todo.id}">
                            <button type="button" onclick="handleToggleAsync(${todo.id}, this)" id="check-btn-${todo.id}"
                                    class="checkbox-bounce w-5 h-5 rounded-md border flex items-center justify-center cursor-pointer mt-0.5 shrink-0 text-transparent hover:border-duo-green"
                                    style="background-color: var(--input-bg); border-color: var(--input-border);">
                                <svg class="w-3.5 h-3.5 fill-current stroke-current" stroke-width="2.5" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <div class="flex-1 min-w-0" ondblclick="showEditMode(${todo.id})">
                                <div class="flex flex-wrap items-center gap-2">
                                    ${priBadge}
                                    <span id="title-text-${todo.id}" class="text-sm font-semibold tracking-tight break-words" style="color: var(--text-primary);">${todo.title}</span>
                                    ${catBadge}
                                </div>
                                ${descHtml}
                            </div>
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1" style="color: var(--text-muted)">
                                <button type="button" onclick="showEditMode(${todo.id})" title="Edit"
                                        class="p-1.5 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-slate-200 dark:hover:bg-[#1a202c] rounded-lg transition-transform active:scale-90">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                                </button>
                                <button type="button" onclick="handleDeleteAsync(${todo.id}, this)" title="Delete"
                                        class="p-1.5 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-transform active:scale-90">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    `;

                    container.prepend(card);
                    if (data.stats) updateLiveStats(data.stats);
                    showLiveToast('Task created!');
                }
            } catch (err) {
                console.error('Error adding task:', err);
            }
        }

        // 3. OPTIMISTIC INSTANT ASYNC TASK DELETE
        async function handleDeleteAsync(id, buttonEl) {
            const row = document.getElementById(`todo-row-${id}`);
            if (!row) return;

            playWhooshSound();
            row.classList.add('animate-slide-out');
            setTimeout(() => row.remove(), 350);

            try {
                const response = await fetch(`/todos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.stats) updateLiveStats(data.stats);
                showLiveToast('Task deleted.');
            } catch (err) {
                console.error('Delete error:', err);
            }
        }

        // 4. OPTIMISTIC INSTANT ASYNC TASK EDIT
        async function handleEditAsync(event, id) {
            event.preventDefault();
            const titleInput = document.getElementById(`edit-title-${id}`);
            const priSelect = document.getElementById(`edit-priority-${id}`);
            const dateInput = document.getElementById(`edit-due-date-${id}`);
            const catInput = document.getElementById(`edit-category-${id}`);
            const descInput = document.getElementById(`edit-desc-${id}`);

            const payload = {
                title: titleInput.value.trim(),
                priority: priSelect.value,
                due_date: dateInput.value || null,
                category: catInput.value.trim() || null,
                description: descInput.value.trim() || null
            };

            const titleText = document.getElementById(`title-text-${id}`);
            const descText = document.getElementById(`desc-text-${id}`);
            if (titleText) titleText.textContent = payload.title;
            if (descText) descText.textContent = payload.description || '';

            hideEditMode(id);
            playTaskAddSound();

            try {
                const response = await fetch(`/todos/${id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                const data = await response.json();
                if (data.stats) updateLiveStats(data.stats);
                showLiveToast('Changes saved.');
            } catch (err) {
                console.error('Edit error:', err);
            }
        }

        // 5. BULK ACTION: MARK ALL DONE ASYNC
        async function handleMarkAllDoneAsync() {
            triggerMegaConfetti();
            playFanfareSound();

            document.querySelectorAll('#tasks-container .task-card').forEach(card => {
                const id = card.getAttribute('data-id');
                const btn = document.getElementById(`check-btn-${id}`);
                const title = document.getElementById(`title-text-${id}`);
                card.setAttribute('data-completed', 'true');
                if (btn) {
                    btn.classList.add('bg-duo-green', 'border-duo-green', 'text-slate-950');
                    btn.classList.remove('text-transparent');
                }
                if (title) title.classList.add('task-done');
            });

            try {
                const response = await fetch('/todos/bulk/complete-all', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.stats) updateLiveStats(data.stats);
                showLiveToast('All tasks marked done!');
            } catch (err) {
                console.error(err);
            }
        }

        // 6. BULK ACTION: CLEAR COMPLETED ASYNC
        async function handleClearCompletedAsync() {
            playWhooshSound();
            document.querySelectorAll('#tasks-container .task-card[data-completed="true"]').forEach(card => {
                card.classList.add('animate-slide-out');
                setTimeout(() => card.remove(), 350);
            });

            try {
                const response = await fetch('/todos/bulk/clear-completed', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.stats) updateLiveStats(data.stats);
                showLiveToast('Cleared completed tasks.');
            } catch (err) {
                console.error(err);
            }
        }

        // POMODORO FOCUS TIMER (25m Deep Work Engine)
        let focusTimerInterval = null;
        let focusSecondsRemaining = 25 * 60;
        let isFocusRunning = false;

        function toggleFocusMode() {
            const bar = document.getElementById('focus-bar');
            bar.classList.toggle('hidden');
        }

        function startOrPauseFocusTimer() {
            const actionBtn = document.getElementById('focus-action-btn');
            if (isFocusRunning) {
                clearInterval(focusTimerInterval);
                isFocusRunning = false;
                actionBtn.textContent = 'Resume Focus ▶';
                actionBtn.classList.remove('bg-amber-500');
            } else {
                isFocusRunning = true;
                actionBtn.textContent = 'Pause ❚❚';
                playTaskAddSound();

                focusTimerInterval = setInterval(() => {
                    if (focusSecondsRemaining > 0) {
                        focusSecondsRemaining--;
                        updateFocusTimerDisplay();
                    } else {
                        clearInterval(focusTimerInterval);
                        isFocusRunning = false;
                        triggerMegaConfetti();
                        playFanfareSound();
                        addXP(50);
                        alert("🎉 Fantastic Deep Work Session!\nYou completed 25 minutes of focus and earned +50 XP!");
                        resetFocusTimer();
                    }
                }, 1000);
            }
        }

        function resetFocusTimer() {
            clearInterval(focusTimerInterval);
            isFocusRunning = false;
            focusSecondsRemaining = 25 * 60;
            updateFocusTimerDisplay();
            const actionBtn = document.getElementById('focus-action-btn');
            if (actionBtn) actionBtn.textContent = 'Start Focus ▶';
        }

        function updateFocusTimerDisplay() {
            const m = Math.floor(focusSecondsRemaining / 60);
            const s = focusSecondsRemaining % 60;
            const timeStr = `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            
            const textEl = document.getElementById('focus-timer-text');
            const sideLabel = document.getElementById('sidebar-focus-label');
            if (textEl) textEl.textContent = timeStr;
            if (sideLabel) sideLabel.textContent = isFocusRunning ? timeStr : 'Focus Mode';

            const progress = document.getElementById('focus-circle-progress');
            if (progress) {
                const total = 25 * 60;
                const pct = ((total - focusSecondsRemaining) / total) * 100;
                progress.setAttribute('stroke-dashoffset', `${100 - pct}`);
            }
        }

        // COMMAND PALETTE LOGIC
        function openCommandPalette() {
            const p = document.getElementById('command-palette');
            p.classList.remove('hidden');
            const input = document.getElementById('palette-search-input');
            if (input) {
                input.value = '';
                input.focus();
            }
        }

        function closeCommandPalette() {
            const p = document.getElementById('command-palette');
            p.classList.add('hidden');
        }

        function filterPalette(query) {
            const items = document.querySelectorAll('#palette-items button');
            const q = query.toLowerCase();
            items.forEach(item => {
                const match = item.textContent.toLowerCase().includes(q);
                item.style.display = match ? 'flex' : 'none';
            });
        }

        function focusNewTask() {
            const input = document.getElementById('task-title-input');
            if (input) {
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                input.focus();
            }
        }

        // LEADERBOARD MODAL
        function openLeaderboard() {
            const m = document.getElementById('leaderboard-modal');
            m.classList.remove('hidden');
            const xp = parseInt(localStorage.getItem('fay_xp') || '45', 10);
            const xpEl = document.getElementById('leaderboard-user-xp');
            if (xpEl) xpEl.textContent = xp + 100;
        }

        function closeLeaderboard() {
            document.getElementById('leaderboard-modal').classList.add('hidden');
        }

        // MASCOT INTERACTION & EYE PUPIL TRACKING
        const mascotQuotes = [
            "You're on fire! 🔥",
            "Keep the streak blazing! 🚀",
            "Unstoppable momentum! ⚡️",
            "Crushing through tasks! 💥",
            "Focus mode: 100%! 🎯",
            "Tasks are shivering in fear! 🦉",
            "Don't let the owl down! 💚",
            "Level 4 is within reach! 🏆"
        ];

        function petMascot(e) {
            const avatar = document.getElementById('mascot-avatar');
            const bubble = document.getElementById('mascot-speech-bubble');
            const quoteEl = document.getElementById('mascot-quote-text');

            if (avatar) {
                avatar.classList.remove('animate-mascot-cheer');
                void avatar.offsetWidth;
                avatar.classList.add('animate-mascot-cheer');
            }

            if (bubble && quoteEl) {
                const randomQuote = mascotQuotes[Math.floor(Math.random() * mascotQuotes.length)];
                quoteEl.textContent = randomQuote;
                bubble.classList.remove('hidden');
                setTimeout(() => bubble.classList.add('hidden'), 3500);
            }

            if (e) {
                const rect = e.currentTarget.getBoundingClientRect();
                const heart = document.createElement('div');
                heart.className = 'animate-float-heart text-base';
                heart.textContent = '💚';
                heart.style.left = `${rect.left + 20}px`;
                heart.style.top = `${rect.top}px`;
                document.body.appendChild(heart);
                setTimeout(() => heart.remove(), 900);
            }

            playMascotChirp();
        }

        // Eye tracking: owl pupils look at cursor!
        document.addEventListener('mousemove', (e) => {
            const leftPupil = document.getElementById('pupil-left');
            const rightPupil = document.getElementById('pupil-right');
            const leftGleam = document.getElementById('gleam-left');
            const rightGleam = document.getElementById('gleam-right');
            if (!leftPupil || !rightPupil) return;

            const mascotCard = document.getElementById('mascot-card');
            if (!mascotCard) return;

            const rect = mascotCard.getBoundingClientRect();
            const owlX = rect.left + rect.width / 2;
            const owlY = rect.top + rect.height / 2;

            const angle = Math.atan2(e.clientY - owlY, e.clientX - owlX);
            const dist = Math.min(3.5, Math.hypot(e.clientX - owlX, e.clientY - owlY) / 120);

            const dx = Math.cos(angle) * dist;
            const dy = Math.sin(angle) * dist;

            leftPupil.setAttribute('cx', 37 + dx);
            leftPupil.setAttribute('cy', 46 + dy);
            rightPupil.setAttribute('cx', 63 + dx);
            rightPupil.setAttribute('cy', 46 + dy);

            if (leftGleam) {
                leftGleam.setAttribute('cx', 35 + dx * 0.7);
                leftGleam.setAttribute('cy', 44 + dy * 0.7);
            }
            if (rightGleam) {
                rightGleam.setAttribute('cx', 61 + dx * 0.7);
                rightGleam.setAttribute('cy', 44 + dy * 0.7);
            }
        });

        // Streak Freeze Shield Click Interaction
        function triggerFreezeShield() {
            if (isAudioEnabled) {
                const ctx = getAudioContext();
                if (ctx) {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(880, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(1760, ctx.currentTime + 0.15);
                    gain.gain.setValueAtTime(0.2, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + 0.3);
                }
            }
            alert("🧊 Streak Freeze Shield Active!\nYour streak is protected if you ever miss a day.");
        }

        // Mystery Chest Functions
        function openMysteryChest() {
            const modal = document.getElementById('chest-modal');
            modal.classList.remove('hidden');
            triggerMegaConfetti();
            playFanfareSound();
            addXP(50);
        }

        function closeMysteryChest() {
            document.getElementById('chest-modal').classList.add('hidden');
        }

        // Daily Quest Claim
        function claimQuest(questId, xp, btn) {
            btn.textContent = 'Claimed ✓';
            btn.classList.remove('duo-btn-green');
            btn.classList.add('bg-slate-300', 'dark:bg-slate-700', 'text-slate-500', 'cursor-default');
            btn.disabled = true;

            triggerConfetti();
            playFanfareSound();
            addXP(xp);

            const countEl = document.getElementById('quests-completed-count');
            if (countEl) countEl.textContent = '2/3 Done';
        }

        // Keyboard Shortcuts Modal Toggle
        function toggleShortcutsModal() {
            document.getElementById('shortcuts-modal').classList.toggle('hidden');
        }

        // Edit row helper
        function showEditMode(id) {
            const v = document.getElementById('view-mode-' + id);
            const e = document.getElementById('edit-mode-' + id);
            if (v && e) {
                v.classList.add('hidden');
                e.classList.remove('hidden');
                const input = document.getElementById(`edit-title-${id}`);
                if (input) input.focus();
            }
        }

        function hideEditMode(id) {
            const v = document.getElementById('view-mode-' + id);
            const e = document.getElementById('edit-mode-' + id);
            if (v && e) {
                v.classList.remove('hidden');
                e.classList.add('hidden');
            }
        }

        // Gamification State (localStorage)
        function initGamification() {
            let streak = parseInt(localStorage.getItem('fay_streak') || '3', 10);
            let xp = parseInt(localStorage.getItem('fay_xp') || '45', 10);
            const goalXP = 60;
            const level = Math.floor(xp / 50) + 1;

            document.getElementById('streak-counter').textContent = streak;
            document.getElementById('mobile-streak-val').textContent = streak;
            document.getElementById('current-xp-val').textContent = xp;
            document.getElementById('goal-xp-val').textContent = goalXP;
            document.getElementById('mobile-lvl-val').textContent = level;

            const pct = Math.min(100, Math.round((xp / goalXP) * 100));
            document.getElementById('xp-progress-bar').style.width = `${pct}%`;

            if (xp >= goalXP) {
                document.getElementById('user-rank-title').textContent = `Lvl ${level}: Focus Master 🔥`;
                document.getElementById('daily-status-text').textContent = 'Daily Goal Met!';
            } else {
                document.getElementById('daily-status-text').textContent = `${goalXP - xp} XP to Goal`;
                document.getElementById('user-rank-title').textContent = `Lvl ${level}: Focus Archer`;
            }

            updateAudioButtonText();
            updateThemeIcons();
        }

        function addXP(amount) {
            let xp = parseInt(localStorage.getItem('fay_xp') || '45', 10) + amount;
            localStorage.setItem('fay_xp', xp);
            initGamification();
        }

        // Global Keyboard Shortcuts (⌘K, N, /, F, T, M, C, P, ?, ESC)
        document.addEventListener('keydown', (e) => {
            // Meta+K / Ctrl+K for Command Palette
            if ((e.metaKey || e.ctrlKey) && (e.key === 'k' || e.key === 'K')) {
                e.preventDefault();
                openCommandPalette();
                return;
            }

            // ESC closes any open modal
            if (e.key === 'Escape') {
                closeCommandPalette();
                closeMysteryChest();
                closeLeaderboard();
                const sm = document.getElementById('shortcuts-modal');
                if (sm) sm.classList.add('hidden');
                document.activeElement.blur();
                return;
            }

            if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
                return;
            }

            if (e.key === 'n' || e.key === 'N') {
                e.preventDefault();
                focusNewTask();
            } else if (e.key === '/') {
                e.preventDefault();
                const search = document.getElementById('search-input');
                if (search) search.focus();
            } else if (e.key === 'f' || e.key === 'F') {
                toggleFocusMode();
            } else if (e.key === 't' || e.key === 'T') {
                toggleTheme();
            } else if (e.key === 'm' || e.key === 'M') {
                toggleAudio();
            } else if (e.key === 'c' || e.key === 'C') {
                openMysteryChest();
            } else if (e.key === 'p' || e.key === 'P') {
                petMascot();
            } else if (e.key === 'l' || e.key === 'L') {
                openLeaderboard();
            } else if (e.key === '?') {
                toggleShortcutsModal();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            initGamification();
        });
    </script>
</body>
</html>
