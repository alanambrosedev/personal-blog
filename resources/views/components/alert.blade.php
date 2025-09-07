<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('status') || session('success') || session('error') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @if ($errors->any())
                let messages = [];
                @foreach ($errors->all() as $error)
                    messages.push("{{ $error }}");
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: messages.join('<br>'),
                    showConfirmButton: true
                });
            @else
                Swal.fire({
                    icon: "{{ session('error') ? 'error' : 'success' }}",
                    title: "{{ session('error') ? 'Error!' : 'Success!' }}",
                    text: "{{ session('status') ?? (session('success') ?? session('error')) }}",
                    showConfirmButton: false,
                    timer: 2500
                });
            @endif

        });
    </script>
@endif
