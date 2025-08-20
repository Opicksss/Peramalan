<script>
    $(document).ready(function() {
        $('#Transaction-History').DataTable({
            lengthMenu: [
                [6, 10, 20, -1],
                [6, 10, 20, 'Todos']
            ]
        });
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            lengthChange: false,
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }
            ]
        });

        table.buttons().container()
            .appendTo('#datatable_wrapper .col-md-6:eq(0)');
    });
</script>


<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>

@if (session('success') || session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastLiveExample = document.getElementById('liveToast');
            const toastTime = document.getElementById('toastTime');

            // Set waktu saat ini
            const currentTime = new Date();
            const formattedTime = currentTime.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
            toastTime.textContent = formattedTime;

            const toast = new bootstrap.Toast(toastLiveExample);
            toast.show();
        });
    </script>
@endif


<script>
    $(document).ready(function() {
        $('[title]').tooltip();
        $('[data-bs-toggle="popover"]').popover();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleIcon = document.getElementById('toggleIcon');

        toggleIcon.addEventListener('click', function() {
            if (toggleIcon.classList.contains('bxs-chevrons-left')) {
                toggleIcon.classList.remove('bxs-chevrons-left');
                toggleIcon.classList.add('bxs-chevrons-right'); // Ganti dengan nama ikon yang valid
            } else {
                toggleIcon.classList.remove('bxs-chevrons-right');
                toggleIcon.classList.add('bxs-chevrons-left'); // Kembali ke ikon awal
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#hide_password input').attr("type") == "text") {
                $('#hide_password input').attr('type', 'password');
                $('#hide_password i').addClass("bx-hide");
                $('#hide_password i').removeClass("bx-show");
            } else if ($('#hide_password input').attr("type") == "password") {
                $('#hide_password input').attr('type', 'text');
                $('#hide_password i').removeClass("bx-hide");
                $('#hide_password i').addClass("bx-show");
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#hide_show_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#hide_show_password input').attr("type") == "text") {
                $('#hide_show_password input').attr('type', 'password');
                $('#hide_show_password i').addClass("bx-hide");
                $('#hide_show_password i').removeClass("bx-show");
            } else if ($('#hide_show_password input').attr("type") == "password") {
                $('#hide_show_password input').attr('type', 'text');
                $('#hide_show_password i').removeClass("bx-hide");
                $('#hide_show_password i').addClass("bx-show");
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const openModalButton = document.getElementById('openModalButton');
        const confirmSubmitButton = document.getElementById('confirmSubmit');
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));

        // Tampilkan modal saat tombol "Save Changes" ditekan
        openModalButton.addEventListener('click', function() {
            confirmationModal.show();
        });

        // Kirim formulir saat tombol konfirmasi di modal ditekan
        confirmSubmitButton.addEventListener('click', function() {
            confirmationModal.hide();
            form.submit();
        });
    });
</script>
