{{-- Badge Unlock Modal Component --}}
<div x-data="badgeUnlockModal()"
     x-init="init()"
     @badge-unlocked.window="addBadge($event.detail)"
     x-cloak>

    {{-- Modal Overlay --}}
    <div x-show="currentBadge !== null"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeBadge()"
         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm"
         style="display: none;">

        {{-- Modal Content --}}
        <div x-show="currentBadge !== null"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-50 rotate-12"
             x-transition:enter-end="opacity-100 scale-100 rotate-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100 rotate-0"
             x-transition:leave-end="opacity-0 scale-75 rotate-6"
             @click.stop
             class="relative max-w-md w-full mx-4">

            {{-- Badge Card --}}
            <div class="relative bg-gradient-to-br from-slate-800 via-slate-900 to-slate-950 rounded-2xl shadow-2xl overflow-hidden border-2"
                 :style="`border-color: ${currentBadge?.rarity_color || '#6B7280'}; box-shadow: 0 0 40px ${currentBadge?.rarity_color || '#6B7280'}40`">

                {{-- Animated Background Particles --}}
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <div class="particle-container">
                        <template x-for="i in 20" :key="i">
                            <div class="particle"
                                 :style="`
                                     left: ${Math.random() * 100}%;
                                     animation-delay: ${Math.random() * 3}s;
                                     animation-duration: ${3 + Math.random() * 2}s;
                                 `"></div>
                        </template>
                    </div>
                </div>

                {{-- Glow Effect --}}
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full opacity-20 blur-3xl"
                     :style="`background: ${currentBadge?.rarity_color || '#6B7280'}`"></div>

                {{-- Content --}}
                <div class="relative z-10 p-8 text-center">
                    {{-- New Badge Label --}}
                    <div class="mb-4">
                        <span class="inline-block px-4 py-1 text-xs font-bold tracking-widest text-white uppercase rounded-full bg-gradient-to-r from-yellow-500 to-orange-500 shadow-lg animate-pulse">
                            Badge Unlocked!
                        </span>
                    </div>

                    {{-- Badge Icon --}}
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            {{-- Rotating Ring --}}
                            <div class="absolute inset-0 rounded-full animate-spin-slow"
                                 :style="`background: conic-gradient(from 0deg, transparent, ${currentBadge?.rarity_color || '#6B7280'}, transparent); filter: blur(8px);`"></div>

                            {{-- Icon Container --}}
                            <div class="relative w-32 h-32 rounded-full flex items-center justify-center bg-gradient-to-br from-slate-700 to-slate-900 shadow-2xl border-4"
                                 :style="`border-color: ${currentBadge?.rarity_color || '#6B7280'}`">

                                {{-- Badge Image or Icon --}}
                                <template x-if="currentBadge?.icon_url">
                                    <img :src="currentBadge.icon_url"
                                         :alt="currentBadge.name"
                                         class="w-20 h-20 object-contain animate-bounce-subtle">
                                </template>

                                <template x-if="!currentBadge?.icon_url && currentBadge?.icon">
                                    <i :class="currentBadge.icon"
                                       class="text-5xl animate-bounce-subtle"
                                       :style="`color: ${currentBadge?.rarity_color || '#6B7280'}`"></i>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Badge Name --}}
                    <h2 class="text-3xl font-bold text-white mb-2 animate-fade-in"
                        x-text="currentBadge?.name"></h2>

                    {{-- Rarity Level --}}
                    <div class="flex items-center justify-center gap-2 mb-4">
                        <div class="h-px w-12 bg-gradient-to-r from-transparent"
                             :style="`background: linear-gradient(to right, transparent, ${currentBadge?.rarity_color || '#6B7280'})`"></div>

                        <span class="text-sm font-semibold uppercase tracking-wider"
                              :style="`color: ${currentBadge?.rarity_color || '#6B7280'}`"
                              x-text="currentBadge?.rarity_label"></span>

                        <div class="h-px w-12 bg-gradient-to-l from-transparent"
                             :style="`background: linear-gradient(to left, transparent, ${currentBadge?.rarity_color || '#6B7280'})`"></div>
                    </div>

                    {{-- Badge Description --}}
                    <p class="text-gray-300 text-sm mb-6 leading-relaxed max-w-sm mx-auto"
                       x-text="currentBadge?.description"></p>

                    {{-- Unlock Criteria --}}
                    <div class="bg-slate-800/50 rounded-lg p-4 mb-6 border border-slate-700">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Unlocked For</p>
                        <p class="text-sm text-white" x-text="currentBadge?.unlock_criteria"></p>
                    </div>

                    {{-- Queue Indicator --}}
                    <template x-if="badgeQueue.length > 0">
                        <div class="text-xs text-gray-400 mb-4">
                            <span x-text="`+${badgeQueue.length} more badge${badgeQueue.length > 1 ? 's' : ''} unlocked`"></span>
                        </div>
                    </template>

                    {{-- Close Instruction --}}
                    <p class="text-xs text-gray-500 animate-pulse">
                        Click anywhere to continue
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Particle Animation */
    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: white;
        border-radius: 50%;
        opacity: 0;
        animation: float-up 5s infinite;
    }

    @keyframes float-up {
        0% {
            transform: translateY(100vh) scale(0);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(-20vh) scale(1);
            opacity: 0;
        }
    }

    /* Slow Spin Animation */
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }

    /* Subtle Bounce */
    @keyframes bounce-subtle {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .animate-bounce-subtle {
        animation: bounce-subtle 2s ease-in-out infinite;
    }

    /* Fade In */
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
</style>

<script>
    function badgeUnlockModal() {
        return {
            badgeQueue: [],
            currentBadge: null,
            processing: false,
            shownBadgeIds: [], // Track badges already shown in this session

            init() {
                // Check for pending badges on page load
                this.checkPendingBadges();
            },

            /**
             * Add a new badge to the queue
             */
            addBadge(badge) {
                console.log('Badge unlocked:', badge);

                // Check if this badge is already in the queue or currently showing
                const isDuplicate = this.badgeQueue.some(b => b.id === badge.id) ||
                                  (this.currentBadge && this.currentBadge.id === badge.id) ||
                                  this.shownBadgeIds.includes(badge.id);

                if (isDuplicate) {
                    console.log('Badge already in queue or shown, skipping:', badge.id);
                    return;
                }

                this.badgeQueue.push(badge);

                // If not currently showing a badge, show the next one
                if (!this.currentBadge && !this.processing) {
                    this.showNextBadge();
                }
            },

            /**
             * Show the next badge in the queue
             */
            showNextBadge() {
                if (this.badgeQueue.length === 0) {
                    this.currentBadge = null;
                    this.processing = false;
                    return;
                }

                this.processing = true;
                this.currentBadge = this.badgeQueue.shift();

                // Mark badge as displayed
                this.markBadgeAsDisplayed(this.currentBadge.id);
            },

            /**
             * Close current badge and show next
             */
            closeBadge() {
                // Track that this badge has been shown
                if (this.currentBadge) {
                    this.shownBadgeIds.push(this.currentBadge.id);
                }

                this.currentBadge = null;
                this.processing = false;

                // Show next badge after a short delay
                setTimeout(() => {
                    this.showNextBadge();
                }, 300);
            },

            /**
             * Check for pending badges where modal hasn't been shown yet
             * (checks modal_shown=false, not is_displayed)
             */
            async checkPendingBadges() {
                try {
                    const response = await fetch('/api/badges/pending', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin'
                    });

                    if (response.ok) {
                        const data = await response.json();
                        if (data.badges && data.badges.length > 0) {
                            // Add all pending badges to the queue
                            data.badges.forEach(badge => this.addBadge(badge));
                        }
                    }
                } catch (error) {
                    console.error('Error fetching pending badges:', error);
                }
            },

            /**
             * Mark badge modal as shown on the server
             * Note: This sets modal_shown=true, not is_displayed
             * is_displayed is used for profile badge display preference
             */
            async markBadgeAsDisplayed(badgeId) {
                try {
                    await fetch(`/api/badges/${badgeId}/mark-displayed`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        credentials: 'same-origin'
                    });
                } catch (error) {
                    console.error('Error marking badge modal as shown:', error);
                }
            }
        }
    }
</script>
