<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5">
            <h1 class="text-3xl font-bold mb-3 text-center text-teal-700 py-2 border-b-2 border-teal-200">
                {{ $name }}</h1>
            <div class="bg-teal-50 p-3 rounded-lg max-w-md mx-auto mb-6 flex items-center shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-teal-700">
                    {{ __('general.click_dhikr_instruction') ?? 'اضغط على الذكر لكي يعمل العداد' }}</p>
            </div>

            <div class="mt-6">
                <ul class="space-y-10">
                    @foreach ($adhkar as $index => $dhikr)
                        <li class="dhikr-card" x-data="{
                            dhikrId: '{{ $name }}_dhikr_{{ $index }}',
                            count: @js((int) $dhikr['count']),
                            originalCount: @js((int) $dhikr['count']),
                            completed: false,
                        
                            init() {
                                // استرجاع البيانات المحفوظة من التخزين المحلي
                                const savedData = this.getSavedData();
                                if (savedData) {
                                    this.count = savedData.count;
                                    this.completed = savedData.count === 0;
                                }
                            },
                        
                            // حفظ البيانات في التخزين المحلي مع وقت انتهاء الصلاحية
                            saveToLocalStorage() {
                                const now = new Date();
                                const data = {
                                    count: this.count,
                                    timestamp: now.getTime(),
                                    expiresAt: now.getTime() + (4 * 60 * 60 * 1000) // 4 ساعات بالميلي ثانية
                                };
                                localStorage.setItem(this.dhikrId, JSON.stringify(data));
                            },
                        
                            // استرجاع البيانات المحفوظة مع التحقق من انتهاء الصلاحية
                            getSavedData() {
                                const savedItem = localStorage.getItem(this.dhikrId);
                                if (!savedItem) return null;
                        
                                try {
                                    const data = JSON.parse(savedItem);
                                    const now = new Date().getTime();
                        
                                    // التحقق من انتهاء الصلاحية
                                    if (data.expiresAt && data.expiresAt < now) {
                                        localStorage.removeItem(this.dhikrId);
                                        return null;
                                    }
                        
                                    return data;
                                } catch (e) {
                                    return null;
                                }
                            },
                        
                            decrementCount() {
                                if (this.count > 0) {
                                    this.count -= 1;
                                    this.saveToLocalStorage();
                        
                                    if (this.count === 0) {
                                        this.completed = true;
                                        this.$el.classList.add('completed-animation');
                                        setTimeout(() => {
                                            this.$el.classList.remove('completed-animation');
                                        }, 1000);
                                    }
                                }
                            },
                        
                            resetCount() {
                                if (this.count === 0) {
                                    this.count = this.originalCount;
                                    this.completed = false;
                                    this.saveToLocalStorage();
                                }
                            }
                        }"
                            :class="{ 'bg-green-100 border-green-400': completed, 'bg-white border-gray-200': !completed }"
                            class="text-center relative overflow-hidden rounded-xl border-2 shadow-lg transition-all duration-300 ease-in-out p-1">

                            <div @click="decrementCount()"
                                class="p-5 cursor-pointer select-none transition-all duration-300 hover:bg-teal-50 rounded-lg">
                                <div class="mb-3 text-xl leading-8 font-arabic">{!! $dhikr['content'] !!}</div>

                                <div class="flex justify-center items-center mt-3">
                                    <div class="counter-circle" :class="{ 'scale-110 bg-green-600': count === 0 }">
                                        <span x-text="count > 0 ? count : '✓'" class="counter-text"></span>
                                    </div>
                                </div>

                                <div x-show="count === 0" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-90"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    class="mt-3 text-green-700 font-medium">
                                    {{ __('general.completed_praise') ?? 'تم بحمد الله' }}
                                </div>
                            </div>

                            <button x-show="count === 0" @click="resetCount()"
                                class="absolute top-2 right-2 p-1 rounded-full bg-white shadow-sm hover:bg-gray-100 focus:outline-none text-gray-500"
                                title="{{ __('general.reset') ?? 'إعادة' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </main>
    </x-container>

    <style>
        .font-arabic {
            font-family: "Amiri", "Noto Naskh Arabic", "Almarai", "Dubai", "Tajawal", "Cairo", "Traditional Arabic", "Scheherazade", serif;
            line-height: 1.8;
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            direction: rtl;
        }

        /* تحسين عرض دائرة العداد */
        .counter-circle {
            background-color: #0d9488;
            color: white;
            border-radius: 50%;
            height: 3.5rem;
            width: 3.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .counter-text {
            font-size: 1.25rem;
            line-height: 1;
            font-family: 'Cairo', sans-serif;
        }

        /* تحسينات للهواتف المحمولة */
        @media (max-width: 640px) {
            .counter-circle {
                height: 4rem;
                width: 4rem;
            }

            .counter-text {
                font-size: 1.5rem;
            }
        }

        /* تحسينات للهواتف الصغيرة */
        @media (max-width: 375px) {
            .counter-circle {
                height: 3.75rem;
                width: 3.75rem;
            }
        }

        .dhikr-card {
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.5s;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        .dhikr-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .completed-animation {
            animation: pulseGreen 1s ease;
        }

        @keyframes pulseGreen {
            0% {
                background-color: white;
            }

            50% {
                background-color: #d1fae5;
            }

            100% {
                background-color: #ecfdf5;
            }
        }
    </style>

    <!-- استيراد خطوط جوجل العربية -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Cairo:wght@400;500;600;700&family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Tajawal:wght@400;500;700&display=swap"
        rel="stylesheet">
</x-app-layout>
