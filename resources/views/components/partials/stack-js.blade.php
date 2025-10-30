@push('toast-message')
<script>
    // Auto remove toast after 3 seconds
    setTimeout(() => {
        const toast = document.getElementById("toast-simple");
        if (toast) {
            toast.remove();
        }
    }, 3000);
</script>
@endpush

@push('toast-style')
<style>
    @keyframes toastbar {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }

    .animate-toastbar {
        animation: toastbar 3s linear forwards;
    }
</style>
@endpush