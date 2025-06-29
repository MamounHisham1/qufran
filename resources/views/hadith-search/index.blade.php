<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">البحث في الأحاديث</h1>
                <p class="text-lg text-gray-600">ابحث في موسوعة الأحاديث النبوية الشريفة</p>
            </div>

            <!-- Search Form -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8" x-data="hadithSearch()">
                <form @submit.prevent="performSearch">
                    <!-- Main Search Input -->
                    <div class="mb-6">
                        <label for="search-input" class="block text-lg font-semibold text-gray-700 mb-2">
                            نص البحث
                        </label>
                        <input 
                            type="text" 
                            id="search-input"
                            x-model="searchQuery"
                            placeholder="ادخل نص الحديث أو كلمة للبحث..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-lg"
                            required
                        >
                    </div>

                    <!-- Advanced Filters Toggle -->
                    <div class="mb-4">
                        <button 
                            type="button"
                            @click="showAdvanced = !showAdvanced"
                            class="flex items-center text-teal-600 hover:text-teal-800 font-medium"
                        >
                            <span x-text="showAdvanced ? 'إخفاء الخيارات المتقدمة' : 'إظهار الخيارات المتقدمة'"></span>
                            <svg class="w-5 h-5 mr-2 transform transition-transform" :class="{'rotate-180': showAdvanced}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Advanced Filters -->
                    <div x-show="showAdvanced" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Books Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">الكتب</label>
                            <select x-model="filters.books" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500" size="4">
                                @foreach($books as $book)
                                    <option value="{{ $book['value'] }}">{{ $book['key'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Scholars Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">المحدثين</label>
                            <select x-model="filters.scholars" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500" size="4">
                                @foreach($scholars as $scholar)
                                    <option value="{{ $scholar['value'] }}">{{ $scholar['key'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Degrees Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">درجة الحديث</label>
                            <select x-model="filters.degrees" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500" size="4">
                                @foreach($degrees as $degree)
                                    <option value="{{ $degree['value'] }}">{{ $degree['key'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Zone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">نطاق البحث</label>
                            <select x-model="filters.searchZone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <option value="">جميع النطاقات</option>
                                @foreach($searchZones as $zone)
                                    <option value="{{ $zone['value'] }}">{{ $zone['key'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Method -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">طريقة البحث</label>
                            <select x-model="filters.searchMethod" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                <option value="">الطريقة الافتراضية</option>
                                @foreach($searchMethods as $method)
                                    <option value="{{ $method['value'] }}">{{ $method['key'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="text-center">
                        <button 
                            type="submit"
                            :disabled="loading"
                            class="bg-teal-600 hover:bg-teal-700 disabled:bg-gray-400 text-white font-bold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center justify-center mx-auto"
                        >
                            <span x-show="!loading">بحث</span>
                            <span x-show="loading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                جاري البحث...
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Results Section -->
                <div x-show="searchResults.length > 0 || error || note" class="mt-8 bg-gray-50 rounded-lg p-6">
                    <!-- Error Message -->
                    <div x-show="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <span x-text="error"></span>
                    </div>

                    <!-- Sample Data Notice -->
                    <div x-show="note" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span x-text="note"></span>
                        </div>
                    </div>

                    <!-- Results Info -->
                    <div x-show="searchResults.length > 0 && !error" class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-bold text-gray-800">نتائج البحث</h2>
                            <span class="text-gray-600" x-text="`عدد النتائج: ${metadata.length || searchResults.length}`"></span>
                        </div>
                    </div>

                    <!-- Results List -->
                    <div x-show="searchResults.length > 0" class="space-y-6">
                        <template x-for="(hadith, index) in searchResults" :key="index">
                            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                                <!-- Hadith Text -->
                                <div class="mb-4">
                                    <p class="text-lg leading-relaxed text-gray-800" x-html="hadith.hadith"></p>
                                </div>

                                <!-- Hadith Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div>
                                        <span class="font-semibold">الراوي:</span>
                                        <span x-text="hadith.rawi"></span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">المحدث:</span>
                                        <span x-text="hadith.mohdith"></span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">الكتاب:</span>
                                        <span x-text="hadith.book"></span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">الرقم/الصفحة:</span>
                                        <span x-text="hadith.numberOrPage"></span>
                                    </div>
                                </div>

                                <!-- Grade -->
                                <div class="mt-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                          :class="getGradeColor(hadith.grade)">
                                        <span x-text="hadith.grade"></span>
                                    </span>
                                </div>

                                <!-- Additional Info -->
                                <div x-show="hadith.explainGrade" class="mt-3 text-sm text-gray-600">
                                    <span class="font-semibold">توضيح الدرجة:</span>
                                    <span x-text="hadith.explainGrade"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Pagination -->
                    <div x-show="searchResults.length > 0 && metadata.length > 10" class="mt-8 flex justify-center">
                        <div class="flex space-x-2">
                            <button 
                                @click="loadPage(currentPage - 1)"
                                :disabled="currentPage <= 1"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                السابق
                            </button>
                            <span class="px-4 py-2 text-sm text-gray-700" x-text="`الصفحة ${currentPage}`"></span>
                            <button 
                                @click="loadPage(currentPage + 1)"
                                :disabled="searchResults.length < 10"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                التالي
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function hadithSearch() {
            return {
                searchQuery: '',
                showAdvanced: false,
                loading: false,
                searchResults: [],
                metadata: {},
                error: null,
                note: null,
                currentPage: 1,
                filters: {
                    books: [],
                    scholars: [],
                    degrees: [],
                    narrators: [],
                    searchZone: '',
                    searchMethod: ''
                },

                async performSearch() {
                    if (!this.searchQuery.trim()) return;

                    this.loading = true;
                    this.error = null;
                    this.note = null;
                    this.currentPage = 1;

                    try {
                        const formData = new FormData();
                        formData.append('value', this.searchQuery);
                        formData.append('page', this.currentPage);

                        // Add filters
                        if (this.filters.books.length > 0) {
                            this.filters.books.forEach(book => formData.append('books[]', book));
                        }
                        if (this.filters.scholars.length > 0) {
                            this.filters.scholars.forEach(scholar => formData.append('scholars[]', scholar));
                        }
                        if (this.filters.degrees.length > 0) {
                            this.filters.degrees.forEach(degree => formData.append('degrees[]', degree));
                        }
                        if (this.filters.narrators.length > 0) {
                            this.filters.narrators.forEach(narrator => formData.append('narrators[]', narrator));
                        }
                        if (this.filters.searchZone) {
                            formData.append('search_zone', this.filters.searchZone);
                        }
                        if (this.filters.searchMethod) {
                            formData.append('search_method', this.filters.searchMethod);
                        }

                        const response = await fetch('{{ route("hadith-search.search") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        const result = await response.json();
                        console.log('API Response:', result);

                        if (result.success) {
                            this.searchResults = result.data.data || [];
                            this.metadata = result.data.metadata || {};
                            this.note = result.note || null;
                            
                            console.log('Search results:', this.searchResults);
                            console.log('Metadata:', this.metadata);
                        } else {
                            this.error = result.message || 'حدث خطأ أثناء البحث';
                            this.searchResults = [];
                        }
                    } catch (error) {
                        console.error('Search error:', error);
                        this.error = 'حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.';
                        this.searchResults = [];
                    } finally {
                        this.loading = false;
                    }
                },

                async loadPage(page) {
                    if (page < 1) return;
                    
                    this.currentPage = page;
                    this.loading = true;

                    try {
                        const formData = new FormData();
                        formData.append('value', this.searchQuery);
                        formData.append('page', this.currentPage);

                        // Add filters
                        if (this.filters.books.length > 0) {
                            this.filters.books.forEach(book => formData.append('books[]', book));
                        }
                        if (this.filters.scholars.length > 0) {
                            this.filters.scholars.forEach(scholar => formData.append('scholars[]', scholar));
                        }
                        if (this.filters.degrees.length > 0) {
                            this.filters.degrees.forEach(degree => formData.append('degrees[]', degree));
                        }
                        if (this.filters.narrators.length > 0) {
                            this.filters.narrators.forEach(narrator => formData.append('narrators[]', narrator));
                        }
                        if (this.filters.searchZone) {
                            formData.append('search_zone', this.filters.searchZone);
                        }
                        if (this.filters.searchMethod) {
                            formData.append('search_method', this.filters.searchMethod);
                        }

                        const response = await fetch('{{ route("hadith-search.search") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            this.searchResults = result.data.data || [];
                            this.metadata = result.data.metadata || {};
                            this.note = result.note || null;
                        } else {
                            this.error = result.message || 'حدث خطأ أثناء البحث';
                        }
                    } catch (error) {
                        this.error = 'حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.';
                    } finally {
                        this.loading = false;
                    }
                },

                getGradeColor(grade) {
                    if (!grade) return 'bg-gray-100 text-gray-800';
                    
                    const gradeText = grade.toLowerCase();
                    if (gradeText.includes('صحيح')) {
                        return 'bg-green-100 text-green-800';
                    } else if (gradeText.includes('ضعيف')) {
                        return 'bg-red-100 text-red-800';
                    } else if (gradeText.includes('حسن')) {
                        return 'bg-yellow-100 text-yellow-800';
                    } else {
                        return 'bg-gray-100 text-gray-800';
                    }
                }
            }
        }
    </script>
    @endpush
</x-app-layout> 