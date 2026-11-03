<!DOCTYPE html>
<html lang="en" class="h-full dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fay Tasks — High-Performance Task Manager</title>
    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            800: '#151922',
                            850: '#11141b',
                            900: '#0b0d13',
                            950: '#07080c',
                            border: '#1e2433',
                            borderSubtle: '#161b26',
                            textMuted: '#64748b',
                            textDim: '#94a3b8',
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
        .task-done {
            text-decoration: line-through;
            color: #475569 !important;
        }
        /* Custom sleek scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #1e2433; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #2e374d; }
    </style>
</head>
<body class="min-h-full flex flex-col md:flex-row bg-[#08090d] text-slate-100 antialiased selection:bg-indigo-500/30 selection:text-indigo-200">

    <!-- Mobile Top Header -->
    <header class="md:hidden flex items-center justify-between bg-[#0e1017] border-b border-[#1a1f2c] px-4 py-3 sticky top-0 z-30">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-indigo-500/10 border border-indigo-500/30 flex items-center justify-center text-indigo-400 font-mono text-xs font-bold">
                F
            </div>
            <span class="font-semibold text-slate-100 text-sm tracking-tight">Fay Tasks</span>
        </div>
        <button type="button" onclick="document.getElementById('sidebar').classList.toggle('hidden')" class="p-1.5 text-slate-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </header>

    <!-- Sidebar Navigation (Linear / Raycast aesthetic) -->
    <aside id="sidebar" class="hidden md:flex flex-col w-64 lg:w-72 bg-[#0b0d13] border-r border-[#181d29] shrink-0 h-screen sticky top-0 p-4 select-none overflow-y-auto">
        
        <!-- Workspace Identification -->
        <div class="flex items-center justify-between px-2 py-2 mb-4 rounded-xl bg-[#12151e] border border-[#1b212f]">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white shadow-xs font-mono font-bold text-xs shrink-0">
                    F
                </div>
                <div class="min-w-0">
                    <h2 class="font-semibold text-xs text-slate-200 truncate leading-none">Fay Tasks</h2>
                    <p class="font-mono text-[10px] text-slate-500 mt-1 leading-none truncate">Personal Workspace</p>
                </div>
            </div>
            <span class="font-mono text-[9px] uppercase tracking-wider px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 font-medium">v1.0</span>
        </div>

        <!-- Primary Views -->
        <div class="mb-5">
            <p class="font-mono text-[10px] uppercase tracking-widest text-slate-500 mb-1 px-2.5 font-semibold">Views</p>
            <nav class="space-y-0.5 text-xs font-medium">
                
                <!-- All Tasks -->
                <a href="{{ route('todos.index', ['filter' => 'all', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'bg-[#181e2b] text-white font-semibold border border-[#273045]' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'text-indigo-400' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                        <span>All Tasks</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'bg-[#222b3d] text-indigo-300' : 'text-slate-500' }}">
                        {{ $totalCount }}
                    </span>
                </a>

                <!-- Due Today -->
                <a href="{{ route('todos.index', ['filter' => 'today', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all {{ $filter === 'today' ? 'bg-[#181e2b] text-white font-semibold border border-[#273045]' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'today' ? 'text-amber-400' : 'text-amber-500/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        <span>Due Today</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'today' ? 'bg-amber-500/20 text-amber-300' : 'text-slate-500' }}">
                        {{ $todayCount }}
                    </span>
                </a>

                <!-- Active -->
                <a href="{{ route('todos.index', ['filter' => 'active', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all {{ $filter === 'active' ? 'bg-[#181e2b] text-white font-semibold border border-[#273045]' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'active' ? 'text-sky-400' : 'text-sky-500/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>In Progress</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'active' ? 'bg-sky-500/20 text-sky-300' : 'text-slate-500' }}">
                        {{ $remainingCount }}
                    </span>
                </a>

                <!-- Important -->
                <a href="{{ route('todos.index', ['filter' => 'important', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all {{ $filter === 'important' ? 'bg-[#181e2b] text-white font-semibold border border-[#273045]' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'important' ? 'text-rose-400' : 'text-rose-500/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <span>High Priority</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'important' ? 'bg-rose-500/20 text-rose-300' : 'text-slate-500' }}">
                        {{ $importantCount }}
                    </span>
                </a>

                <!-- Completed -->
                <a href="{{ route('todos.index', ['filter' => 'done', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all {{ $filter === 'done' ? 'bg-[#181e2b] text-white font-semibold border border-[#273045]' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ $filter === 'done' ? 'text-emerald-400' : 'text-emerald-500/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Completed</span>
                    </div>
                    <span class="font-mono text-[10px] px-1.5 py-0.2 rounded {{ $filter === 'done' ? 'bg-emerald-500/20 text-emerald-300' : 'text-slate-500' }}">
                        {{ $completedCount }}
                    </span>
                </a>
            </nav>
        </div>

        <!-- Tags / Categories -->
        @if($categories->isNotEmpty())
            <div class="mb-5 pt-3 border-t border-[#181d29]">
                <p class="font-mono text-[10px] uppercase tracking-widest text-slate-500 mb-1.5 px-2.5 font-semibold">Tags</p>
                <div class="space-y-0.5 text-xs font-medium">
                    @foreach($categories as $cat)
                        <a href="{{ route('todos.index', ['category' => $cat->category, 'sort' => $sort]) }}"
                           class="flex items-center justify-between px-2.5 py-1.5 rounded-lg transition-all {{ $category === $cat->category ? 'bg-[#181e2b] text-white font-semibold border border-[#273045]' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                            <span class="font-mono text-[11px] text-slate-300">#{{ $cat->category }}</span>
                            <span class="font-mono text-[10px] text-slate-600">{{ $cat->count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Priority Filters -->
        <div class="mb-5 pt-3 border-t border-[#181d29]">
            <p class="font-mono text-[10px] uppercase tracking-widest text-slate-500 mb-1.5 px-2.5 font-semibold">Priority</p>
            <div class="space-y-0.5 text-xs font-medium">
                <a href="{{ route('todos.index', ['priority' => 'high', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1 rounded-lg transition-all {{ $priority === 'high' ? 'bg-rose-500/10 text-rose-300 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <span class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                        <span>High Priority</span>
                    </span>
                    <span class="font-mono text-[10px] text-slate-600">III</span>
                </a>
                <a href="{{ route('todos.index', ['priority' => 'medium', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1 rounded-lg transition-all {{ $priority === 'medium' ? 'bg-amber-500/10 text-amber-300 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <span class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        <span>Medium Priority</span>
                    </span>
                    <span class="font-mono text-[10px] text-slate-600">II</span>
                </a>
                <a href="{{ route('todos.index', ['priority' => 'low', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-2.5 py-1 rounded-lg transition-all {{ $priority === 'low' ? 'bg-emerald-500/10 text-emerald-300 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-[#121620]' }}">
                    <span class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>Low Priority</span>
                    </span>
                    <span class="font-mono text-[10px] text-slate-600">I</span>
                </a>
            </div>
        </div>

        <!-- System Architecture Footnote -->
        <div class="mt-auto pt-4 border-t border-[#181d29] text-[10px] font-mono text-slate-600 flex items-center justify-between px-1">
            <span class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>SQLite • Ready</span>
            </span>
            <span class="text-slate-700">PHP 8.5</span>
        </div>

    </aside>

    <!-- Main Workspace Stage -->
    <main class="flex-1 min-w-0 p-5 sm:p-8 lg:p-10 max-w-5xl mx-auto w-full flex flex-col justify-between">

        <div>
            <!-- Top Controls Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 mb-6 border-b border-[#181d29]">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white flex items-center gap-2.5">
                        @if($filter === 'today')
                            <span>Due Today</span>
                        @elseif($filter === 'important')
                            <span>Important Tasks</span>
                        @elseif($filter === 'active')
                            <span>In Progress</span>
                        @elseif($filter === 'done')
                            <span>Completed Tasks</span>
                        @elseif($category !== 'all')
                            <span>Tag: #{{ $category }}</span>
                        @elseif($priority !== 'all')
                            <span>{{ ucfirst($priority) }} Priority</span>
                        @else
                            <span>All Tasks</span>
                        @endif
                    </h1>
                    <p class="font-mono text-[11px] text-slate-500 mt-0.5">
                        {{ now()->translatedFormat('l, M j, Y') }}
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
                            <input type="text" name="search" value="{{ $search }}" placeholder="Filter issues…"
                                   class="pl-8 pr-7 py-1.5 font-mono text-xs bg-[#10131a] border border-[#1e2433] rounded-lg text-slate-200 placeholder:text-slate-600 focus:outline-none focus:border-indigo-500/80 transition-all w-36 sm:w-48 focus:w-56">
                            @if($search)
                                <a href="{{ route('todos.index', ['filter' => $filter, 'priority' => $priority, 'category' => $category, 'sort' => $sort]) }}"
                                   class="absolute right-2 text-slate-500 hover:text-slate-300 text-xs">✕</a>
                            @endif
                        </div>
                    </form>

                    <form action="{{ route('todos.index') }}" method="GET">
                        <input type="hidden" name="filter" value="{{ $filter }}">
                        <input type="hidden" name="priority" value="{{ $priority }}">
                        <input type="hidden" name="category" value="{{ $category }}">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <select name="sort" onchange="this.form.submit()"
                                class="font-mono text-xs bg-[#10131a] border border-[#1e2433] rounded-lg px-2.5 py-1.5 text-slate-400 hover:text-slate-200 outline-none cursor-pointer focus:border-indigo-500/80">
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
                <div id="flash-banner" class="mb-4 flex items-center justify-between bg-[#121824] border border-indigo-500/30 text-indigo-300 rounded-lg px-3.5 py-2 text-xs font-mono shadow-xs transition-all duration-300">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="document.getElementById('flash-banner').remove()" class="text-indigo-400/60 hover:text-indigo-300 font-bold ml-3">✕</button>
                </div>
            @endif

            <!-- High-Precision Metric Strip -->
            <div class="bg-[#0e1118] border border-[#1a1f2c] rounded-xl px-4 py-3 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-4 text-slate-400 font-mono text-[11px]">
                    <span class="text-slate-200 font-semibold">{{ $totalCount }} total</span>
                    <span class="text-slate-600">•</span>
                    <span class="text-amber-400 font-medium">{{ $remainingCount }} active</span>
                    <span class="text-slate-600">•</span>
                    <span class="text-emerald-400 font-medium">{{ $completedCount }} completed</span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-36 bg-[#161a24] h-1.5 rounded-full overflow-hidden">
                        <div class="bg-indigo-500 h-full rounded-full transition-all duration-500"
                             style="width: {{ $completionPercentage }}%"></div>
                    </div>
                    <span class="font-mono text-[10px] text-slate-400">{{ $completionPercentage }}%</span>
                </div>
            </div>

            <!-- Command-Bar Task Creation Input (Linear style) -->
            <div class="bg-[#0e1118] border border-[#1e2433] hover:border-[#2d364d] focus-within:border-indigo-500/70 focus-within:ring-1 focus-within:ring-indigo-500/30 rounded-xl p-3 mb-6 transition-all shadow-xs">
                <form action="{{ route('todos.store') }}" method="POST" id="add-task-form">
                    @csrf
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="hidden" name="filter_priority" value="{{ $priority }}">
                    <input type="hidden" name="filter_category" value="{{ $category }}">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="sort" value="{{ $sort }}">

                    <div class="flex items-center gap-2">
                        <span class="text-slate-500 text-sm font-mono select-none pl-1">+</span>
                        <input type="text" name="title" id="task-title-input" placeholder="Create task… (press Return to save)"
                               value="{{ old('title') }}" required autofocus
                               class="flex-1 text-sm bg-transparent placeholder:text-slate-600 text-white outline-none">
                        
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-xs px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1 shadow-xs">
                            <span>Add</span>
                            <kbd class="font-mono text-[10px] opacity-75">↵</kbd>
                        </button>
                    </div>

                    @error('title')
                        <p class="text-xs text-rose-400 font-mono mt-1 pl-4">{{ $message }}</p>
                    @enderror

                    <!-- Inline Quick Controls -->
                    <div class="flex flex-wrap items-center gap-2.5 mt-2.5 pt-2.5 border-t border-[#171b26] text-xs pl-4 font-mono">
                        
                        <!-- Priority -->
                        <div class="flex items-center gap-1 text-[11px] text-slate-400">
                            <span class="text-slate-600">pri:</span>
                            <select name="priority" class="bg-[#121620] border border-[#1e2433] rounded px-2 py-0.5 text-slate-300 outline-none focus:border-indigo-500">
                                <option value="low">Low (I)</option>
                                <option value="medium" selected>Medium (II)</option>
                                <option value="high">High (III)</option>
                            </select>
                        </div>

                        <!-- Due Date -->
                        <div class="flex items-center gap-1 text-[11px] text-slate-400">
                            <span class="text-slate-600">due:</span>
                            <input type="date" name="due_date" value="{{ old('due_date') }}"
                                   class="bg-[#121620] border border-[#1e2433] rounded px-1.5 py-0.5 text-slate-300 outline-none focus:border-indigo-500">
                        </div>

                        <!-- Tag -->
                        <div class="flex items-center gap-1 text-[11px] text-slate-400">
                            <span class="text-slate-600">tag:</span>
                            <input type="text" name="category" placeholder="e.g. Core" value="{{ old('category') }}"
                                   class="bg-[#121620] border border-[#1e2433] rounded px-2 py-0.5 text-slate-300 outline-none focus:border-indigo-500 w-24">
                        </div>

                        <!-- Notes link -->
                        <button type="button" onclick="document.getElementById('notes-field').classList.toggle('hidden')" class="text-[11px] text-slate-500 hover:text-slate-300 ml-auto transition">
                            + description
                        </button>
                    </div>

                    <!-- Expandable Context Notes -->
                    <div id="notes-field" class="hidden mt-2.5 pl-4">
                        <textarea name="description" rows="2" placeholder="Task notes, links, or context…"
                                  class="w-full text-xs font-mono bg-[#121620] border border-[#1e2433] rounded-lg p-2 text-slate-300 outline-none focus:border-indigo-500"></textarea>
                    </div>
                </form>
            </div>

            <!-- Task List Table / Rows -->
            <div class="space-y-1.5 mb-6">
                @if($todos->isEmpty())
                    <div class="text-center py-16 px-4 bg-[#0e1118] border border-[#181d29] rounded-xl">
                        <div class="w-10 h-10 mx-auto mb-2 rounded-xl bg-[#141822] border border-[#1e2433] flex items-center justify-center text-slate-600 font-mono">
                            ✓
                        </div>
                        <p class="text-xs font-mono text-slate-400">
                            @if($filter === 'done')
                                No completed tasks yet.
                            @elseif($remainingCount === 0 && $totalCount > 0)
                                All tasks resolved. Clear view ahead.
                            @elseif($search)
                                No items match query "{{ $search }}".
                            @else
                                No tasks registered in this view.
                            @endif
                        </p>
                    </div>
                @else
                    @foreach($todos as $todo)
                        <div class="group bg-[#0e1118] border border-[#1a1f2c] hover:border-[#273045] rounded-xl p-3 transition-all" id="todo-row-{{ $todo->id }}">
                            
                            <!-- Row Content -->
                            <div class="flex items-start gap-3" id="view-mode-{{ $todo->id }}">
                                
                                <!-- Custom Geometric Checkbox -->
                                <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="pt-0.5 shrink-0">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                    <input type="hidden" name="filter_priority" value="{{ $priority }}">
                                    <input type="hidden" name="filter_category" value="{{ $category }}">
                                    <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">

                                    <button type="submit"
                                            class="w-4 h-4 rounded-[4px] border transition-colors flex items-center justify-center cursor-pointer {{ $todo->completed ? 'bg-indigo-600 border-indigo-600 text-white' : 'border-[#2c3547] hover:border-slate-400 bg-[#121620] text-transparent' }}">
                                        <svg class="w-2.5 h-2.5 fill-current stroke-current" stroke-width="2.5" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Title, Tags & Indicators -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        
                                        <!-- Linear-Style Priority Bars -->
                                        @if($todo->priority === 'high')
                                            <span class="font-mono text-[10px] text-rose-400 font-bold tracking-tighter" title="High Priority">III</span>
                                        @elseif($todo->priority === 'medium')
                                            <span class="font-mono text-[10px] text-amber-400 font-semibold tracking-tighter" title="Medium Priority">II</span>
                                        @else
                                            <span class="font-mono text-[10px] text-slate-600 font-medium tracking-tighter" title="Low Priority">I</span>
                                        @endif

                                        <span class="text-sm font-medium tracking-tight break-words {{ $todo->completed ? 'task-done' : 'text-slate-100' }}">
                                            {{ $todo->title }}
                                        </span>

                                        <!-- Tag Pill -->
                                        @if($todo->category)
                                            <a href="{{ route('todos.index', ['category' => $todo->category, 'sort' => $sort]) }}"
                                               class="font-mono text-[10px] text-slate-400 hover:text-slate-200 bg-[#141822] border border-[#1e2433] px-1.5 py-0.2 rounded transition">
                                                #{{ $todo->category }}
                                            </a>
                                        @endif

                                        <!-- Due Date Badge -->
                                        @if($todo->due_date)
                                            <span class="font-mono text-[10px] {{ $todo->isOverdue() ? 'text-rose-400 font-semibold' : ($todo->isDueToday() ? 'text-amber-300 font-semibold' : 'text-slate-500') }}">
                                                {{ $todo->isDueToday() ? 'Today' : ($todo->isOverdue() ? 'Overdue' : $todo->due_date->format('M j')) }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($todo->description)
                                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-1 font-mono {{ $todo->completed ? 'task-done' : '' }}">
                                            {{ $todo->description }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Actions Menu on Hover -->
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1 text-slate-500">
                                    <button type="button" onclick="showEditMode({{ $todo->id }})" title="Edit"
                                            class="p-1 hover:text-slate-200 transition">
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

                                        <button type="submit" title="Delete" class="p-1 hover:text-rose-400 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <!-- Inline Edit Mode Panel -->
                            <div id="edit-mode-{{ $todo->id }}" class="hidden pt-2">
                                <form action="{{ route('todos.update', $todo) }}" method="POST" class="space-y-2.5 bg-[#121620] border border-[#202738] p-3 rounded-lg">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                    <input type="hidden" name="filter_priority" value="{{ $priority }}">
                                    <input type="hidden" name="filter_category" value="{{ $category }}">
                                    <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">

                                    <input type="text" name="title" value="{{ $todo->title }}" required
                                           class="w-full text-xs font-medium rounded bg-[#0b0d13] border border-[#202738] p-2 text-white outline-none focus:border-indigo-500">

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 font-mono text-xs">
                                        <select name="priority" class="bg-[#0b0d13] border border-[#202738] rounded p-1.5 text-slate-300 outline-none focus:border-indigo-500">
                                            <option value="low" {{ $todo->priority === 'low' ? 'selected' : '' }}>Low (I)</option>
                                            <option value="medium" {{ $todo->priority === 'medium' ? 'selected' : '' }}>Medium (II)</option>
                                            <option value="high" {{ $todo->priority === 'high' ? 'selected' : '' }}>High (III)</option>
                                        </select>

                                        <input type="date" name="due_date" value="{{ $todo->due_date ? $todo->due_date->format('Y-m-d') : '' }}"
                                               class="bg-[#0b0d13] border border-[#202738] rounded p-1.5 text-slate-300 outline-none focus:border-indigo-500">

                                        <input type="text" name="category" value="{{ $todo->category }}" placeholder="Tag"
                                               class="bg-[#0b0d13] border border-[#202738] rounded p-1.5 text-slate-300 outline-none focus:border-indigo-500">
                                    </div>

                                    <textarea name="description" rows="2" placeholder="Notes…" class="w-full font-mono text-xs bg-[#0b0d13] border border-[#202738] rounded p-2 text-slate-300 outline-none focus:border-indigo-500">{{ $todo->description }}</textarea>

                                    <div class="flex items-center justify-end gap-2 pt-1 text-xs">
                                        <button type="button" onclick="hideEditMode({{ $todo->id }})" class="text-slate-400 hover:text-slate-200 px-2 py-1">
                                            Cancel
                                        </button>
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium px-3 py-1 rounded transition-colors">
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
                            <button type="submit" class="hover:text-indigo-400 transition-colors">Mark all done</button>
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
                            <button type="submit" class="hover:text-rose-400 transition-colors">Clear completed</button>
                        </form>
                    @endif
                </div>
            </div>

        </div>

        <!-- Subtle Footer -->
        <footer class="mt-8 text-center font-mono text-[10px] text-slate-600">
            Fay Tasks • High-Precision Task Dashboard
        </footer>

    </main>

    <!-- Client Scripts -->
    <script>
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

        document.addEventListener('DOMContentLoaded', () => {
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
