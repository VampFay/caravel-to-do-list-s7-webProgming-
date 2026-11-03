<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fay Tasks — Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            500: '#0f172a',
                            600: '#020617',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "SF Pro Text", system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .task-done {
            text-decoration: line-through;
            color: #94a3b8 !important;
        }
    </style>
</head>
<body class="min-h-full bg-[#f8fafc] text-slate-800 antialiased flex flex-col md:flex-row">

    <!-- Mobile Header Bar -->
    <div class="md:hidden flex items-center justify-between bg-white border-b border-slate-200 px-4 py-3 sticky top-0 z-20">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-sm shadow-xs">
                F
            </div>
            <span class="font-bold text-slate-900 tracking-tight text-base">Fay Tasks</span>
        </div>
        <button type="button" onclick="document.getElementById('mobile-sidebar').classList.toggle('hidden')" class="p-1.5 text-slate-500 hover:text-slate-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <aside id="mobile-sidebar" class="hidden md:flex flex-col w-full md:w-64 lg:w-72 bg-white border-r border-slate-200/80 p-5 shrink-0 min-h-full md:min-h-screen sticky top-0 md:h-screen overflow-y-auto">
        
        <!-- App Brand Header -->
        <div class="flex items-center gap-3 pb-6 border-b border-slate-100">
            <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-base shadow-sm">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="min-w-0">
                <h2 class="font-bold text-slate-900 text-base tracking-tight leading-none">Fay Tasks</h2>
                <p class="text-[11px] text-slate-400 mt-1 font-medium">Personal Workspace</p>
            </div>
        </div>

        <!-- Quick Views Navigation -->
        <div class="py-5">
            <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-2 px-2.5">Views</p>
            <nav class="space-y-1 text-xs font-medium">
                
                <!-- All Tasks -->
                <a href="{{ route('todos.index', ['filter' => 'all', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'bg-slate-900 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'text-indigo-300' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span>All Tasks</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ $filter === 'all' && $priority === 'all' && $category === 'all' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-500' }}">
                        {{ $totalCount }}
                    </span>
                </a>

                <!-- Today -->
                <a href="{{ route('todos.index', ['filter' => 'today', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ $filter === 'today' ? 'bg-slate-900 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 {{ $filter === 'today' ? 'text-amber-300' : 'text-amber-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Due Today</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ $filter === 'today' ? 'bg-slate-800 text-white' : 'bg-amber-50 text-amber-700 font-semibold' }}">
                        {{ $todayCount }}
                    </span>
                </a>

                <!-- Active -->
                <a href="{{ route('todos.index', ['filter' => 'active', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ $filter === 'active' ? 'bg-slate-900 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 {{ $filter === 'active' ? 'text-sky-300' : 'text-sky-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Active</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ $filter === 'active' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-500' }}">
                        {{ $remainingCount }}
                    </span>
                </a>

                <!-- Important (High Priority) -->
                <a href="{{ route('todos.index', ['filter' => 'important', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ $filter === 'important' ? 'bg-slate-900 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 {{ $filter === 'important' ? 'text-rose-300' : 'text-rose-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                        <span>Important</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ $filter === 'important' ? 'bg-slate-800 text-white' : 'bg-rose-50 text-rose-700 font-semibold' }}">
                        {{ $importantCount }}
                    </span>
                </a>

                <!-- Completed -->
                <a href="{{ route('todos.index', ['filter' => 'done', 'sort' => $sort]) }}"
                   class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ $filter === 'done' ? 'bg-slate-900 text-white font-semibold shadow-xs' : 'text-slate-600 hover:bg-slate-100/70 hover:text-slate-900' }}">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 {{ $filter === 'done' ? 'text-emerald-300' : 'text-emerald-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Completed</span>
                    </div>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ $filter === 'done' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-500' }}">
                        {{ $completedCount }}
                    </span>
                </a>
            </nav>
        </div>

        <!-- Categories / Tags Section -->
        @if($categories->isNotEmpty())
            <div class="pt-4 pb-5 border-t border-slate-100">
                <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-2 px-2.5">Tags</p>
                <div class="space-y-0.5 text-xs">
                    @foreach($categories as $cat)
                        <a href="{{ route('todos.index', ['category' => $cat->category, 'sort' => $sort]) }}"
                           class="flex items-center justify-between px-3 py-1.5 rounded-lg transition {{ $category === $cat->category ? 'bg-slate-100 text-slate-900 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                            <span class="truncate">#{{ $cat->category }}</span>
                            <span class="text-[10px] text-slate-400 font-normal">{{ $cat->count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Sidebar Footer Status -->
        <div class="mt-auto pt-4 border-t border-slate-100 text-[11px] text-slate-400 flex items-center justify-between px-1">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>SQLite Connected</span>
            </span>
            <span class="font-mono text-[10px]">PHP 8.5</span>
        </div>

    </aside>

    <!-- Main Workspace Stage -->
    <main class="flex-1 min-w-0 p-5 sm:p-8 lg:p-10 max-w-5xl mx-auto w-full">

        <!-- Top Header & View Identity -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                    @if($filter === 'today')
                        Due Today
                    @elseif($filter === 'important')
                        Important Tasks
                    @elseif($filter === 'active')
                        Active Tasks
                    @elseif($filter === 'done')
                        Completed Tasks
                    @elseif($category !== 'all')
                        Tasks in #{{ $category }}
                    @elseif($priority !== 'all')
                        {{ ucfirst($priority) }} Priority Tasks
                    @else
                        All Tasks
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                    {{ now()->translatedFormat('l, F j, Y') }}
                </p>
            </div>

            <!-- Search & Sort Toolbar -->
            <div class="flex items-center gap-2 self-start sm:self-auto">
                <form action="{{ route('todos.index') }}" method="GET" class="relative">
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="hidden" name="priority" value="{{ $priority }}">
                    <input type="hidden" name="category" value="{{ $category }}">
                    <input type="hidden" name="sort" value="{{ $sort }}">

                    <div class="relative">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search…"
                               class="pl-9 pr-7 py-1.5 text-xs rounded-xl bg-white border border-slate-200 text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-slate-400 shadow-2xs w-36 sm:w-48 transition-all focus:w-56">
                        @if($search)
                            <a href="{{ route('todos.index', ['filter' => $filter, 'priority' => $priority, 'category' => $category, 'sort' => $sort]) }}"
                               class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs">✕</a>
                        @endif
                    </div>
                </form>

                <form action="{{ route('todos.index') }}" method="GET">
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="hidden" name="priority" value="{{ $priority }}">
                    <input type="hidden" name="category" value="{{ $category }}">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <select name="sort" onchange="this.form.submit()"
                            class="text-xs bg-white border border-slate-200 rounded-xl px-2.5 py-1.5 text-slate-700 outline-none focus:border-slate-400 shadow-2xs cursor-pointer">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Recent</option>
                        <option value="due_date" {{ $sort === 'due_date' ? 'selected' : '' }}>Due Date</option>
                        <option value="priority" {{ $sort === 'priority' ? 'selected' : '' }}>Priority</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Success Notification Banner -->
        @if(session('success'))
            <div id="flash-banner" class="mb-5 flex items-center justify-between bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-2.5 text-xs font-medium shadow-2xs transition-all duration-300">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('flash-banner').remove()" class="text-emerald-500 hover:text-emerald-700 font-bold ml-3">✕</button>
            </div>
        @endif

        <!-- Progress Overview Banner -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-2xs mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-sm">
                        {{ $completionPercentage }}%
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">
                            @if($remainingCount === 0 && $totalCount > 0)
                                All done! Great productivity today. 🎉
                            @elseif($remainingCount > 0)
                                {{ $remainingCount }} active {{ $remainingCount === 1 ? 'task' : 'tasks' }} remaining
                            @else
                                Ready to organize your tasks.
                            @endif
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ $completedCount }} completed out of {{ $totalCount }} total tasks
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs">
                    <span class="px-2.5 py-1 rounded-lg bg-slate-100 font-semibold text-slate-700">{{ $totalCount }} Total</span>
                    <span class="px-2.5 py-1 rounded-lg bg-amber-50 font-semibold text-amber-700">{{ $remainingCount }} Active</span>
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 font-semibold text-emerald-700">{{ $completedCount }} Done</span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-emerald-500 h-2 rounded-full transition-all duration-500 ease-out"
                     style="width: {{ $completionPercentage }}%"></div>
            </div>
        </div>

        <!-- Add Task Input Panel -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs p-4 mb-6">
            <form action="{{ route('todos.store') }}" method="POST" id="add-task-form">
                @csrf
                <input type="hidden" name="filter" value="{{ $filter }}">
                <input type="hidden" name="filter_priority" value="{{ $priority }}">
                <input type="hidden" name="filter_category" value="{{ $category }}">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="sort" value="{{ $sort }}">

                <!-- Main Input Row -->
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 rounded-full border border-slate-300 flex items-center justify-center text-slate-300 text-xs shrink-0 select-none">
                        +
                    </div>
                    <input type="text" name="title" id="task-title-input" placeholder="Add a new task (e.g. Prepare presentation slides)…"
                           value="{{ old('title') }}" required autofocus
                           class="flex-1 text-sm bg-transparent placeholder:text-slate-400 text-slate-900 outline-none">
                    
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-medium text-xs px-4 py-2 rounded-xl transition shadow-xs">
                        Add Task
                    </button>
                </div>

                @error('title')
                    <p class="text-xs text-rose-500 font-medium mt-2 pl-7">{{ $message }}</p>
                @enderror

                <!-- Direct Inline Attributes -->
                <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-slate-100 text-xs pl-7">
                    
                    <!-- Priority Selector -->
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400 font-medium text-[11px]">Priority:</span>
                        <select name="priority" class="text-xs bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-slate-700 outline-none focus:bg-white">
                            <option value="low">🟢 Low</option>
                            <option value="medium" selected>🟡 Medium</option>
                            <option value="high">🔴 High</option>
                        </select>
                    </div>

                    <!-- Due Date Picker -->
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400 font-medium text-[11px]">Due:</span>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                               class="text-xs bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-slate-700 outline-none focus:bg-white">
                    </div>

                    <!-- Category / Tag -->
                    <div class="flex items-center gap-1.5">
                        <span class="text-slate-400 font-medium text-[11px]">Tag:</span>
                        <input type="text" name="category" placeholder="e.g. Work" value="{{ old('category') }}"
                               class="text-xs bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-slate-700 outline-none focus:bg-white w-24">
                    </div>

                    <!-- Notes Toggle -->
                    <button type="button" onclick="document.getElementById('notes-box').classList.toggle('hidden')" class="text-slate-400 hover:text-slate-700 text-xs ml-auto">
                        + Add Notes
                    </button>
                </div>

                <!-- Expandable Notes Input -->
                <div id="notes-box" class="hidden mt-3 pl-7">
                    <textarea name="description" rows="2" placeholder="Add extra notes, context, or links…"
                              class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 outline-none focus:bg-white focus:border-slate-300"></textarea>
                </div>
            </form>
        </div>

        <!-- Task List Items -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs divide-y divide-slate-100 overflow-hidden mb-6">
            
            @if($todos->isEmpty())
                <div class="text-center py-16 px-4">
                    <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">
                        @if($filter === 'done')
                            No completed tasks yet.
                        @elseif($remainingCount === 0 && $totalCount > 0)
                            All caught up! Excellent work.
                        @elseif($search)
                            No results found for "{{ $search }}".
                        @else
                            No tasks in this view.
                        @endif
                    </h4>
                    <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">
                        @if($search)
                            Try clearing your search query or adjusting your filters.
                        @else
                            Use the quick-add bar above to create your next task.
                        @endif
                    </p>
                </div>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach($todos as $todo)
                        <li class="group p-4 transition-all hover:bg-slate-50/70 border-l-4 {{ $todo->completed ? 'border-l-slate-200 opacity-65' : ($todo->priority === 'high' ? 'border-l-rose-500' : ($todo->priority === 'medium' ? 'border-l-amber-400' : 'border-l-emerald-400')) }}" id="todo-row-{{ $todo->id }}">
                            
                            <!-- Standard Row Display -->
                            <div class="flex items-start gap-3.5" id="view-mode-{{ $todo->id }}">
                                
                                <!-- Checkbox Toggle Button -->
                                <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="pt-0.5 shrink-0">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                    <input type="hidden" name="filter_priority" value="{{ $priority }}">
                                    <input type="hidden" name="filter_category" value="{{ $category }}">
                                    <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">

                                    <button type="submit"
                                            class="w-5 h-5 rounded-full border transition-all flex items-center justify-center {{ $todo->completed ? 'border-emerald-500 bg-emerald-500 text-white shadow-2xs' : 'border-slate-300 hover:border-slate-600 bg-white text-transparent' }}">
                                        <svg class="w-3 h-3 fill-current stroke-current" stroke-width="2" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Task Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-sm font-semibold text-slate-900 break-words {{ $todo->completed ? 'task-done' : '' }}">
                                            {{ $todo->title }}
                                        </span>

                                        <!-- Priority Indicator Badge -->
                                        @if($todo->priority === 'high')
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-rose-50 text-rose-700 border border-rose-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> High
                                            </span>
                                        @elseif($todo->priority === 'medium')
                                            <span class="inline-flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200/60">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Med
                                            </span>
                                        @endif

                                        <!-- Category Tag Badge -->
                                        @if($todo->category)
                                            <a href="{{ route('todos.index', ['category' => $todo->category, 'sort' => $sort]) }}"
                                               class="text-[10px] font-semibold text-slate-500 bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded-md transition">
                                                #{{ $todo->category }}
                                            </a>
                                        @endif

                                        <!-- Due Date Badge -->
                                        @if($todo->due_date)
                                            @if($todo->isOverdue())
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-rose-100 text-rose-800">
                                                    ⚠️ Overdue ({{ $todo->due_date->format('M j') }})
                                                </span>
                                            @elseif($todo->isDueToday())
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-amber-100 text-amber-800">
                                                    ⏰ Due Today
                                                </span>
                                            @else
                                                <span class="text-[11px] font-medium text-slate-400">
                                                    📅 {{ $todo->due_date->format('M j') }}
                                                </span>
                                            @endif
                                        @endif
                                    </div>

                                    @if($todo->description)
                                        <p class="text-xs text-slate-500 mt-1 line-clamp-2 {{ $todo->completed ? 'task-done' : '' }}">
                                            {{ $todo->description }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Action Toolbar -->
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1 text-slate-400">
                                    <button type="button" onclick="showEditMode({{ $todo->id }})" title="Edit"
                                            class="p-1.5 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="filter" value="{{ $filter }}">
                                        <input type="hidden" name="filter_priority" value="{{ $priority }}">
                                        <input type="hidden" name="filter_category" value="{{ $category }}">
                                        <input type="hidden" name="search" value="{{ $search }}">
                                        <input type="hidden" name="sort" value="{{ $sort }}">

                                        <button type="submit" title="Delete" class="p-1.5 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>

                            <!-- Inline Edit Mode Panel -->
                            <div id="edit-mode-{{ $todo->id }}" class="hidden pt-2">
                                <form action="{{ route('todos.update', $todo) }}" method="POST" class="space-y-3 bg-slate-50 p-3.5 rounded-xl border border-slate-200">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                    <input type="hidden" name="filter_priority" value="{{ $priority }}">
                                    <input type="hidden" name="filter_category" value="{{ $category }}">
                                    <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="sort" value="{{ $sort }}">

                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Task Title</label>
                                        <input type="text" name="title" value="{{ $todo->title }}" required
                                               class="w-full text-xs font-medium rounded-lg border border-slate-300 bg-white p-2 text-slate-900 outline-none focus:border-slate-500">
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                        <div>
                                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Priority</label>
                                            <select name="priority" class="w-full text-xs rounded-lg border border-slate-300 bg-white p-1.5 text-slate-700 outline-none focus:border-slate-500">
                                                <option value="low" {{ $todo->priority === 'low' ? 'selected' : '' }}>🟢 Low</option>
                                                <option value="medium" {{ $todo->priority === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                                <option value="high" {{ $todo->priority === 'high' ? 'selected' : '' }}>🔴 High</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Due Date</label>
                                            <input type="date" name="due_date" value="{{ $todo->due_date ? $todo->due_date->format('Y-m-d') : '' }}"
                                                   class="w-full text-xs rounded-lg border border-slate-300 bg-white p-1.5 text-slate-700 outline-none focus:border-slate-500">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Tag</label>
                                            <input type="text" name="category" value="{{ $todo->category }}" placeholder="Tag"
                                                   class="w-full text-xs rounded-lg border border-slate-300 bg-white p-1.5 text-slate-700 outline-none focus:border-slate-500">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1">Notes</label>
                                        <textarea name="description" rows="2" class="w-full text-xs rounded-lg border border-slate-300 bg-white p-2 text-slate-700 outline-none focus:border-slate-500">{{ $todo->description }}</textarea>
                                    </div>

                                    <div class="flex items-center justify-end gap-2 pt-1 text-xs">
                                        <button type="button" onclick="hideEditMode({{ $todo->id }})" class="text-slate-500 hover:text-slate-800 px-3 py-1.5 font-medium">
                                            Cancel
                                        </button>
                                        <button type="submit" class="bg-slate-900 text-white font-semibold px-4 py-1.5 rounded-lg hover:bg-slate-800 transition">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </li>
                    @endforeach
                </ul>
            @endif

            <!-- Bottom Actions Footer -->
            <div class="px-5 py-3.5 bg-slate-50 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500">
                <span class="font-medium">
                    <strong class="text-slate-900 font-bold">{{ $remainingCount }}</strong> active tasks remaining
                </span>

                <div class="flex items-center gap-3">
                    @if($remainingCount > 0)
                        <form action="{{ route('todos.markAllCompleted') }}" method="POST">
                            @csrf
                            <input type="hidden" name="filter" value="{{ $filter }}">
                            <input type="hidden" name="filter_priority" value="{{ $priority }}">
                            <input type="hidden" name="filter_category" value="{{ $category }}">
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <button type="submit" class="font-semibold text-indigo-600 hover:text-indigo-800 transition px-2 py-1 rounded hover:bg-indigo-50">
                                Mark all as done
                            </button>
                        </form>
                    @endif

                    @if($completedCount > 0)
                        <form action="{{ route('todos.clearCompleted') }}" method="POST" onsubmit="return confirm('Clear {{ $completedCount }} completed tasks?');">
                            @csrf
                            <input type="hidden" name="filter" value="{{ $filter }}">
                            <input type="hidden" name="filter_priority" value="{{ $priority }}">
                            <input type="hidden" name="filter_category" value="{{ $category }}">
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="sort" value="{{ $sort }}">
                            <button type="submit" class="font-semibold text-rose-600 hover:text-rose-800 transition px-2 py-1 rounded hover:bg-rose-50">
                                Clear completed ({{ $completedCount }})
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </div>

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
