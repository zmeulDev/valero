@props(['items' => []])

<div x-data="{
    showDeleteModal: false,
    itemToDelete: null,
    items: {{ json_encode($items) }},
    
    openDeleteModal(id) {
        this.itemToDelete = id;
        this.showDeleteModal = true;
    }
}">
    {{ $slot }}
</div> 