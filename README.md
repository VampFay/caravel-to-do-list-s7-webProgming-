# Fay Tasks — Glass Fluid Gamified Productivity Dashboard

A developer-grade, high-performance To-Do application and productivity dashboard built with **Laravel 13**, **Tailwind CSS**, and **Safari-compatible Web Audio API**. Fay Tasks marries Linear-style keyboard precision with Duolingo-inspired tactile micro-interactions and a liquid frosted glassmorphism UI.

---

## ✨ Key Features & Architecture

### 💎 1. Glass Fluid UI-UX Architecture
- **Dual Liquid Themes**: Seamless 400ms cubic-bezier transition between **Light Mode** and **Dark Mode** with zero flash of unstyled theme (`localStorage` caching).
- **Organic Ambient Blobs**: Multi-layered floating gradient blobs (`fluid-orb`) with continuous keyframe fluid physics.
- **Frosted Translucency**: High-saturate backdrop blur (`backdrop-filter: blur(24px) saturate(180%)`), translucent glass cards, and glowing borders.
- **Tactile 3D Duolingo Buttons**: Satisfying physical push response with deep bevel box-shadows and spring rebound on press (`:active { transform: translateY(3px) }`).

### 🎵 2. Generative Lo-Fi Music Synthesizer & Sound FX
- **Pure Web Audio API Synthesis**: Zero external MP3 files; 100% procedurally synthesized in the browser with Safari-compatible synchronous audio gesture unlocking.
- **Dual Soundscapes**:
  - `☕️ Rainy Cafe` (72 BPM): Warm vintage Rhodes electric piano chords (*Dm9 ➔ G13 ➔ Cmaj9 ➔ Am9*) through a 650Hz low-pass filter, analog vinyl surface crackle, and pentatonic bell chimes.
  - `🌌 Midnight Nebula` (52 BPM): Deep ambient sub-bass drone pads (*Fmaj9 ➔ Em7 ➔ Dm9 ➔ Cmaj7*), 420Hz filter sweep, and celestial starry bells.
- **Master Audio Graph**: Frosted glass master volume slider (`0%` to `100%`) with dedicated gain nodes.
- **Live Equalizer**: 4-band animated audio wave equalizer bars that dance when Lo-Fi beats are playing.
- **Tactile Sound Effects**: Custom synthesized audio cues for task completions (ascending major arpeggios), additions (soft pops), deletions (whoosh), and chest unlocks (fanfare).

### ⚡️ 3. Optimistic 60fps AJAX Engine
- **Instant Checkbox Toggle**: Sub-10ms UI update with SVG path animation, floating XP badge (`+25 XP`), particle physics confetti burst, and background metric recalculation.
- **Spring Drop-In Addition**: Newly created tasks glide in via `@keyframes springDropIn` without page reload.
- **Slide-Out Deletion**: Swipe-collapse animation (`animate-slide-out`) with zero layout shift.
- **Inline In-Place Editing**: Double-click any task title to open the inline edit card, save changes instantly, and sync the server state asynchronously.

### ⌨️ 4. Vim & Linear-Style Keyboard Navigation
- **Card Selection Glow Ring**: Traversal with iridescent focus ring (`ring-2 ring-indigo-500/80 shadow-[0_0_24px_rgba(99,102,241,0.35)] scale-[1.015]`).
- **Shortcuts Table**:
  | Key | Action |
  |---|---|
  | <kbd>⌘K</kbd> / <kbd>Ctrl+K</kbd> | Open Raycast-style Command Palette |
  | <kbd>J</kbd> / <kbd>↓</kbd> | Select next task card down |
  | <kbd>K</kbd> / <kbd>↑</kbd> | Select previous task card up |
  | <kbd>Space</kbd> / <kbd>X</kbd> | Toggle completed status on selected task |
  | <kbd>E</kbd> | Open inline edit mode for selected task |
  | <kbd>Delete</kbd> / <kbd>#</kbd> | Delete selected task with slide-out animation |
  | <kbd>N</kbd> | Focus task title input |
  | <kbd>/</kbd> | Focus instant filter/search bar |
  | <kbd>M</kbd> | Play / Pause generative Lo-Fi beats |
  | <kbd>F</kbd> | Toggle 25-minute Pomodoro Deep Work Flow |
  | <kbd>T</kbd> | Toggle Light / Dark mode |
  | <kbd>I</kbd> | Open JSON Task Import modal |
  | <kbd>C</kbd> | Claim Daily Mystery Chest reward |
  | <kbd>P</kbd> | Pet Mascot (Duo-Fay) |
  | <kbd>L</kbd> | Open Obsidian League Leaderboard |
  | <kbd>?</kbd> | Open Keyboard Shortcuts reference modal |
  | <kbd>Escape</kbd> | Close modals or deselect active task |

