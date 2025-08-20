<div class="toast-container position-fixed end-0 top-0 p-3">
    <div id="liveToast" class="toast bg-dark" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-dark">
            <strong
                class="me-auto
                @if (session('success')) text-success
                @elseif(session('error')) text-danger @endif"><i class='bx bxs-bell-ring bx-tada me-1' ></i> Notification</strong>
            <small class="text-white" id="toastTime">Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('success') ?? session('error') }}
        </div>
    </div>
</div>
