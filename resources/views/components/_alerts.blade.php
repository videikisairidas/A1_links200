<div id="messagesContainer" class="messages-container">
    @php $alertTypes = ['success', 'error', 'warning', 'info', 'danger']; @endphp

    @foreach ($alertTypes as $type)
        @if (session($type))
            <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                {{ session($type) }}
                <div class="alert-close btn-close" data-bs-dismiss="alert" aria-label="Close">x</div>
            </div>
        @endif
    @endforeach

    
</div>

<div id="errorsContainer">
@if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
             <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <div class="alert-close btn-close" data-bs-dismiss="alert" aria-label="Close">x</div>
        </div>
    @endif
</div>