### 🎯 5. Quick Metadata Chips
- **Tactile Priority Chips**: Clickable 3D pill badges (`[⚪ Low]`, `[🟡 Med]`, `[🔴 High]`) that instantly set the priority with bouncy feedback.
- **1-Click Due Date Pills**: Instant scheduling with `[Today]`, `[Tomorrow]`, `[+7d]` (Next Week), and `[✕ Clear]`.

### 📦 6. 1-Click Task Export & Import
- **Export to JSON**: One-click download of `fay-tasks-export.json` with all metadata, categories, priorities, and timestamps.
- **Export to Markdown**: Instant generation of `fay-tasks.md` with GitHub/Obsidian checklist syntax (`- [ ]`, `- [x]`).
- **Bulk Import Engine**: Dedicated modal supporting drag-and-drop `.json` file upload or raw JSON text paste, with optimistic client-side card rendering and server sync.

### 🦉 7. Gamification & Duo-Fay Mascot
- **Interactive Vector Owl Mascot**: Real-time eye tracking that follows the user's mouse cursor across the screen, natural eyelid blinking, wing flutter, speech bubble quotes, and cheer celebration flips.
- **7-Day Streak Calendar**: Flame glow nodes with active streak counts and Ice Shield freeze protection (`🧊 1 Shield`).
- **Leveling System**: Dynamic XP progression bar, rank progression (*Focus Archer ➔ Flow Master ➔ Obsidian Champion*), and level-up celebration fanfare.
- **Obsidian League Leaderboard**: Visual competitive standings modal with live user position.
- **Daily Mystery Chest**: Wiggling chest with bonus XP rewards and mega confetti cannon blast.

### ⏱️ 8. Pomodoro Deep Work Flow
- 25-minute focus session with circular SVG countdown timer.
- Automatic Lo-Fi ambient music sync upon timer start.
- Rewarding completion celebration with +50 XP and fanfare sound.

---

## 🚀 Getting Started

### 1. Prerequisites
- **PHP 8.2+** with `sqlite3`, `mbstring`, and `pdo_sqlite` extensions.
- **Composer**

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/VampFay/caravel-to-do-list-s7-webProgming-.git
cd caravel-to-do-list-s7-webProgming-

# Install dependencies
composer install

# Environment configuration
cp .env.example .env
php artisan key:generate

# Initialize SQLite database and seed initial demo data
touch database/database.sqlite
php artisan migrate:fresh --seed
```

### 3. Run Development Server
```bash
php artisan serve
```
Open **http://127.0.0.1:8000** in your browser.

---

## 🧪 Automated Testing

Fay Tasks includes a test suite covering CRUD operations, filtering, sorting, scopes, JSON API endpoints, bulk actions, and JSON imports:

```bash
php artisan test
```

**Results:**
- **23 Feature Tests**
- **68 Assertions**
- **100% Pass Rate**
- **Code Style Compliant with Laravel Pint (`./vendor/bin/pint --test`)**

---

## 📂 Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   └── TodoController.php      # Dual-mode HTTP/JSON controller (Optimistic AJAX, CRUD, Bulk, Import)
│   └── Models/
│       └── Todo.php                # Eloquent model with scopes (status, priority, search, category)
├── database/
│   ├── migrations/
│   │   └── 2026_11_03_000000_create_todos_table.php
│   └── seeders/
│       └── DatabaseSeeder.php      # Clean, realistic initial tasks
├── resources/
│   └── views/
│       └── todos/
│           └── index.blade.php     # Glass fluid single-page view with Web Audio synthesizer & 60fps AJAX
├── routes/
│   └── web.php                     # Clean RESTful routes + bulk endpoints + import
├── tests/
│   └── Feature/
│       └── TodoTest.php            # 23 comprehensive PHPUnit feature tests
└── README.md
```

---

## 🛡️ License
Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
