@props(['latestNews', 'popularNews', 'latestArticles', 'popularArticles'])

<div class="max-w-7xl mx-auto px-4 py-12 md:py-20 animate-fade-in-up space-y-20">
    
    <!-- SECTION 1: NEWS (Berita) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Content: Latest News -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-heading tracking-tight border-l-4 border-brand pl-4">Berita Terbaru</h2>
                <a href="{{ route('public.news.index') }}" class="group flex items-center text-brand font-medium hover:text-brand-strong transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($latestNews as $news)
                    <article class="group bg-white rounded-2xl border border-default/50 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm text-heading text-xs font-bold px-3 py-1 rounded-full shadow-sm">{{ $news->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-heading mb-3 line-clamp-2 group-hover:text-brand transition-colors">
                                <a href="{{ route('news.show', $news->slug) }}">
                                    {{ $news->title }}
                                </a>
                            </h3>
                            <p class="text-body text-sm mb-4 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($news->content), 100) }}
                            </p>
                            <a href="{{ route('news.show', $news->slug) }}" class="inline-flex items-center text-brand font-semibold text-sm hover:underline">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12 bg-neutral-secondary-subtle rounded-xl">
                        <p class="text-body-subtle">Belum ada berita terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar: Popular News -->
        <aside class="lg:col-span-1">
            <div class="sticky top-24 bg-white rounded-2xl border border-default/50 p-6 shadow-sm">
                <h3 class="text-lg font-bold text-heading mb-6 flex items-center">
                    <span class="bg-brand w-2 h-6 rounded-full mr-3"></span>
                    Berita Populer
                </h3>
                <div class="space-y-6">
                    @forelse($popularNews as $news)
                        <a href="{{ route('news.show', $news->slug) }}" class="flex group">
                            <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden mr-4">
                                <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-heading line-clamp-2 group-hover:text-brand transition-colors mb-1">
                                    {{ $news->title }}
                                </h4>
                                <div class="flex items-center text-xs text-body-subtle">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    {{ number_format($news->views) }} views
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-body-subtle">Belum ada data populer.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>

    <!-- SECTION 2: ARTICLES (Artikel) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Main Content: Latest Articles -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-heading tracking-tight border-l-4 border-brand pl-4">Artikel Terbaru</h2>
                <a href="{{ route('public.article.index') }}" class="group flex items-center text-brand font-medium hover:text-brand-strong transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($latestArticles as $article)
                    <article class="group bg-white rounded-2xl border border-default/50 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4">
                                    <span class="bg-brand/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">{{ $article->category->name ?? 'Umum' }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-body-subtle text-xs mb-3 space-x-2">
                                <span>{{ $article->created_at->format('d M Y') }}</span>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span>{{ $article->user->name ?? 'Admin' }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-heading mb-3 line-clamp-2 group-hover:text-brand transition-colors">
                                <a href="{{ route('public.article.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="text-body text-sm mb-4 line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
                            <a href="{{ route('public.article.show', $article->slug) }}" class="inline-flex items-center text-brand font-semibold text-sm hover:underline">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12 bg-neutral-secondary-subtle rounded-xl">
                        <p class="text-body-subtle">Belum ada artikel terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar: Popular Articles -->
        <aside class="lg:col-span-1">
            <div class="sticky top-24 bg-white rounded-2xl border border-default/50 p-6 shadow-sm">
                <h3 class="text-lg font-bold text-heading mb-6 flex items-center">
                    <span class="bg-brand w-2 h-6 rounded-full mr-3"></span>
                    Artikel Populer
                </h3>
                    <div class="space-y-6">
                    @forelse($popularArticles as $article)
                        <a href="{{ route('public.article.show', $article->slug) }}" class="flex group">
                            <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden mr-4">
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-heading line-clamp-2 group-hover:text-brand transition-colors mb-1">
                                    {{ $article->title }}
                                </h4>
                                <div class="flex items-center text-xs text-body-subtle space-x-3">
                                        <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        {{ number_format($article->views) }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                        {{ $article->category->name ?? 'Umum' }}
                                        </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-body-subtle">Belum ada data populer.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</div>
