<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('general.Profile') }}
        </h2>
    </x-slot>
    <!-- resources/views/components/toggle-table.blade.php -->
    <div x-data="{ tableVisible: false }" class="container mx-auto p-4 text-right">
        <button x-on:click="tableVisible = !tableVisible"
            class="mb-2 px-3 py-1 bg-teal-500 text-white rounded hover:bg-teal-600 transition duration-300">
            <span x-text="tableVisible ? 'إخفاء الفتاوى' : 'إظهار الفتاوى'"></span>
        </button>

        <div x-show="tableVisible" x-transition.duration.300ms class="overflow-x-auto">
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm bg-white">
                <thead>
                    <tr class="bg-teal-400 text-white">
                        <th class="p-4 text-right">{{ __('general.Number') }}</th>
                        <th class="p-4 text-right">{{ __('general.Is published') }}</th>
                        <th class="p-4 text-right">{{ __('general.The question') }}</th>
                        <th class="p-4 text-right">{{ __('general.The answer') }}</th>
                        <th class="p-4 text-right">{{ __('general.The link') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fatawa as $fatwa)
                        <tr class="border-b border-teal-200 transition">
                            <td class="p-4">{{ $fatwa->fatwa_number }}</td>
                            <td class="p-4">
                                @if ($fatwa->is_published)
                                    <span class="text-teal-800">
                                        {{ __('general.Public') }}
                                    </span>
                                @else
                                    <span class="text-red-800">
                                        {{ __('general.Private') }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-4">{{ str($fatwa->title)->limit(50, '...', true) }}</td>
                            <td class="p-4">
                                @if ($fatwa->body)
                                    {{ str($fatwa->body)->limit(50, '...', true) }}
                                @else
                                    <span class="text-red-800">
                                        <i class="fas fa-times"></i> {{ __('general.No answer yet') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($fatwa->body)
                                    <a href="{{ route('fatawa.show', $fatwa) }}" class="text-teal-800">
                                        {{ __('general.Click here') }}
                                    </a>
                                @else
                                    <span class="text-red-800">
                                        {{ __('general.No link yet') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
