@props(['headers', 'rows'])

<div class="bg-surface shadow-sm rounded-lg overflow-hidden border border-border">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-border">
            <thead class="bg-background">
                <tr>
                    @foreach($headers as $header)
                        <th class="px-6 py-3 text-left text-xs font-medium text-muted uppercase tracking-wider">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-surface divide-y divide-border">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>