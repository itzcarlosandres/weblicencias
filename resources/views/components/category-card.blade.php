@php
    $styles = [
        'software' => [
            'gradient' => 'from-zinc-200/40 via-zinc-100/20 to-transparent dark:from-zinc-700/40 dark:via-zinc-800/20',
            'icon_color' => 'text-zinc-700 dark:text-zinc-200',
            'icon_bg' => 'bg-zinc-100 dark:bg-zinc-800',
            'tag_text' => 'text-zinc-600 dark:text-zinc-300',
            'tag_border' => 'border-zinc-300/50 dark:border-zinc-600/50',
            'tag_bg' => 'bg-zinc-50/80 dark:bg-zinc-800/80',
            'num_color' => 'text-zinc-500 dark:text-zinc-400',
            'shadow' => 'shadow-zinc-400/30',
            'shadow_hover' => 'group-hover:shadow-zinc-400/50',
            'accent' => 'text-zinc-700 dark:text-zinc-200 group-hover:text-primary-600 dark:group-hover:text-primary-300',
            'tag_label' => 'Software',
            'border' => 'border-zinc-200/50 dark:border-zinc-700/50',
            'icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/></svg>',
        ],
        'windows' => [
            'gradient' => 'from-primary-300/20 via-primary-200/10 to-transparent dark:from-primary-700/30 dark:via-primary-800/10',
            'icon_color' => 'text-primary-600 dark:text-primary-300',
            'icon_bg' => 'bg-primary-50 dark:bg-primary-900/40',
            'tag_text' => 'text-primary-700 dark:text-primary-300',
            'tag_border' => 'border-primary-300/50 dark:border-primary-700/50',
            'tag_bg' => 'bg-primary-50/80 dark:bg-primary-900/40',
            'num_color' => 'text-primary-500/80 dark:text-primary-300/70',
            'shadow' => 'shadow-primary-400/30',
            'shadow_hover' => 'group-hover:shadow-primary-400/50',
            'accent' => 'text-primary-700 dark:text-primary-300 group-hover:text-primary-800 dark:group-hover:text-primary-200',
            'tag_label' => 'Sistema',
            'border' => 'border-primary-200/50 dark:border-primary-700/40',
            'icon' => '<svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor"><path d="M0 3.449L9.75 2.1v9.451H0m10.949-9.602L24 0v11.4H10.949M0 12.6h9.75v9.451L0 20.699M10.949 12.6H24V24l-12.9-1.801"/></svg>',
        ],
        'office' => [
            'gradient' => 'from-amber-300/20 via-amber-200/10 to-transparent dark:from-amber-700/25 dark:via-amber-800/10',
            'icon_color' => '',
            'icon_bg' => 'bg-amber-50 dark:bg-amber-900/30',
            'tag_text' => 'text-amber-700 dark:text-amber-300',
            'tag_border' => 'border-amber-300/50 dark:border-amber-700/50',
            'tag_bg' => 'bg-amber-50/80 dark:bg-amber-900/30',
            'num_color' => 'text-amber-600/80 dark:text-amber-300/70',
            'shadow' => 'shadow-amber-400/30',
            'shadow_hover' => 'group-hover:shadow-amber-400/50',
            'accent' => 'text-amber-700 dark:text-amber-300 group-hover:text-amber-800 dark:group-hover:text-amber-200',
            'tag_label' => 'Productividad',
            'border' => 'border-amber-200/50 dark:border-amber-700/40',
            'icon' => '<svg class="w-7 h-7" viewBox="0 0 24 24"><rect x="2" y="4" width="9" height="9" fill="#F25022"/><rect x="13" y="4" width="9" height="9" fill="#7FBA00"/><rect x="2" y="15" width="9" height="9" fill="#00A4EF"/><rect x="13" y="15" width="9" height="9" fill="#FFB900"/></svg>',
        ],
        'antivirus' => [
            'gradient' => 'from-emerald-300/20 via-emerald-200/10 to-transparent dark:from-emerald-700/25 dark:via-emerald-800/10',
            'icon_color' => 'text-emerald-600 dark:text-emerald-300',
            'icon_bg' => 'bg-emerald-50 dark:bg-emerald-900/30',
            'tag_text' => 'text-emerald-700 dark:text-emerald-300',
            'tag_border' => 'border-emerald-300/50 dark:border-emerald-700/50',
            'tag_bg' => 'bg-emerald-50/80 dark:bg-emerald-900/30',
            'num_color' => 'text-emerald-600/80 dark:text-emerald-300/70',
            'shadow' => 'shadow-emerald-400/30',
            'shadow_hover' => 'group-hover:shadow-emerald-400/50',
            'accent' => 'text-emerald-700 dark:text-emerald-300 group-hover:text-emerald-800 dark:group-hover:text-emerald-200',
            'tag_label' => 'Seguridad',
            'border' => 'border-emerald-200/50 dark:border-emerald-700/40',
            'icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>',
        ],
        'gift-cards' => [
            'gradient' => 'from-rose-300/20 via-rose-200/10 to-transparent dark:from-rose-700/25 dark:via-rose-800/10',
            'icon_color' => 'text-rose-600 dark:text-rose-300',
            'icon_bg' => 'bg-rose-50 dark:bg-rose-900/30',
            'tag_text' => 'text-rose-700 dark:text-rose-300',
            'tag_border' => 'border-rose-300/50 dark:border-rose-700/50',
            'tag_bg' => 'bg-rose-50/80 dark:bg-rose-900/30',
            'num_color' => 'text-rose-600/80 dark:text-rose-300/70',
            'shadow' => 'shadow-rose-400/30',
            'shadow_hover' => 'group-hover:shadow-rose-400/50',
            'accent' => 'text-rose-700 dark:text-rose-300 group-hover:text-rose-800 dark:group-hover:text-rose-200',
            'tag_label' => 'Regalo',
            'border' => 'border-rose-200/50 dark:border-rose-700/40',
            'icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>',
        ],
        'streaming' => [
            'gradient' => 'from-violet-300/20 via-violet-200/10 to-transparent dark:from-violet-700/25 dark:via-violet-800/10',
            'icon_color' => 'text-violet-600 dark:text-violet-300',
            'icon_bg' => 'bg-violet-50 dark:bg-violet-900/30',
            'tag_text' => 'text-violet-700 dark:text-violet-300',
            'tag_border' => 'border-violet-300/50 dark:border-violet-700/50',
            'tag_bg' => 'bg-violet-50/80 dark:bg-violet-900/30',
            'num_color' => 'text-violet-600/80 dark:text-violet-300/70',
            'shadow' => 'shadow-violet-400/30',
            'shadow_hover' => 'group-hover:shadow-violet-400/50',
            'accent' => 'text-violet-700 dark:text-violet-300 group-hover:text-violet-800 dark:group-hover:text-violet-200',
            'tag_label' => 'Entretenimiento',
            'border' => 'border-violet-200/50 dark:border-violet-700/40',
            'icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6"/></svg>',
        ],
        'xbox' => [
            'gradient' => 'from-green-300/20 via-green-200/10 to-transparent dark:from-green-700/25 dark:via-green-800/10',
            'icon_color' => 'text-green-600 dark:text-green-300',
            'icon_bg' => 'bg-green-50 dark:bg-green-900/30',
            'tag_text' => 'text-green-700 dark:text-green-300',
            'tag_border' => 'border-green-300/50 dark:border-green-700/50',
            'tag_bg' => 'bg-green-50/80 dark:bg-green-900/30',
            'num_color' => 'text-green-600/80 dark:text-green-300/70',
            'shadow' => 'shadow-green-400/30',
            'shadow_hover' => 'group-hover:shadow-green-400/50',
            'accent' => 'text-green-700 dark:text-green-300 group-hover:text-green-800 dark:group-hover:text-green-200',
            'tag_label' => 'Gaming',
            'border' => 'border-green-200/50 dark:border-green-700/40',
            'icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.547 5.975 5.975 0 01-2.133-1A3.75 3.75 0 0012 18z"/></svg>',
        ],
        'playstation' => [
            'gradient' => 'from-indigo-300/20 via-indigo-200/10 to-transparent dark:from-indigo-700/25 dark:via-indigo-800/10',
            'icon_color' => 'text-indigo-600 dark:text-indigo-300',
            'icon_bg' => 'bg-indigo-50 dark:bg-indigo-900/30',
            'tag_text' => 'text-indigo-700 dark:text-indigo-300',
            'tag_border' => 'border-indigo-300/50 dark:border-indigo-700/50',
            'tag_bg' => 'bg-indigo-50/80 dark:bg-indigo-900/30',
            'num_color' => 'text-indigo-600/80 dark:text-indigo-300/70',
            'shadow' => 'shadow-indigo-400/30',
            'shadow_hover' => 'group-hover:shadow-indigo-400/50',
            'accent' => 'text-indigo-700 dark:text-indigo-300 group-hover:text-indigo-800 dark:group-hover:text-indigo-200',
            'tag_label' => 'Gaming',
            'border' => 'border-indigo-200/50 dark:border-indigo-700/40',
            'icon' => '<svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M9.5 3v18l3.5-.7V9.3c0-.5.2-.8.6-.8s.6.3.6.8v5.5c1.5.7 2.7.5 3.7-.5 1.1-1.1 1.5-3 1.5-5.5 0-3.3-1-5-3.5-5.5-1.3-.3-3-.1-4.4.4L9.5 3zm-5 18.4l2.7-.5V8.7c0-.5.2-.8.5-.8s.5.3.5.8v6.6c1.3-.3 2.5-.7 3.6-1.3V8.6c0-3.1-1.2-4.6-3.5-4.6-1.4 0-2.6.3-3.8.8v16.6z"/></svg>',
        ],
        'juegos' => [
            'gradient' => 'from-fuchsia-300/20 via-fuchsia-200/10 to-transparent dark:from-fuchsia-700/25 dark:via-fuchsia-800/10',
            'icon_color' => 'text-fuchsia-600 dark:text-fuchsia-300',
            'icon_bg' => 'bg-fuchsia-50 dark:bg-fuchsia-900/30',
            'tag_text' => 'text-fuchsia-700 dark:text-fuchsia-300',
            'tag_border' => 'border-fuchsia-300/50 dark:border-fuchsia-700/50',
            'tag_bg' => 'bg-fuchsia-50/80 dark:bg-fuchsia-900/30',
            'num_color' => 'text-fuchsia-600/80 dark:text-fuchsia-300/70',
            'shadow' => 'shadow-fuchsia-400/30',
            'shadow_hover' => 'group-hover:shadow-fuchsia-400/50',
            'accent' => 'text-fuchsia-700 dark:text-fuchsia-300 group-hover:text-fuchsia-800 dark:group-hover:text-fuchsia-200',
            'tag_label' => 'Gaming',
            'border' => 'border-fuchsia-200/50 dark:border-fuchsia-700/40',
            'icon' => '<svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 12H8m2 4v-8"/></svg>',
        ],
        'steam' => [
            'gradient' => 'from-slate-300/20 via-slate-200/10 to-transparent dark:from-slate-700/25 dark:via-slate-800/10',
            'icon_color' => 'text-slate-700 dark:text-slate-200',
            'icon_bg' => 'bg-slate-100 dark:bg-slate-800',
            'tag_text' => 'text-slate-600 dark:text-slate-300',
            'tag_border' => 'border-slate-300/50 dark:border-slate-600/50',
            'tag_bg' => 'bg-slate-50/80 dark:bg-slate-800/80',
            'num_color' => 'text-slate-500/80 dark:text-slate-400/70',
            'shadow' => 'shadow-slate-400/30',
            'shadow_hover' => 'group-hover:shadow-slate-400/50',
            'accent' => 'text-slate-700 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-slate-100',
            'tag_label' => 'Gaming',
            'border' => 'border-slate-200/50 dark:border-slate-700/40',
            'icon' => '<svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.5 2 2 6.5 2 12c0 4.4 2.9 8.2 6.9 9.5l3.4-1.4c.4.2.8.3 1.2.3 1.7 0 3-1.3 3-3 0-.1 0-.3-.1-.4l4.4-3.2c.1 0 .1.1.2.1 1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2c0 .1 0 .2.1.3l-4.5 3.3c-.5-.4-1.1-.6-1.7-.6-.4 0-.7.1-1.1.2L8 13.3c0-.1.1-.2.1-.3 0-1.1-.9-2-2-2s-2 .9-2 2c0 .8.5 1.5 1.2 1.8l1.5 1.3c-.1.3-.1.6-.1.9 0 1.7 1.3 3 3 3s3-1.3 3-3c0-.3 0-.5-.1-.7l4.4-3.2c.2.1.5.1.7.1 1.7 0 3-1.3 3-3 0-1.4-1-2.7-2.4-3 0-.1 0-.2 0-.3 0-5-4.5-9-10-9z"/></svg>',
        ],
    ];

    $slug = $category->slug ?? \Illuminate\Support\Str::slug($category->name);
    $style = $styles[$slug] ?? $styles['software'];
    $num = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
