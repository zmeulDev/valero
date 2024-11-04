@props(['items'])

<script>
function dataManager() {
    return {
        showDeleteModal: false,
        itemToDelete: null,
        users: @json($items),

        openDeleteModal(id) {
            this.itemToDelete = id;
            this.showDeleteModal = true;
        }
    }
}
</script> 