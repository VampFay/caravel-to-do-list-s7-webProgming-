<!DOCTYPE html>
<html lang="en" class="h-full dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fay Tasks — Gamified Duolingo-Grade Task Dashboard</title>
    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Canvas Confetti CDN -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
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
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #08090d;
            color: #f1f5f9;
            letter-spacing: -0.011em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* 3D Duolingo Tactile Push Buttons */
        .duo-btn-green {
            background-color: #58cc02;
            box-shadow: 0 4px 0 0 #46a302;
            transition: all 0.1s cubic-bezier(0.34, 1.56, 0.64, 1);
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
            transition: all 0.1s cubic-bezier(0.34, 1.56, 0.64, 1);
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

        .duo-btn-blue {
            background-color: #1cb0f6;
            box-shadow: 0 4px 0 0 #1899d6;
            transition: all 0.1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .duo-btn-blue:hover {
            background-color: #2ec0ff;
            transform: translateY(-2px);
            box-shadow: 0 6px 0 0 #1899d6;
        }
        .duo-btn-blue:active {
            transform: translateY(3px);
            box-shadow: 0 1px 0 0 #1899d6;
        }

        .duo-btn-card {
            background-color: #121622;
            box-shadow: 0 3px 0 0 #1d2436;
            transition: all 0.12s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .duo-btn-card:hover {
            background-color: #171d2c;
            transform: translateY(-1.5px);
            box-shadow: 0 5px 0 0 #1d2436;
        }
        .duo-btn-card:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 0 #1d2436;
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
        .mascot-eye {
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.45), transparent);
            animation: shimmer-sweep 2s infinite ease-in-out;
        }

        /* Checkbox Bounce Pop */
        .checkbox-bounce {
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .checkbox-bounce:hover {
            transform: scale(1.22) rotate(6deg);
            box-shadow: 0 0 12px rgba(88, 204, 2, 0.4);
        }
        .checkbox-bounce:active {
            transform: scale(0.85);
        }

        /* Task Card Hover Spring */
        .task-card {
            transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
        }
        .task-card:hover {
            transform: translateY(-3px) scale(1.004);
            box-shadow: 0 10px 28px -4px rgba(0, 0, 0, 0.55), 0 0 0 1px rgba(99, 102, 241, 0.18);
        }

        /* Strikethrough Smooth Draw Transition */
        .task-done {
            text-decoration: line-through;
            color: #475569 !important;
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

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0b0d13;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e2638;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2f3b55;
        }
    </style>
</head>
<body class="min-h-full flex flex-col md:flex-row bg-[#08090d] text-slate-100 antialiased selection:bg-indigo-500/30 selection:text-indigo-200 relative overflow-x-hidden">

    <!-- Ambient Subtle Firefly Particles in Background -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0 opacity-40">
        <div class="particle bg-indigo-500/40 w-1.5 h-1.5" style="top: 80%; left: 15%; animation-delay: 0s;"></div>
        <div class="particle bg-amber-400/40 w-2 h-2" style="top: 70%; left: 45%; animation-delay: 2s;"></div>
        <div class="particle bg-emerald-400/40 w-1 h-1" style="top: 85%; left: 75%; animation-delay: 4s;"></div>
        <div class="particle bg-purple-400/40 w-2 h-2" style="top: 90%; left: 88%; animation-delay: 1.5s;"></div>
        <div class="particle bg-pink-400/40 w-1.5 h-1.5" style="top: 60%; left: 30%; animation-delay: 3s;"></div>
    </div>

    <!-- Mobile Top Header Bar -->
    <header class="md:hidden flex items-center justify-between bg-[#0e1017] border-b border-[#1a1f2c] px-4 py-3 sticky top-0 z-30">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-duo-green to-emerald-400 border border-emerald-300/30 flex items-center justify-center text-slate-950 font-mono text-sm font-extrabold shadow-sm">
                F
            </div>
            <div>
                <span class="font-bold text-slate-100 text-sm tracking-tight block leading-none">Fay Tasks</span>
                <span class="font-mono text-[9px] text-amber-400 font-semibold leading-none">⚡️ Lvl <span id="mobile-lvl-val">3</span></span>
            </div>
        </div>
        
        <!-- Mobile Streak, Chest & Sound -->
        <div class="flex items-center gap-2">
            <button type="button" onclick="openMysteryChest()" title="Claim Daily Reward" class="text-base animate-chest p-1">
                🎁
            </button>
            <div class="flex items-center gap-1 bg-[#151924] border border-[#232b3d] px-2.5 py-1 rounded-full text-xs font-mono font-bold text-amber-400">
                <span class="animate-flame">🔥</span>
                <span id="mobile-streak-val">3</span>
            </div>
            <button type="button" onclick="toggleAudio()" id="mobile-audio-btn" title="Toggle Sound" class="p-1.5 text-slate-400 hover:text-white">
                🔊
            </button>
            <button type="button" onclick="document.getElementById('sidebar').classList.toggle('hidden')" class="p-1.5 text-slate-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="hidden md:flex flex-col w-64 lg:w-72 bg-[#0b0d13] border-r border-[#181d29] shrink-0 h-screen sticky top-0 p-4 select-none overflow-y-auto z-20">
        
        <!-- Workspace Identification -->
        <div class="flex items-center justify-between px-2.5 py-2 mb-4 rounded-xl bg-[#12151e] border border-[#1b212f]">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-indigo-500 via-indigo-600 to-purple-600 flex items-center justify-center text-white shadow-xs font-mono font-bold text-xs shrink-0">
                    F
                </div>
                <div class="min-w-0">
                    <h2 class="font-bold text-xs text-slate-200 truncate leading-none">Fay Tasks</h2>
                    <p class="font-mono text-[10px] text-slate-500 mt-1 leading-none truncate">Focus & Flow Workspace</p>
                </div>
            </div>
            <button type="button" onclick="toggleShortcutsModal()" title="Keyboard Shortcuts (?)" class="font-mono text-[9px] uppercase px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 hover:bg-indigo-500/20 font-semibold transition">
                ? Keys
            </button>
        </div>

        <!-- Duolingo Streak, XP & Level Card -->
        <div class="mb-4 p-3.5 rounded-2xl bg-gradient-to-b from-[#141824] via-[#10141f] to-[#0d1017] border border-[#232a3d] shadow-xs">
            
            <!-- Streak Header -->
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <span class="text-2xl animate-flame">🔥</span>
                    <div>
                        <span class="font-mono text-xs font-extrabold text-amber-400 leading-none block">
                            <span id="streak-counter">3</span> Day Streak!
                        </span>
                        <span class="text-[9px] text-slate-400 font-mono">Unstoppable pace</span>
                    </div>
                </div>

                <!-- Sound Toggle Button -->
                <button type="button" onclick="toggleAudio()" id="audio-toggle-btn" title="Toggle audio chime"
                        class="text-[10px] px-2 py-0.5 rounded-md bg-[#1b2130] hover:bg-[#252e42] border border-[#2a344a] text-slate-300 font-mono transition active:scale-95">
                    🔊 Sound
                </button>
            </div>

            <!-- Duolingo 7-Day Weekly Streak Row -->
            <div class="mt-2.5 mb-3 bg-[#0a0c12] border border-[#1b2130] rounded-xl p-2">
                <div class="flex items-center justify-between text-[10px] font-mono text-slate-400 mb-1.5 px-0.5">
                    <span class="text-[9px] uppercase tracking-wider text-slate-500 font-semibold">Streak Calendar</span>
                    <span class="text-[9px] text-sky-400 font-bold flex items-center gap-1 cursor-pointer" onclick="triggerFreezeShield()" title="1 Streak Freeze Active">
                        <span>🧊</span> 1 Shield
                    </span>
                </div>
                <div class="grid grid-cols-7 gap-1 text-center font-mono text-[10px]">
                    <!-- M -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] text-slate-500 mb-0.5">M</span>
                        <div class="w-6 h-6 rounded-full streak-active-node flex items-center justify-center text-slate-950 font-bold text-[10px] transition-transform hover:scale-110">✓</div>
                    </div>
                    <!-- T -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] text-slate-500 mb-0.5">T</span>
                        <div class="w-6 h-6 rounded-full streak-active-node flex items-center justify-center text-slate-950 font-bold text-[10px] transition-transform hover:scale-110">✓</div>
                    </div>
                    <!-- W -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] text-amber-400 font-bold mb-0.5">W</span>
                        <div class="w-6 h-6 rounded-full streak-active-node ring-2 ring-amber-300/80 flex items-center justify-center text-slate-950 font-bold text-[10px] animate-pulse">🔥</div>
                    </div>
                    <!-- T -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] text-slate-500 mb-0.5">T</span>
                        <div class="w-6 h-6 rounded-full bg-[#181e2b] border border-[#2b354a] flex items-center justify-center text-slate-600 text-[9px]">•</div>
                    </div>
                    <!-- F -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] text-slate-500 mb-0.5">F</span>
                        <div class="w-6 h-6 rounded-full bg-[#181e2b] border border-[#2b354a] flex items-center justify-center text-slate-600 text-[9px]">•</div>
                    </div>
                    <!-- S -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] text-slate-500 mb-0.5">S</span>
                        <div class="w-6 h-6 rounded-full bg-[#181e2b] border border-[#2b354a] flex items-center justify-center text-slate-600 text-[9px]">•</div>
                    </div>
                    <!-- S -->
                    <div class="flex flex-col items-center">
                        <span class="text-[9px] text-slate-500 mb-0.5">S</span>
                        <div class="w-6 h-6 rounded-full bg-[#181e2b] border border-[#2b354a] flex items-center justify-center text-slate-600 text-[9px]">•</div>
                    </div>
                </div>
            </div>

            <!-- XP Progress Bar -->
            <div>
                <div class="flex justify-between items-center text-[10px] font-mono text-slate-300 mb-1">
                    <span class="flex items-center gap-1 text-amber-300 font-bold">
                        <span>⚡️</span> <span id="current-xp-val">45</span> XP
                    </span>
                    <span class="text-slate-400">Target: <span id="goal-xp-val">60</span> XP</span>
                </div>
                <div class="relative w-full h-2.5 bg-[#1b202e] rounded-full overflow-hidden shimmer-bar border border-[#242c3d]">
                    <div id="xp-progress-bar"
                         class="h-full bg-gradient-to-r from-amber-400 via-orange-500 to-duo-green rounded-full transition-all duration-700 ease-out"
                         style="width: 75%"></div>
                </div>
                <div class="flex justify-between items-center text-[9px] font-mono text-slate-500 mt-1.5">
                    <span id="user-rank-title" class="font-bold text-slate-400">Lvl 3: Focus Archer</span>
                    <span id="daily-status-text" class="text-amber-400/90 font-medium">15 XP to Goal</span>
                </div>
            </div>

            <!-- Mystery Daily Reward Chest Button -->
            <button type="button" onclick="openMysteryChest()"
                    class="mt-3 w-full py-1.5 px-2.5 rounded-xl duo-btn-card border border-[#273045] flex items-center justify-between text-xs transition group">
                <span class="flex items-center gap-1.5 text-[11px] font-mono text-amber-300 font-bold">
                    <span class="text-sm animate-chest">🎁</span>
                    <span>Daily Mystery Chest</span>
                </span>
                <span class="text-[10px] font-mono text-slate-400 group-hover:text-amber-300 font-semibold transition">Claim →</span>
            </button>
        </div>

        <!-- Duolingo Daily Quests Widget -->
        <div class="mb-4 p-3 rounded-2xl bg-[#0e121b] border border-[#1d2433]">
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono text-[10px] uppercase tracking-wider text-slate-400 font-bold flex items-center gap-1">
                    <span>🎯</span> Daily Quests
                </span>
                <span class="font-mono text-[9px] text-emerald-400 font-bold" id="quests-completed-count">1/3 Done</span>
            </div>

            <!-- Quest List -->
            <div class="space-y-1.5 text-xs font-mono">
                <!-- Quest 1 -->
                <div class="p-1.5 rounded-lg bg-[#141926] border border-[#1f283d] flex items-center justify-between">
                    <div class="min-w-0 pr-1">
                        <p class="text-[10px] font-semibold text-slate-200 truncate">Finish 1 high-pri task</p>
                        <p class="text-[9px] text-amber-400">+25 XP</p>
                    </div>
                    <button type="button" onclick="claimQuest(1, 25, this)" id="quest-btn-1"
                            class="px-2 py-0.5 text-[9px] font-bold rounded bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 hover:bg-emerald-500 hover:text-slate-950 transition active:scale-95">
                        Claim
                    </button>
                </div>

                <!-- Quest 2 -->
                <div class="p-1.5 rounded-lg bg-[#141926] border border-[#1f283d] flex items-center justify-between">
                    <div class="min-w-0 pr-1">
                        <p class="text-[10px] font-semibold text-slate-200 truncate">Hit a 2x Combo streak</p>
                        <p class="text-[9px] text-amber-400">+20 XP</p>
                    </div>
                    <span class="text-[9px] text-slate-500 font-mono px-1.5 py-0.5">In Progress</span>
                </div>
            </div>
        </div>

        <!-- Primary Views -->
        <div class="mb-5">
            <p class="font-mono text-[10px] uppercase tracking-widest text-slate-500 mb-1 px-2.5 font-bold">Views</p>
            <nav class="space-y-1 text-xs font-medium">
                
                <!-- All Tasks -->
                <a href="{{ route('todos.index', ['filter' => 'all', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'bg-[#181e2b] text-white font-bold border border-[#273045] shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                        <span>All Tasks</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'bg-[#222b3d] text-indigo-300 font-bold' : 'text-slate-500' }}">
                        {{ $totalCount }}
                    </span>
                </a>

                <!-- Due Today -->
                <a href="{{ route('todos.index', ['filter' => 'today', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'today' ? 'bg-[#181e2b] text-white font-bold border border-[#273045] shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'today' ? 'text-amber-400' : 'text-amber-500/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        <span>Due Today</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'today' ? 'bg-amber-500/20 text-amber-300 font-bold' : 'text-slate-500' }}">
                        {{ $todayCount }}
                    </span>
                </a>

                <!-- Active -->
                <a href="{{ route('todos.index', ['filter' => 'active', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'active' ? 'bg-[#181e2b] text-white font-bold border border-[#273045] shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'active' ? 'text-sky-400' : 'text-sky-500/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>In Progress</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'active' ? 'bg-sky-500/20 text-sky-300 font-bold' : 'text-slate-500' }}">
                        {{ $remainingCount }}
                    </span>
                </a>

                <!-- Important -->
                <a href="{{ route('todos.index', ['filter' => 'important', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'important' ? 'bg-[#181e2b] text-white font-bold border border-[#273045] shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'important' ? 'text-rose-400' : 'text-rose-500/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <span>High Priority</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'important' ? 'bg-rose-500/20 text-rose-300 font-bold' : 'text-slate-500' }}">
                        {{ $importantCount }}
                    </span>
                </a>

                <!-- Completed -->
                <a href="{{ route('todos.index', ['filter' => 'done', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-xl transition-all {{ $filter === 'done' ? 'bg-[#181e2b] text-white font-bold border border-[#273045] shadow-xs' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'done' ? 'text-duo-green' : 'text-emerald-500/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Completed</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'done' ? 'bg-emerald-500/20 text-emerald-300 font-bold' : 'text-slate-500' }}">
                        {{ $completedCount }}
                    </span>
                </a>
            </nav>
        </div>

        <!-- Tags / Categories -->
        @if($categories->isNotEmpty())
            <div class="mb-5 pt-3 border-t border-[#181d29]">
                <p class="font-mono text-[10px] uppercase tracking-widest text-slate-500 mb-1.5 px-2.5 font-bold">Tags</p>
                <div class="space-y-0.5 text-xs font-medium">
                    @foreach($categories as $cat)
                        <a href="{{ route('todos.index', ['category' => $cat->category, 'sort' => $sort]) }}"
                           class="flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all {{ $category === $cat->category ? 'bg-[#181e2b] text-white font-bold border border-[#273045]' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                            <span class="font-mono text-[11px] text-slate-300">#{{ $cat->category }}</span>
                            <span class="font-mono text-[10px] text-slate-500">{{ $cat->count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Interactive Animated Mascot Companion Widget (Duo-Fay the Owl) -->
        <div class="mt-auto pt-3 border-t border-[#181d29] px-1 relative">
            
            <!-- Speech Bubble that dynamically pops up -->
            <div id="mascot-speech-bubble" class="hidden mb-2 bg-[#171d2b] border border-duo-green/40 text-slate-100 text-[11px] font-medium p-2.5 rounded-xl shadow-xl relative animate-bubble-pop">
                <span id="mascot-quote-text">Let's keep the streak blazing! 🔥</span>
                <div class="absolute -bottom-1.5 left-6 w-3 h-3 bg-[#171d2b] border-r border-b border-duo-green/40 transform rotate-45"></div>
            </div>

            <!-- Clickable Vector Owl Character -->
            <div onclick="petMascot(event)" id="mascot-card"
                 class="cursor-pointer group flex items-center gap-3 p-2.5 rounded-2xl bg-[#121622] hover:bg-[#181f2e] border border-[#20273a] hover:border-duo-green/40 transition-all select-none shadow-xs active:scale-95 relative">
                
                <!-- SVG Owl Mascot with animated eyes and wings -->
                <div id="mascot-avatar" class="w-11 h-11 shrink-0 relative animate-mascot">
                    <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-md">
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
                        <g class="mascot-eye">
                            <circle cx="38" cy="46" r="6.5" fill="#1b212f"/>
                            <circle cx="36" cy="44" r="2.5" fill="#ffffff"/>
                        </g>
                        <!-- Big Eye Right -->
                        <circle cx="63" cy="46" r="13" fill="#ffffff"/>
                        <g class="mascot-eye">
                            <circle cx="62" cy="46" r="6.5" fill="#1b212f"/>
                            <circle cx="60" cy="44" r="2.5" fill="#ffffff"/>
                        </g>
                        <!-- Beak -->
                        <polygon points="46,52 54,52 50,62" fill="#ff9600"/>
                        <!-- Feet -->
                        <ellipse cx="40" cy="91" rx="6" ry="3" fill="#ff9600"/>
                        <ellipse cx="60" cy="91" rx="6" ry="3" fill="#ff9600"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-200 group-hover:text-duo-green transition flex items-center gap-1">
                        <span>Duo-Fay</span>
                        <span class="text-[10px] text-amber-400">⚡️</span>
                    </p>
                    <p class="font-mono text-[9px] text-slate-400 mt-0.5 truncate">Tap me for motivation!</p>
                </div>
            </div>
        </div>

    </aside>

    <!-- Main Workspace Stage -->
    <main class="flex-1 min-w-0 p-5 sm:p-8 lg:p-10 max-w-5xl mx-auto w-full flex flex-col justify-between z-10 relative">

        <div>
            <!-- Top View Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 mb-6 border-b border-[#181d29]">
                <div>
                    <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white flex items-center gap-2.5">
                        @if($filter === 'today')
                            <span>Due Today</span>
                            <span class="text-amber-400 text-lg">☀️</span>
                        @elseif($filter === 'important')
                            <span>Important Tasks</span>
                            <span class="text-rose-400 text-lg">⚡️</span>
                        @elseif($filter === 'active')
                            <span>In Progress</span>
                            <span class="text-sky-400 text-lg">🎯</span>
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
                    <p class="font-mono text-[11px] text-slate-500 mt-0.5">
                        {{ now()->translatedFormat('l, M j, Y') }} • Keep crushing goals!
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
                            <svg class="w-3.5 h-3.5 text-slate-500 absolute left-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Filter issues… (/)" id="search-input"
                                   class="pl-8 pr-7 py-1.5 font-mono text-xs bg-[#10131a] border border-[#1e2433] rounded-xl text-slate-200 placeholder:text-slate-600 focus:outline-none focus:border-indigo-500/80 focus:ring-1 focus:ring-indigo-500/30 transition-all w-36 sm:w-48 focus:w-56">
                            @if($search)
                                <a href="{{ route('todos.index', ['filter' => $filter, 'priority' => $priority, 'category' => $category, 'sort' => $sort]) }}"
                                   class="absolute right-2.5 text-slate-500 hover:text-slate-300 text-xs">✕</a>
                            @endif
                        </div>
                    </form>

                    <form action="{{ route('todos.index') }}" method="GET">
                        <input type="hidden" name="filter" value="{{ $filter }}">
                        <input type="hidden" name="priority" value="{{ $priority }}">
                        <input type="hidden" name="category" value="{{ $category }}">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <select name="sort" onchange="this.form.submit()"
                                class="font-mono text-xs bg-[#10131a] border border-[#1e2433] rounded-xl px-2.5 py-1.5 text-slate-400 hover:text-slate-200 outline-none cursor-pointer focus:border-indigo-500/80">
                            <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Recent</option>
                            <option value="due_date" {{ $sort === 'due_date' ? 'selected' : '' }}>Due Date</option>
                            <option value="priority" {{ $sort === 'priority' ? 'selected' : '' }}>Priority</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Flash Notification -->
            @if(session('success'))
                <div id="flash-banner" class="mb-5 flex items-center justify-between bg-[#121824] border border-duo-green/40 text-emerald-300 rounded-xl px-3.5 py-2.5 text-xs font-mono shadow-xs transition-all duration-300">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-duo-green animate-ping"></span>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="document.getElementById('flash-banner').remove()" class="text-emerald-400/60 hover:text-emerald-300 font-bold ml-3">✕</button>
                </div>
            @endif

            <!-- High-Precision Metric Strip with Shimmer & XP Rate -->
            <div class="bg-[#0e1118] border border-[#1a1f2c] rounded-2xl px-4 py-3 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-4 text-slate-400 font-mono text-[11px]">
                    <span class="text-slate-200 font-bold">{{ $totalCount }} total</span>
                    <span class="text-slate-600">•</span>
                    <span class="text-amber-400 font-bold">{{ $remainingCount }} active</span>
                    <span class="text-slate-600">•</span>
                    <span class="text-emerald-400 font-bold">{{ $completedCount }} completed</span>
                </div>

                <div class="flex items-center gap-3">
                    <span class="font-mono text-[10px] text-slate-400">Progress:</span>
                    <div class="relative w-36 bg-[#161a24] h-2.5 rounded-full overflow-hidden shimmer-bar border border-[#202738]">
                        <div class="bg-gradient-to-r from-indigo-500 via-duo-blue to-duo-green h-full rounded-full transition-all duration-700 ease-out"
                             style="width: {{ $completionPercentage }}%"></div>
                    </div>
                    <span class="font-mono text-[10px] text-slate-200 font-extrabold">{{ $completionPercentage }}%</span>
                </div>
            </div>

            <!-- Duolingo-Tactile Command Bar (3D Push Button) -->
            <div class="bg-[#0e1118] border border-[#1e2433] hover:border-[#2d364d] focus-within:border-indigo-500/70 focus-within:ring-1 focus-within:ring-indigo-500/30 rounded-2xl p-3 mb-6 transition-all shadow-xs">
                <form action="{{ route('todos.store') }}" method="POST" id="add-task-form" onsubmit="playTaskAddSound()">
                    @csrf
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="hidden" name="filter_priority" value="{{ $priority }}">
                    <input type="hidden" name="filter_category" value="{{ $category }}">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="sort" value="{{ $sort }}">

                    <div class="flex items-center gap-2">
                        <span class="text-duo-green text-base font-mono font-bold select-none pl-1">+</span>
                        <input type="text" name="title" id="task-title-input" placeholder="Create new task… (press Return to save)"
                               value="{{ old('title') }}" required autofocus
                               class="flex-1 text-sm bg-transparent placeholder:text-slate-600 text-white outline-none">
                        
                        <!-- Tactile 3D Push Button -->
                        <button type="submit" class="duo-btn-green text-slate-950 font-extrabold text-xs px-4 py-2 rounded-xl flex items-center gap-1.5 shadow-sm">
                            <span>Add</span>
                            <kbd class="font-mono text-[10px] opacity-75">↵</kbd>
                        </button>
                    </div>

                    @error('title')
                        <p class="text-xs text-rose-400 font-mono mt-1 pl-4">{{ $message }}</p>
                    @enderror

                    <!-- Quick Metadata Controls -->
                    <div class="flex flex-wrap items-center gap-2.5 mt-2.5 pt-2.5 border-t border-[#171b26] text-xs pl-4 font-mono">
                        
                        <!-- Priority -->
                        <div class="flex items-center gap-1 text-[11px] text-slate-400">
                            <span class="text-slate-600">pri:</span>
                            <select name="priority" id="task-priority-select" class="bg-[#121620] border border-[#1e2433] rounded-lg px-2 py-0.5 text-slate-300 outline-none focus:border-indigo-500 cursor-pointer">
                                <option value="low">Low (I)</option>
                                <option value="medium" selected>Medium (II)</option>
                                <option value="high">High (III)</option>
                            </select>
                        </div>

                        <!-- Due Date -->
                        <div class="flex items-center gap-1 text-[11px] text-slate-400">
                            <span class="text-slate-600">due:</span>
                            <input type="date" name="due_date" value="{{ old('due_date') }}"
                                   class="bg-[#121620] border border-[#1e2433] rounded-lg px-1.5 py-0.5 text-slate-300 outline-none focus:border-indigo-500 cursor-pointer">
                        </div>

                        <!-- Tag -->
                        <div class="flex items-center gap-1 text-[11px] text-slate-400">
                            <span class="text-slate-600">tag:</span>
                            <input type="text" name="category" placeholder="e.g. Core" value="{{ old('category') }}"
                                   class="bg-[#121620] border border-[#1e2433] rounded-lg px-2 py-0.5 text-slate-300 outline-none focus:border-indigo-500 w-24">
                        </div>

                        <!-- Notes toggle -->
                        <button type="button" onclick="document.getElementById('notes-field').classList.toggle('hidden')" class="text-[11px] text-slate-500 hover:text-slate-300 ml-auto transition">
                            + description
                        </button>
                    </div>

                    <!-- Expandable Context Notes -->
                    <div id="notes-field" class="hidden mt-2.5 pl-4">
                        <textarea name="description" rows="2" placeholder="Task notes, links, or context…"
                                  class="w-full text-xs font-mono bg-[#121620] border border-[#1e2433] rounded-xl p-2.5 text-slate-300 outline-none focus:border-indigo-500"></textarea>
                    </div>
                </form>
            </div>

            <!-- Task List Table / Rows -->
            <div class="space-y-2 mb-6" id="tasks-container">
                @if($todos->isEmpty())
                    <div class="text-center py-16 px-4 bg-[#0e1118] border border-[#181d29] rounded-2xl">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-[#141822] border border-[#1e2433] flex items-center justify-center text-duo-green font-mono text-2xl animate-bounce">
                            ✓
                        </div>
                        <h3 class="text-sm font-bold text-white mb-1">All Clear & Tidy!</h3>
                        <p class="text-xs font-mono text-slate-400">
                            @if($filter === 'done')
                                No completed tasks yet. Tap a circle to finish one!
                            @elseif($remainingCount === 0 && $totalCount > 0)
                                All tasks resolved! Daily streak fully defended. 🔥
                            @elseif($search)
                                No items match query "{{ $search }}".
                            @else
                                No tasks registered in this view.
                            @endif
                        </p>
                    </div>
                @else
                    @foreach($todos as $todo)
                        <div class="task-card group bg-[#0e1118] border border-[#1a1f2c] hover:border-[#2b354d] rounded-2xl p-3.5" id="todo-row-{{ $todo->id }}">
                            
                            <!-- Row Content -->
                            <div class="flex items-start gap-3.5" id="view-mode-{{ $todo->id }}">
                                
                                <!-- Bouncy Tactile Checkbox Toggle -->
                                <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="pt-0.5 shrink-0"
                                      onsubmit="handleTaskToggle(event, {{ $todo->id }}, {{ $todo->completed ? 'true' : 'false' }}, '{{ $todo->priority }}')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                    <input type="hidden" name="filter_priority" value="{{ $priority }}">
                                    <input type="hidden" name="filter_category" value="{{ $category }}">
                                    <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">

                                    <button type="submit" id="check-btn-{{ $todo->id }}"
                                            class="checkbox-bounce w-5 h-5 rounded-md border flex items-center justify-center cursor-pointer {{ $todo->completed ? 'bg-duo-green border-duo-green text-slate-950 font-bold shadow-xs' : 'border-[#2c3547] hover:border-duo-green bg-[#121620] text-transparent' }}">
                                        <svg class="w-3.5 h-3.5 fill-current stroke-current" stroke-width="2.5" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Title, Tags & Indicators -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        
                                        <!-- Priority Pills -->
                                        @if($todo->priority === 'high')
                                            <span class="font-mono text-[9px] px-1.5 py-0.2 rounded bg-rose-500/10 text-rose-400 border border-rose-500/30 font-bold tracking-tight" title="High Priority (+25 XP)">HIGH</span>
                                        @elseif($todo->priority === 'medium')
                                            <span class="font-mono text-[9px] px-1.5 py-0.2 rounded bg-amber-500/10 text-amber-400 border border-amber-500/30 font-bold tracking-tight" title="Medium Priority (+15 XP)">MED</span>
                                        @else
                                            <span class="font-mono text-[9px] px-1.5 py-0.2 rounded bg-slate-500/10 text-slate-400 border border-slate-500/20 font-medium tracking-tight" title="Low Priority (+10 XP)">LOW</span>
                                        @endif

                                        <span class="text-sm font-semibold tracking-tight break-words {{ $todo->completed ? 'task-done' : 'text-slate-100' }}">
                                            {{ $todo->title }}
                                        </span>

                                        <!-- Tag Pill -->
                                        @if($todo->category)
                                            <a href="{{ route('todos.index', ['category' => $todo->category, 'sort' => $sort]) }}"
                                               class="font-mono text-[10px] text-slate-400 hover:text-slate-200 bg-[#141822] border border-[#1e2433] px-1.5 py-0.2 rounded-md transition hover:scale-105">
                                                #{{ $todo->category }}
                                            </a>
                                        @endif

                                        <!-- Due Date Badge -->
                                        @if($todo->due_date)
                                            <span class="font-mono text-[10px] {{ $todo->isOverdue() ? 'text-rose-400 font-bold' : ($todo->isDueToday() ? 'text-amber-300 font-bold' : 'text-slate-500') }}">
                                                {{ $todo->isDueToday() ? 'Today' : ($todo->isOverdue() ? 'Overdue' : $todo->due_date->format('M j')) }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($todo->description)
                                        <p class="text-xs text-slate-500 mt-1 line-clamp-1 font-mono {{ $todo->completed ? 'task-done' : '' }}">
                                            {{ $todo->description }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Actions Toolbar on Hover -->
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1 text-slate-500">
                                    <button type="button" onclick="showEditMode({{ $todo->id }})" title="Edit"
                                            class="p-1.5 hover:text-slate-200 hover:bg-[#1a202c] rounded-lg transition-transform active:scale-90">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Delete task?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="filter" value="{{ $filter }}">
                                        <input type="hidden" name="filter_priority" value="{{ $priority }}">
                                        <input type="hidden" name="filter_category" value="{{ $category }}">
                                        <input type="hidden" name="search" value="{{ $search }}">
                                        <input type="hidden" name="sort" value="{{ $sort }}">

                                        <button type="submit" title="Delete" class="p-1.5 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-transform active:scale-90">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <!-- Inline Edit Mode Panel -->
                            <div id="edit-mode-{{ $todo->id }}" class="hidden pt-2">
                                <form action="{{ route('todos.update', $todo) }}" method="POST" class="space-y-2.5 bg-[#121620] border border-[#202738] p-3 rounded-xl">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                    <input type="hidden" name="filter_priority" value="{{ $priority }}">
                                    <input type="hidden" name="filter_category" value="{{ $category }}">
                                    <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">

                                    <input type="text" name="title" value="{{ $todo->title }}" required
                                           class="w-full text-xs font-semibold rounded-lg bg-[#0b0d13] border border-[#202738] p-2 text-white outline-none focus:border-indigo-500">

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 font-mono text-xs">
                                        <select name="priority" class="bg-[#0b0d13] border border-[#202738] rounded-lg p-1.5 text-slate-300 outline-none focus:border-indigo-500">
                                            <option value="low" {{ $todo->priority === 'low' ? 'selected' : '' }}>Low (I)</option>
                                            <option value="medium" {{ $todo->priority === 'medium' ? 'selected' : '' }}>Medium (II)</option>
                                            <option value="high" {{ $todo->priority === 'high' ? 'selected' : '' }}>High (III)</option>
                                        </select>

                                        <input type="date" name="due_date" value="{{ $todo->due_date ? $todo->due_date->format('Y-m-d') : '' }}"
                                               class="bg-[#0b0d13] border border-[#202738] rounded-lg p-1.5 text-slate-300 outline-none focus:border-indigo-500">

                                        <input type="text" name="category" value="{{ $todo->category }}" placeholder="Tag"
                                               class="bg-[#0b0d13] border border-[#202738] rounded-lg p-1.5 text-slate-300 outline-none focus:border-indigo-500">
                                    </div>

                                    <textarea name="description" rows="2" placeholder="Notes…" class="w-full font-mono text-xs bg-[#0b0d13] border border-[#202738] rounded-lg p-2 text-slate-300 outline-none focus:border-indigo-500">{{ $todo->description }}</textarea>

                                    <div class="flex items-center justify-end gap-2 pt-1 text-xs">
                                        <button type="button" onclick="hideEditMode({{ $todo->id }})" class="text-slate-400 hover:text-slate-200 px-2 py-1 font-mono">
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

            <!-- Bottom Productivity Actions -->
            <div class="flex items-center justify-between text-xs text-slate-500 pt-3 border-t border-[#181d29] font-mono">
                <span>{{ $remainingCount }} active pending</span>

                <div class="flex items-center gap-3">
                    @if($remainingCount > 0)
                        <form action="{{ route('todos.markAllCompleted') }}" method="POST">
                            @csrf
                            <input type="hidden" name="filter" value="{{ $filter }}">
                            <input type="hidden" name="filter_priority" value="{{ $priority }}">
                            <input type="hidden" name="filter_category" value="{{ $category }}">
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <button type="submit" onclick="triggerMegaConfetti()" class="hover:text-duo-green font-semibold transition-colors">Mark all done</button>
                        </form>
                    @endif

                    @if($completedCount > 0)
                        <form action="{{ route('todos.clearCompleted') }}" method="POST" onsubmit="return confirm('Clear completed tasks?');">
                            @csrf
                            <input type="hidden" name="filter" value="{{ $filter }}">
                            <input type="hidden" name="filter_priority" value="{{ $priority }}">
                            <input type="hidden" name="filter_category" value="{{ $category }}">
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <button type="submit" class="hover:text-rose-400 font-semibold transition-colors">Clear completed</button>
                        </form>
                    @endif
                </div>
            </div>

        </div>

        <!-- Subtle Footer -->
        <footer class="mt-8 text-center font-mono text-[10px] text-slate-600 flex items-center justify-center gap-3">
            <span>Fay Tasks • Gamified Task Dashboard</span>
            <span>•</span>
            <button type="button" onclick="toggleShortcutsModal()" class="hover:text-slate-400 underline">Shortcuts (?)</button>
        </footer>

    </main>

    <!-- Daily Mystery Chest Modal Overlay (Duolingo Style Surprise) -->
    <div id="chest-modal" class="hidden fixed inset-0 z-50 bg-black/75 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-[#121622] border border-[#2a344a] rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl relative animate-combo-burst">
            <div class="w-16 h-16 mx-auto mb-3 text-5xl animate-chest">
                🎁
            </div>
            <h3 class="text-lg font-extrabold text-white mb-1">Daily Reward Unlocked!</h3>
            <p class="text-xs text-slate-400 mb-4" id="chest-reward-message">
                You earned bonus XP for keeping your streak alive!
            </p>
            <div class="font-mono text-2xl font-black text-amber-400 mb-6 tracking-tight">
                ⚡️ +50 BONUS XP
            </div>
            <button type="button" onclick="closeMysteryChest()"
                    class="duo-btn-green w-full py-3 rounded-2xl text-slate-950 font-black text-xs uppercase tracking-wider shadow-md">
                Claim & Keep Crushing! 🚀
            </button>
        </div>
    </div>

    <!-- Keyboard Shortcuts Modal -->
    <div id="shortcuts-modal" class="hidden fixed inset-0 z-50 bg-black/75 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-[#121622] border border-[#2a344a] rounded-3xl max-w-md w-full p-6 shadow-2xl relative">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-[#1f283d]">
                <h3 class="text-sm font-bold text-white flex items-center gap-2">
                    <span>⚡️</span> Keyboard Shortcuts
                </h3>
                <button type="button" onclick="toggleShortcutsModal()" class="text-slate-500 hover:text-white font-mono text-sm">✕</button>
            </div>
            <div class="space-y-2.5 font-mono text-xs">
                <div class="flex justify-between items-center py-1">
                    <span class="text-slate-300">New Task Focus</span>
                    <kbd class="px-2 py-0.5 rounded bg-[#1a202d] border border-[#2d374d] text-slate-200">N</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span class="text-slate-300">Search / Filter</span>
                    <kbd class="px-2 py-0.5 rounded bg-[#1a202d] border border-[#2d374d] text-slate-200">/</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span class="text-slate-300">Toggle Audio</span>
                    <kbd class="px-2 py-0.5 rounded bg-[#1a202d] border border-[#2d374d] text-slate-200">M</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span class="text-slate-300">Open Mystery Chest</span>
                    <kbd class="px-2 py-0.5 rounded bg-[#1a202d] border border-[#2d374d] text-slate-200">C</kbd>
                </div>
                <div class="flex justify-between items-center py-1">
                    <span class="text-slate-300">Pet Mascot</span>
                    <kbd class="px-2 py-0.5 rounded bg-[#1a202d] border border-[#2d374d] text-slate-200">P</kbd>
                </div>
            </div>
            <button type="button" onclick="toggleShortcutsModal()" class="mt-5 w-full duo-btn-card py-2 rounded-xl text-slate-300 font-bold text-xs">
                Got it
            </button>
        </div>
    </div>

    <!-- Web Audio Synthesizer, Mascot Quotes & Duolingo Animations Scripts -->
    <script>
        // Web Audio Synthesizer
        let audioCtx = null;
        let isAudioEnabled = localStorage.getItem('fay_audio_enabled') !== 'false';

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

        // Duolingo Signature Major Chime on Task Complete (with combo pitch escalation!)
        function playTaskCompleteSound(xp, combo) {
            if (!isAudioEnabled) return;
            const ctx = getAudioContext();
            if (!ctx) return;

            // Pitch climbs higher as combo increases!
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

        // Soft Pop Sound on Task Add
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

        // Confetti Particle Physics Burst
        function triggerConfetti(x, y) {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 50,
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
                    particleCount: 150,
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
                badge.innerHTML = `<span>⚡️</span> +${xp} XP <span class="text-[10px] text-indigo-900 bg-white/40 px-1 rounded font-black">${combo}x!</span>`;
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

        // Interactive Mascot Quotes & Behavior
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

            // Trigger excited cheer animation
            if (avatar) {
                avatar.classList.remove('animate-mascot-cheer');
                void avatar.offsetWidth; // force reflow
                avatar.classList.add('animate-mascot-cheer');
            }

            // Show speech bubble
            if (bubble && quoteEl) {
                const randomQuote = mascotQuotes[Math.floor(Math.random() * mascotQuotes.length)];
                quoteEl.textContent = randomQuote;
                bubble.classList.remove('hidden');
                setTimeout(() => bubble.classList.add('hidden'), 3500);
            }

            // Spawn floating hearts
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
            const modal = document.getElementById('chest-modal');
            modal.classList.add('hidden');
        }

        // Daily Quest Claim
        function claimQuest(questId, xp, btn) {
            btn.textContent = 'Claimed ✓';
            btn.classList.remove('bg-emerald-500/20', 'text-emerald-300', 'border-emerald-500/40', 'hover:bg-emerald-500');
            btn.classList.add('bg-slate-700/40', 'text-slate-400', 'border-transparent', 'cursor-default');
            btn.disabled = true;

            triggerConfetti();
            playFanfareSound();
            addXP(xp);

            const countEl = document.getElementById('quests-completed-count');
            if (countEl) countEl.textContent = '2/3 Done';
        }

        // Keyboard Shortcuts Modal Toggle
        function toggleShortcutsModal() {
            const modal = document.getElementById('shortcuts-modal');
            modal.classList.toggle('hidden');
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
        }

        function addXP(amount) {
            let xp = parseInt(localStorage.getItem('fay_xp') || '45', 10) + amount;
            localStorage.setItem('fay_xp', xp);
            initGamification();
        }

        // Intercept Task Toggle Form to trigger juicy animations before submitting!
        function handleTaskToggle(event, id, isCurrentlyDone, priority) {
            event.preventDefault();
            const form = event.target;
            const btn = document.getElementById('check-btn-' + id);

            if (!isCurrentlyDone) {
                const now = Date.now();
                // Check if completed within 25 seconds of last completion for combo!
                if (now - lastCompletionTime < 25000) {
                    comboCount++;
                } else {
                    comboCount = 1;
                }
                lastCompletionTime = now;

                // Determine XP with priority + combo multiplier
                let baseXP = priority === 'high' ? 25 : (priority === 'medium' ? 15 : 10);
                let awardedXP = baseXP * comboCount;

                // Screen coordinates for burst
                const rect = btn.getBoundingClientRect();
                const clickX = rect.left + rect.width / 2;
                const clickY = rect.top + rect.height / 2;

                // Bouncy checkmark pop
                btn.classList.add('scale-125', 'bg-duo-green', 'border-duo-green', 'text-slate-950');

                // Floating +XP badge
                spawnFloatingXP(clickX, clickY, awardedXP, comboCount);

                // Show combo banner if 2x or higher!
                if (comboCount > 1) {
                    showComboBanner(comboCount);
                }

                // Confetti particle burst
                triggerConfetti(clickX, clickY);

                // Major arpeggio chime with combo pitch escalation!
                playTaskCompleteSound(awardedXP, comboCount);

                // Award XP
                addXP(awardedXP);

                // Mascot jumps and cheers
                const avatar = document.getElementById('mascot-avatar');
                if (avatar) {
                    avatar.classList.add('animate-mascot-cheer');
                }

                // Submit after juicy micro-animation
                setTimeout(() => form.submit(), 280);
            } else {
                form.submit();
            }
        }

        // Edit row helper
        function showEditMode(id) {
            const v = document.getElementById('view-mode-' + id);
            const e = document.getElementById('edit-mode-' + id);
            if (v && e) {
                v.classList.add('hidden');
                e.classList.remove('hidden');
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

        // Global Keyboard Shortcuts
        document.addEventListener('keydown', (e) => {
            // Ignore if active inside an input or textarea
            if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
                if (e.key === 'Escape') {
                    document.activeElement.blur();
                }
                return;
            }

            if (e.key === 'n' || e.key === 'N') {
                e.preventDefault();
                const input = document.getElementById('task-title-input');
                if (input) input.focus();
            } else if (e.key === '/') {
                e.preventDefault();
                const search = document.getElementById('search-input');
                if (search) search.focus();
            } else if (e.key === 'm' || e.key === 'M') {
                toggleAudio();
            } else if (e.key === 'c' || e.key === 'C') {
                openMysteryChest();
            } else if (e.key === 'p' || e.key === 'P') {
                petMascot();
            } else if (e.key === '?') {
                toggleShortcutsModal();
            } else if (e.key === 'Escape') {
                closeMysteryChest();
                const sm = document.getElementById('shortcuts-modal');
                if (sm) sm.classList.add('hidden');
            }
        });

        // Init on DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            initGamification();

            const flash = document.getElementById('flash-banner');
            if (flash) {
                setTimeout(() => {
                    flash.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    flash.style.opacity = '0';
                    flash.style.transform = 'translateY(-4px)';
                    setTimeout(() => flash.remove(), 300);
                }, 3500);
            }
        });
    </script>
</body>
</html>
