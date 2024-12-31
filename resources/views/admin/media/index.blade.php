<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header 
            icon="image" 
            title="Media Library" 
            description="Manage your media files and view statistics"
        >
            <x-slot:stats>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <x-admin.stats-card 
                        icon="image" 
                        label="Total Files" 
                        :value="$statistics['total_count']"
                    />
                    <x-admin.stats-card 
                        icon="hard-drive" 
                        iconColor="blue" 
                        label="Total Size" 
                        :value="$statistics['total_size'] . ' MB'"
                    />
                    <x-admin.stats-card 
                        icon="star" 
                        iconColor="yellow" 
                        label="Cover Images" 
                        :value="$statistics['cover_images']"
                    />
                    <x-admin.stats-card 
                        icon="images" 
                        iconColor="purple" 
                        label="Regular Images" 
                        :value="$statistics['regular_images']"
                    />
                </div>
            </x-slot:stats>

            <x-slot name="actions">
                <x-admin.form.search-filter 
                    :options="$statistics['by_type']->pluck('mime_type', 'mime_type')->map(function($type) {
                        return explode('/', $type)[1] ?? $type;
                    })"
                    searchPlaceholder="Search files..."
                    filterLabel="All Types"
                />
            </x-slot>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Media Grid --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-admin.media.gallery :media="$media" />
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
