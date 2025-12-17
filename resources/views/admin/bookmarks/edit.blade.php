<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="bookmark"
            title="{{ __('admin.bookmarks.edit') }}"
            description="{{ __('admin.bookmarks.edit_description') }}"
            :breadcrumbs="[
                ['label' => __('admin.bookmarks.breadcrumbs'), 'url' => route('admin.bookmarks.index')],
                ['label' => __('admin.bookmarks.edit_bookmark')]
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.bookmarks.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    {{ __('admin.bookmarks.back_to_bookmarks') }}
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <form action="{{ route('admin.bookmarks.update', $bookmark) }}" 
                      method="POST"
                      class="p-6"
                      x-data="{
                          category: '{{ old('category', $bookmark->category) }}',
                          showNewCategory: false
                      }">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4 rounded-lg">
                            <div class="flex items-start">
                                <x-lucide-alert-circle class="h-5 w-5 text-red-400 mr-3 mt-0.5 flex-shrink-0" />
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-300">{{ __('admin.bookmarks.validation_errors') }}</h3>
                                    <ul class="mt-2 text-sm text-red-700 dark:text-red-400 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-6">
                        <!-- Title -->
                        <x-admin.form.text-input
                            name="title"
                            label="{{ __('admin.bookmarks.form.title') }}"
                            :value="old('title', $bookmark->title)"
                            required
                            placeholder="{{ __('admin.bookmarks.form.title_placeholder') }}"
                        >
                            <x-slot:help>
                                {{ __('admin.bookmarks.form.title_help') }}
                            </x-slot:help>
                        </x-admin.form.text-input>

                        <!-- Link -->
                        <x-admin.form.text-input
                            name="link"
                            label="{{ __('admin.bookmarks.form.link') }}"
                            :value="old('link', $bookmark->link)"
                            type="url"
                            placeholder="https://example.com/partner-link"
                        >
                            <x-slot:help>
                                {{ __('admin.bookmarks.form.link_help') }}
                            </x-slot:help>
                        </x-admin.form.text-input>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.bookmarks.form.category') }}
                            </label>
                            
                            <div class="space-y-3">
                                @if($categories->count() > 0)
                                    <select name="category"
                                            x-model="category"
                                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">{{ __('admin.bookmarks.form.select_category') }}</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                        <option value="__new__">{{ __('admin.bookmarks.form.create_new_category') }}</option>
                                    </select>
                                    
                                    <div x-show="category === '__new__'" x-cloak>
                                        <input type="text"
                                               name="new_category"
                                               placeholder="{{ __('admin.bookmarks.form.new_category_placeholder') }}"
                                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                @else
                                    <input type="text"
                                           name="category"
                                           value="{{ old('category', $bookmark->category) }}"
                                           placeholder="{{ __('admin.bookmarks.form.category_placeholder') }}"
                                           class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @endif
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('admin.bookmarks.form.category_help') }}
                                </p>
                            </div>
                        </div>

                        <!-- Notes -->
                        <x-admin.form.textarea
                            name="notes"
                            label="{{ __('admin.bookmarks.form.notes') }}"
                            :value="old('notes', $bookmark->notes)"
                            rows="6"
                            placeholder="{{ __('admin.bookmarks.form.notes_placeholder') }}"
                        >
                            <x-slot:help>
                                {{ __('admin.bookmarks.form.notes_help') }}
                            </x-slot:help>
                        </x-admin.form.textarea>

                        <!-- Metadata -->
                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('admin.bookmarks.metadata') }}
                            </h4>
                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <div>
                                    <span class="font-medium">{{ __('admin.bookmarks.created') }}:</span>
                                    {{ $bookmark->created_at->format('M d, Y H:i') }}
                                </div>
                                <div>
                                    <span class="font-medium">{{ __('admin.bookmarks.updated') }}:</span>
                                    {{ $bookmark->updated_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="button"
                                @click="if(confirm('{{ __('admin.bookmarks.delete_confirmation_message') }}')) { 
                                    document.getElementById('delete-form').submit(); 
                                }"
                                class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm text-sm font-medium text-red-700 dark:text-red-400 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                            <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                            {{ __('admin.bookmarks.delete_bookmark') }}
                        </button>
                        
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.bookmarks.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                {{ __('admin.bookmarks.cancel') }}
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <x-lucide-save class="w-4 h-4 mr-2" />
                                {{ __('admin.bookmarks.update_bookmark') }}
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Delete Form -->
                <form id="delete-form" 
                      action="{{ route('admin.bookmarks.destroy', $bookmark) }}" 
                      method="POST" 
                      class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>

