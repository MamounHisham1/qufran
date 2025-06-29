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
                    <div x-show="showAdvanced" x-transition class="space-y-6 mb-6">
                        <!-- Filter Controls -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">الفلاتر المتقدمة</h3>
                            <div class="flex items-center space-x-reverse space-x-2">
                                <!-- Export/Import Filters -->
                                <div class="flex items-center space-x-reverse space-x-1">
                                    <button 
                                        type="button"
                                        @click="exportFilters()"
                                        class="text-blue-600 hover:text-blue-800 text-xs font-medium px-2 py-1 border border-blue-300 rounded"
                                        title="تصدير الفلاتر"
                                    >
                                        <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        تصدير
                                    </button>
                                    <button 
                                        type="button"
                                        @click="importFilters()"
                                        class="text-green-600 hover:text-green-800 text-xs font-medium px-2 py-1 border border-green-300 rounded"
                                        title="استيراد الفلاتر"
                                    >
                                        <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                        </svg>
                                        استيراد
                                    </button>
                                </div>
                                <!-- Clear All Button -->
                                <button 
                                    type="button"
                                    @click="clearAllFilters()"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center px-3 py-1 border border-red-300 rounded"
                                >
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    مسح الكل
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Books Filter -->
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-gray-700">الكتب</label>
                                <div class="relative" x-data="{ showBooks: false }">
                                    <!-- Search Input -->
                                    <input 
                                        type="text" 
                                        x-model="filterSearch.books"
                                        @click="showBooks = true; filterSearch.books = ''"
                                        @keyup="showBooks = true"
                                        placeholder="ابحث أو اختر كتاب..."
                                        class="block w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200"
                                        dir="rtl"
                                    >
                                    
                                    <!-- Dropdown List -->
                                    <ul x-show="showBooks" 
                                        @click.away="showBooks = false"
                                        class="absolute z-50 mt-2 w-full bg-white rounded-lg shadow-xl border border-gray-200 max-h-60 overflow-y-auto">
                                        
                                        <!-- Select All/None Controls -->
                                        <li class="sticky top-0 bg-gray-50 border-b border-gray-200 px-4 py-2 flex justify-between items-center text-xs">
                                            <span class="text-gray-600" x-text="`${filters.books.length} من ${filterBooks().length} محدد`"></span>
                                            <div class="flex space-x-reverse space-x-2">
                                                <button type="button" @click="selectAllFilters('books')" 
                                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                                    تحديد الكل
                                                </button>
                                                <span class="text-gray-400">|</span>
                                                <button type="button" @click="clearFilterType('books')" 
                                                        class="text-red-600 hover:text-red-800 font-medium">
                                                    إلغاء الكل
                                                </button>
                                            </div>
                                        </li>
                                        
                                        <!-- Filter Items -->
                                        <template x-for="book in filterBooks()" :key="book.value">
                                            <li @click="toggleFilter('books', book)" 
                                                class="px-4 py-3 hover:bg-teal-50 cursor-pointer transition-colors duration-200 flex items-center justify-between"
                                                :class="{'bg-teal-100': filters.books.includes(book.value)}">
                                                <span x-text="book.key" class="text-sm text-gray-800" dir="rtl"></span>
                                                <svg x-show="filters.books.includes(book.value)" class="w-4 h-4 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </li>
                                        </template>
                                        
                                        <li x-show="filterBooks().length === 0" class="px-4 py-3 text-gray-500 text-center text-sm">
                                            لا توجد نتائج
                                        </li>
                                    </ul>
                                </div>
                                
                                <!-- Selected Items -->
                                <div x-show="filters.books.length > 0" class="flex flex-wrap gap-2 mt-2">
                                    <template x-for="bookId in filters.books" :key="bookId">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                            <span x-text="getFilterLabel('books', bookId)"></span>
                                            <button type="button" @click="removeFilter('books', bookId)" class="mr-1 text-teal-600 hover:text-teal-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <!-- Scholars Filter -->
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-gray-700">المحدثين</label>
                                <div class="relative" x-data="{ showScholars: false }">
                                    <!-- Search Input -->
                                    <input 
                                        type="text" 
                                        x-model="filterSearch.scholars"
                                        @click="showScholars = true; filterSearch.scholars = ''"
                                        @keyup="showScholars = true"
                                        placeholder="ابحث أو اختر محدث..."
                                        class="block w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200"
                                        dir="rtl"
                                    >
                                    
                                    <!-- Dropdown List -->
                                    <ul x-show="showScholars" 
                                        @click.away="showScholars = false"
                                        class="absolute z-50 mt-2 w-full bg-white rounded-lg shadow-xl border border-gray-200 max-h-60 overflow-y-auto">
                                        
                                        <!-- Select All/None Controls -->
                                        <li class="sticky top-0 bg-gray-50 border-b border-gray-200 px-4 py-2 flex justify-between items-center text-xs">
                                            <span class="text-gray-600" x-text="`${filters.scholars.length} من ${filterScholars().length} محدد`"></span>
                                            <div class="flex space-x-reverse space-x-2">
                                                <button type="button" @click="selectAllFilters('scholars')" 
                                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                                    تحديد الكل
                                                </button>
                                                <span class="text-gray-400">|</span>
                                                <button type="button" @click="clearFilterType('scholars')" 
                                                        class="text-red-600 hover:text-red-800 font-medium">
                                                    إلغاء الكل
                                                </button>
                                            </div>
                                        </li>
                                        
                                        <!-- Filter Items -->
                                        <template x-for="scholar in filterScholars()" :key="scholar.value">
                                            <li @click="toggleFilter('scholars', scholar)" 
                                                class="px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors duration-200 flex items-center justify-between"
                                                :class="{'bg-blue-100': filters.scholars.includes(scholar.value)}">
                                                <span x-text="scholar.key" class="text-sm text-gray-800" dir="rtl"></span>
                                                <svg x-show="filters.scholars.includes(scholar.value)" class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </li>
                                        </template>
                                        
                                        <li x-show="filterScholars().length === 0" class="px-4 py-3 text-gray-500 text-center text-sm">
                                            لا توجد نتائج
                                        </li>
                                    </ul>
                                </div>
                                
                                <!-- Selected Items -->
                                <div x-show="filters.scholars.length > 0" class="flex flex-wrap gap-2 mt-2">
                                    <template x-for="scholarId in filters.scholars" :key="scholarId">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <span x-text="getFilterLabel('scholars', scholarId)"></span>
                                            <button type="button" @click="removeFilter('scholars', scholarId)" class="mr-1 text-blue-600 hover:text-blue-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <!-- Hadith Grade Filter -->
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-gray-700">درجة الحديث</label>
                                <div class="relative" x-data="{ showDegrees: false }">
                                    <!-- Search Input -->
                                    <input 
                                        type="text" 
                                        x-model="filterSearch.degrees"
                                        @click="showDegrees = true; filterSearch.degrees = ''"
                                        @keyup="showDegrees = true"
                                        placeholder="ابحث أو اختر درجة..."
                                        class="block w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200"
                                        dir="rtl"
                                    >
                                    
                                    <!-- Dropdown List -->
                                    <ul x-show="showDegrees" 
                                        @click.away="showDegrees = false"
                                        class="absolute z-50 mt-2 w-full bg-white rounded-lg shadow-xl border border-gray-200 max-h-60 overflow-y-auto">
                                        
                                        <!-- Select All/None Controls -->
                                        <li class="sticky top-0 bg-gray-50 border-b border-gray-200 px-4 py-2 flex justify-between items-center text-xs">
                                            <span class="text-gray-600" x-text="`${filters.degrees.length} من ${filterDegrees().length} محدد`"></span>
                                            <div class="flex space-x-reverse space-x-2">
                                                <button type="button" @click="selectAllFilters('degrees')" 
                                                        class="text-blue-600 hover:text-blue-800 font-medium">
                                                    تحديد الكل
                                                </button>
                                                <span class="text-gray-400">|</span>
                                                <button type="button" @click="clearFilterType('degrees')" 
                                                        class="text-red-600 hover:text-red-800 font-medium">
                                                    إلغاء الكل
                                                </button>
                                            </div>
                                        </li>
                                        
                                        <!-- Filter Items -->
                                        <template x-for="degree in filterDegrees()" :key="degree.value">
                                            <li @click="toggleFilter('degrees', degree)" 
                                                class="px-4 py-3 hover:bg-green-50 cursor-pointer transition-colors duration-200 flex items-center justify-between"
                                                :class="{'bg-green-100': filters.degrees.includes(degree.value)}">
                                                <span x-text="degree.key" class="text-sm text-gray-800" dir="rtl"></span>
                                                <svg x-show="filters.degrees.includes(degree.value)" class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </li>
                                        </template>
                                        
                                        <li x-show="filterDegrees().length === 0" class="px-4 py-3 text-gray-500 text-center text-sm">
                                            لا توجد نتائج
                                        </li>
                                    </ul>
                                </div>
                                
                                <!-- Selected Items -->
                                <div x-show="filters.degrees.length > 0" class="flex flex-wrap gap-2 mt-2">
                                    <template x-for="degreeId in filters.degrees" :key="degreeId">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span x-text="getFilterLabel('degrees', degreeId)"></span>
                                            <button type="button" @click="removeFilter('degrees', degreeId)" class="mr-1 text-green-600 hover:text-green-800">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <!-- Search Method -->
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-gray-700">طريقة البحث</label>
                                <select x-model="filters.searchMethod" class="block w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200">
                                    <option value="">الطريقة الافتراضية</option>
                                    @foreach($searchMethods as $method)
                                        <option value="{{ $method['value'] }}">{{ $method['key'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Active Filters Summary -->
                        <div x-show="hasActiveFilters()" class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-medium text-gray-700">الفلاتر المفعلة</h4>
                                <span class="text-xs text-gray-500" x-text="`${getActiveFiltersCount()} فلتر مفعل`"></span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <!-- Books -->
                                <template x-for="bookId in filters.books" :key="'summary-book-' + bookId">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                        كتاب: <span x-text="getFilterLabel('books', bookId)" class="mr-1"></span>
                                        <button type="button" @click="removeFilter('books', bookId)" class="mr-1 text-teal-600 hover:text-teal-800">×</button>
                                    </span>
                                </template>
                                <!-- Scholars -->
                                <template x-for="scholarId in filters.scholars" :key="'summary-scholar-' + scholarId">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        محدث: <span x-text="getFilterLabel('scholars', scholarId)" class="mr-1"></span>
                                        <button type="button" @click="removeFilter('scholars', scholarId)" class="mr-1 text-blue-600 hover:text-blue-800">×</button>
                                    </span>
                                </template>
                                <!-- Degrees -->
                                <template x-for="degreeId in filters.degrees" :key="'summary-degree-' + degreeId">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        درجة: <span x-text="getFilterLabel('degrees', degreeId)" class="mr-1"></span>
                                        <button type="button" @click="removeFilter('degrees', degreeId)" class="mr-1 text-green-600 hover:text-green-800">×</button>
                                    </span>
                                </template>
                            </div>
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
                            <div class="text-gray-600">
                                <span x-text="`الصفحة ${currentPage} - عرض ${searchResults.length} نتيجة`"></span>
                                <span x-show="metadata.numberOfNonSpecialist" x-text="`من إجمالي ${metadata.numberOfNonSpecialist} حديث`"></span>
                            </div>
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
                                        <span x-text="hadith.grade || hadith.explainGrade || 'غير محدد'"></span>
                                    </span>
                                </div>

                                <!-- Additional Info -->
                                <div x-show="hadith.explainGrade && hadith.explainGrade !== hadith.grade" class="mt-3 text-sm text-gray-600">
                                    <span class="font-semibold">توضيح الدرجة:</span>
                                    <span x-text="hadith.explainGrade"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Pagination -->
                    <div x-show="searchResults.length > 0 && shouldShowPagination()" class="mt-8">
                        <div class="flex justify-center items-center space-x-reverse space-x-4">
                            <!-- Previous Button -->
                            <button 
                                @click="loadPage(currentPage - 1)"
                                :disabled="currentPage <= 1 || loading"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                السابق
                            </button>
                            
                            <!-- Page Info -->
                            <div class="flex items-center space-x-reverse space-x-2">
                                <span class="text-sm text-gray-700">الصفحة</span>
                                <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-md font-medium" x-text="currentPage"></span>
                                <span x-show="getTotalPages() > 0" class="text-sm text-gray-700" x-text="`من ${getTotalPages()}`"></span>
                            </div>
                            
                            <!-- Next Button -->
                            <button 
                                @click="loadPage(currentPage + 1)"
                                :disabled="!hasNextPage() || loading"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                            >
                                التالي
                            </button>
                        </div>
                        
                        <!-- Results Summary -->
                        <div class="text-center mt-4 text-sm text-gray-600">
                            <span x-show="metadata.numberOfNonSpecialist">
                                عرض <span x-text="((currentPage - 1) * (metadata.length || 30)) + 1"></span> - 
                                <span x-text="Math.min(currentPage * (metadata.length || 30), metadata.numberOfNonSpecialist)"></span>
                                من إجمالي <span x-text="metadata.numberOfNonSpecialist"></span> حديث
                            </span>
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
                    searchMethod: ''
                },
                filterSearch: {
                    books: '',
                    scholars: '',
                    degrees: '',
                },
                filteredBooks: [],
                filteredScholars: [],
                filteredDegrees: [],

                init() {
                    // Initialize filter data only once
                    this.filteredBooks = @json($books);
                    this.filteredScholars = @json($scholars);
                    this.filteredDegrees = @json($degrees);
                },

                filterBooks() {
                    const searchTerm = this.filterSearch.books.toLowerCase();
                    if (!searchTerm) {
                        return @json($books);
                    }
                    return @json($books).filter(book => 
                        book.key.toLowerCase().includes(searchTerm)
                    );
                },

                filterScholars() {
                    const searchTerm = this.filterSearch.scholars.toLowerCase();
                    if (!searchTerm) {
                        return @json($scholars);
                    }
                    return @json($scholars).filter(scholar => 
                        scholar.key.toLowerCase().includes(searchTerm)
                    );
                },

                filterDegrees() {
                    const searchTerm = this.filterSearch.degrees.toLowerCase();
                    if (!searchTerm) {
                        return @json($degrees);
                    }
                    return @json($degrees).filter(degree => 
                        degree.key.toLowerCase().includes(searchTerm)
                    );
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
                            this.searchResults = [];
                        }
                    } catch (error) {
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
                },

                shouldShowPagination() {
                    // Show pagination if we have results and either:
                    // 1. Current page results equal the page size (likely more pages)
                    // 2. Total count indicates more results
                    // 3. Current page > 1
                    const pageSize = this.metadata.length || 30;
                    const totalResults = this.metadata.numberOfNonSpecialist || 0;
                    
                    return this.searchResults.length > 0 && (
                        this.currentPage > 1 || 
                        this.searchResults.length >= pageSize ||
                        totalResults > pageSize
                    );
                },

                hasNextPage() {
                    // Check if there's a next page based on:
                    // 1. Current results equal page size (likely more pages)
                    // 2. Total count indicates more results
                    const pageSize = this.metadata.length || 30;
                    const totalResults = this.metadata.numberOfNonSpecialist || 0;
                    const currentResultsShown = (this.currentPage - 1) * pageSize + this.searchResults.length;
                    
                    return this.searchResults.length >= pageSize || currentResultsShown < totalResults;
                },

                getTotalPages() {
                    const pageSize = this.metadata.length || 30;
                    const totalResults = this.metadata.numberOfNonSpecialist || 0;
                    
                    if (totalResults > 0) {
                        return Math.ceil(totalResults / pageSize);
                    }
                    
                    // If we don't have total count, estimate based on current page
                    if (this.searchResults.length >= pageSize) {
                        return this.currentPage + 1; // At least one more page
                    }
                    
                    return this.currentPage;
                },

                toggleFilter(filterType, item) {
                    if (this.filters[filterType].includes(item.value)) {
                        this.filters[filterType] = this.filters[filterType].filter(i => i !== item.value);
                    } else {
                        this.filters[filterType].push(item.value);
                    }
                },

                removeFilter(filterType, value) {
                    this.filters[filterType] = this.filters[filterType].filter(v => v !== value);
                },

                getFilterLabel(filterType, value) {
                    let item;
                    let dataSource;
                    
                    // Use raw data directly to avoid any potential issues with filter functions
                    switch(filterType) {
                        case 'books':
                            dataSource = @json($books);
                            item = dataSource.find(b => b.value === value);
                            break;
                        case 'scholars':
                            dataSource = @json($scholars);
                            item = dataSource.find(s => s.value === value);
                            break;
                        case 'degrees':
                            dataSource = @json($degrees);
                            item = dataSource.find(d => d.value === value);
                            break;
                        default:
                            return value;
                    }
                    const result = item ? item.key : value;
                    return result;
                },

                hasActiveFilters() {
                    return Object.values(this.filters).some(filter => filter.length > 0);
                },

                getActiveFiltersCount() {
                    return Object.values(this.filters).reduce((count, filter) => count + filter.length, 0);
                },

                clearAllFilters() {
                    this.filters = {
                        books: [],
                        scholars: [],
                        degrees: [],
                        searchMethod: ''
                    };
                    this.filterSearch = {
                        books: '',
                        scholars: '',
                        degrees: ''
                    };
                },

                selectAllFilters(filterType) {
                    const allItems = this.getFilterData(filterType);
                    this.filters[filterType] = allItems.map(item => item.value);
                },

                clearFilterType(filterType) {
                    this.filters[filterType] = [];
                },

                getFilterData(filterType) {
                    switch(filterType) {
                        case 'books': return this.filterBooks();
                        case 'scholars': return this.filterScholars();
                        case 'degrees': return this.filterDegrees();
                        default: return [];
                    }
                },

                handleKeydown(event, filterType, item) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        this.toggleFilter(filterType, item);
                    }
                },

                getFilterTypeLabel(filterType) {
                    const labels = {
                        books: 'الكتب',
                        scholars: 'المحدثين',
                        degrees: 'درجات الأحاديث'
                    };
                    return labels[filterType] || filterType;
                },

                exportFilters() {
                    const activeFilters = {};
                    Object.keys(this.filters).forEach(key => {
                        if (this.filters[key].length > 0 || this.filters[key] !== '') {
                            activeFilters[key] = this.filters[key];
                        }
                    });
                    
                    const filterString = JSON.stringify(activeFilters);
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(filterString).then(() => {
                            alert('تم نسخ الفلاتر إلى الحافظة');
                        }).catch(() => {
                            prompt('انسخ الفلاتر من هنا:', filterString);
                        });
                    } else {
                        prompt('انسخ الفلاتر من هنا:', filterString);
                    }
                },

                importFilters() {
                    const filterString = prompt('الصق الفلاتر المحفوظة:');
                    if (filterString) {
                        try {
                            const importedFilters = JSON.parse(filterString);
                            this.filters = { ...this.filters, ...importedFilters };
                        } catch (error) {
                            alert('خطأ في تنسيق الفلاتر');
                        }
                    }
                },

                isFilterSelected(filterType, value) {
                    return this.filters[filterType].includes(value);
                },

                getSelectedCount(filterType) {
                    return this.filters[filterType].length;
                },

                getTotalFilterCount(filterType) {
                    return this.getFilterData(filterType).length;
                }
            }
        }
    </script>
    @endpush
</x-app-layout> 