@endphp

<a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group shrink-0 w-[240px] sm:w-[260px] snap-start block">
    <div class="relative aspect-[3/4] rounded-2xl overflow-hidden bg-ink-100 dark:bg-ink-800 border {{ $style['border'] }}">
        <div class="absolute inset-0 bg-gradient-to-br {{ $style['gradient'] }}"></div>
        <div class="relative h-full flex flex-col">
            <div class="flex items-start justify-between p-4 z-10">
                <span class="num-badge text-[10px] font-medium tracking-widest {{ $style['num_color'] }}">{{ $num }}</span>
                <span class="text-[9px] font-medium tracking-[0.2em] uppercase {{ $style['tag_text'] }} px-2 py-0.5 rounded-full backdrop-blur-sm border {{ $style['tag_border'] }} {{ $style['tag_bg'] }}">{{ $style['tag_label'] }}</span>
            </div>
            <div class="flex-1 flex items-center justify-center">
                <div class="w-14 h-14 rounded-xl {{ $style['icon_bg'] }} border {{ $style['border'] }} flex items-center justify-center transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-110 group-hover:-rotate-3">
                    <span class="{{ $style['icon_color'] }}">{!! $style['icon'] !!}</span>
                </div>
            </div>
            <div class="p-4 bg-gradient-to-t from-ink-100 via-ink-100/95 to-ink-100/0 dark:from-ink-800 dark:via-ink-800/95 dark:to-ink-800/0">
                <div class="font-serif text-lg font-medium text-text-primary dark:text-white mb-0.5 tracking-tight">{{ $category->name }}</div>
                <div class="text-[11px] text-text-secondary dark:text-text-dark-secondary mb-2 line-clamp-1">{{ $category->description ?? Str::limit($category->name, 30) }}</div>
                <div class="flex items-center justify-between text-[11px]">
                    <span class="num-badge text-ink-500 dark:text-ink-400 font-medium">{{ $category->products_count ?? 0 }} {{ ($category->products_count ?? 0) === 1 ? 'producto' : 'productos' }}</span>
                    <span class="{{ $style['accent'] }} font-medium transition ease-[cubic-bezier(0.16,1,0.3,1)] flex items-center gap-1">Ver <svg class="w-3 h-3 transition-transform duration-500 ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></span>
                </div>
            </div>
        </div>
    </div>
</a>
