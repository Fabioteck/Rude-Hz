<div>
    <script id="rude-tracks-data" type="application/json">@json($tracksQueue ?? [])</script>

    <div class="fixed bottom-0 left-0 w-full bg-[#121212]/95 text-white border-t border-white/10 backdrop-blur-md px-4 py-3 z-50 shadow-[0_-10px_30px_rgba(0,0,0,0.8)] font-mono"
         x-data="rudePlayer()"
         x-init="init()">
        
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-3">
            <template x-if="currentTrack">
                <div class="flex flex-col md:flex-row items-center justify-between gap-3 w-full">
                    <audio x-ref="audio"
                           :src="currentTrack.audio_url"
                           @timeupdate="updateProgress()"
                           @loadedmetadata="duration = $refs.audio.duration; if(shouldAutoPlay) { $refs.audio.play().then(() => isPlaying = true).catch(() => {}); }"
                           @ended="nextTrack()">
                    </audio>

                    <div class="flex items-center gap-3 w-full md:w-1/4 truncate">
                        <img :src="currentTrack.cover_url" class="w-11 h-11 object-cover rounded border border-[#E6FF00]/30 shrink-0" :alt="currentTrack.title">
                        <div class="truncate">
                            <p class="font-black text-xs uppercase tracking-tight text-white truncate" x-text="currentTrack.title"></p>
                            <p class="text-[10px] text-[#E6FF00] uppercase tracking-widest truncate mt-0.5" x-text="currentTrack.artist"></p>
                        </div>
                    </div>

                    <div class="flex flex-col items-center w-full md:w-2/4 gap-1.5">
                        <div class="flex items-center gap-4">
                            <button @click="prevTrack()" type="button" class="text-zinc-400 hover:text-[#E6FF00] transition text-sm">⏮</button>
                            <button @click="togglePlay()" type="button" class="w-9 h-9 rounded-full bg-[#E6FF00] text-black flex items-center justify-center font-bold hover:bg-white transition shadow-[0_0_15px_rgba(230,255,0,0.5)]">
                                <span x-text="isPlaying ? '⏸' : '▶'" class="text-xs"></span>
                            </button>
                            <button @click="nextTrack()" type="button" class="text-zinc-400 hover:text-[#E6FF00] transition text-sm">⏭</button>
                        </div>

                        <div class="flex items-center gap-2 w-full text-[10px] font-mono text-zinc-400">
                            <span x-text="formatTime(currentTime)" class="w-8 text-right">0:00</span>
                            <div @click="seek($event)" class="relative flex-1 h-2 bg-zinc-800 rounded-full cursor-pointer overflow-hidden border border-white/10">
                                <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-[#00FF66] to-[#E6FF00]" :style="'width: ' + (duration ? (currentTime / duration) * 100 : 0) + '%'"></div>
                            </div>
                            <span x-text="formatTime(duration)" class="w-8">0:00</span>
                        </div>
                    </div>

                    <div class="hidden md:flex items-center justify-end gap-3 w-1/4 text-xs">
                        <button @click="toggleMute()" type="button" class="text-zinc-400 hover:text-[#E6FF00] transition">
                            <span x-text="isMuted || volume == 0 ? '🔇' : '🔊'"></span>
                        </button>
                        <input type="range" min="0" max="1" step="0.01" x-model="volume" @input="updateVolume($event.target.value)" class="w-20 accent-[#E6FF00] cursor-pointer h-1 bg-zinc-800 rounded">
                        <span class="text-[10px] text-zinc-500 font-mono uppercase tracking-wider">Hi-Fi St.</span>
                    </div>
                </div>
            </template>

            <template x-if="!currentTrack">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-zinc-900 border border-white/10 rounded flex items-center justify-center text-[#E6FF00] font-bold">⚡</div>
                    <p class="font-bold text-xs uppercase text-white">Rude-Hz Master Queue — Nessun brano attivo</p>
                </div>
            </template>
        </div>
    </div>

    <script>
        function rudePlayer() {
            return {
                queue: [],
                currentIndex: 0,
                isPlaying: false,
                shouldAutoPlay: false,
                currentTime: 0,
                duration: 0,
                volume: 0.8,
                isMuted: false,
                get currentTrack() { return this.queue[this.currentIndex] || null; },
                init() {
                    try {
                        const raw = document.getElementById('rude-tracks-data');
                        if (raw) { this.queue = JSON.parse(raw.textContent || '[]'); if (this.queue.length > 1) this.currentIndex = Math.floor(Math.random() * this.queue.length); }
                    } catch (e) { this.queue = []; }

                    window.playRudeTrack = (trackInput) => {
                        const trackId = typeof trackInput === 'object' ? trackInput.id : trackInput;
                        const idx = this.queue.findIndex(t => t.id == trackId);
                        if (idx !== -1) {
                            this.currentIndex = idx;
                        } else if (typeof trackInput === 'object' && trackInput.audio_url) {
                            this.queue.unshift(trackInput);
                            this.currentIndex = 0;
                        }
                        this.playCurrent();
                    };
                    window.playTrack = window.playRudeTrack;

                    const unlockAudio = () => {
                        const audio = this.$refs.audio;
                        if (audio && audio.paused && this.currentTrack) {
                            audio.play().then(() => { this.isPlaying = true; }).catch(() => {});
                        }
                        window.removeEventListener('click', unlockAudio);
                        window.removeEventListener('touchstart', unlockAudio);
                    };
                    window.addEventListener('click', unlockAudio, { once: true });
                    window.addEventListener('touchstart', unlockAudio, { once: true });
                },
                togglePlay() {
                    const audio = this.$refs.audio;
                    if (!audio) return;
                    if (audio.paused) {
                        audio.play().then(() => { this.isPlaying = true; }).catch(() => {});
                    } else {
                        audio.pause();
                        this.isPlaying = false;
                    }
                },
                nextTrack() {
                    if (!this.queue.length) return;
                    this.currentIndex = (this.currentIndex + 1) % this.queue.length;
                    this.playCurrent();
                },
                prevTrack() {
                    if (!this.queue.length) return;
                    this.currentIndex = (this.currentIndex - 1 + this.queue.length) % this.queue.length;
                    this.playCurrent();
                },
                playCurrent() {
                    this.shouldAutoPlay = true;
                    this.$nextTick(() => {
                        const audio = this.$refs.audio;
                        if (audio && this.currentTrack) {
                            audio.src = this.currentTrack.audio_url;
                            audio.load();
                            audio.play().then(() => { this.isPlaying = true; }).catch(() => {});
                        }
                    });
                },
                updateProgress() {
                    const audio = this.$refs.audio;
                    if (!audio) return;
                    this.currentTime = audio.currentTime;
                    this.duration = audio.duration || 0;
                },
                seek(event) {
                    const audio = this.$refs.audio;
                    if (!audio || !audio.duration) return;
                    const rect = event.currentTarget.getBoundingClientRect();
                    const pos = (event.clientX - rect.left) / rect.width;
                    audio.currentTime = pos * audio.duration;
                },
                formatTime(secs) {
                    if (isNaN(secs)) return '0:00';
                    const m = Math.floor(secs / 60);
                    const s = Math.floor(secs % 60);
                    return m + ':' + (s < 10 ? '0' : '') + s;
                },
                toggleMute() {
                    const audio = this.$refs.audio;
                    if (!audio) return;
                    this.isMuted = !this.isMuted;
                    audio.muted = this.isMuted;
                },
                updateVolume(val) {
                    const audio = this.$refs.audio;
                    if (!audio) return;
                    this.volume = val;
                    audio.volume = val;
                    this.isMuted = val == 0;
                }
            }
        }
    </script>
</div>
