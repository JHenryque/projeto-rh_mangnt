<div class="d-flex gap-5">
    <div>
        <i class="fa-solid fa-users me-3"></i>{{ auth()->user()->name }}
    </div>
    <div>
        <i class="fa-solid fa-users me-3"></i>{{ auth()->user()->role }}
    </div>
    <div>
        <i class="fa-solid fa-at me-3"></i>{{ auth()->user()->email }}
    </div>
    <div>
        <i class="fa-regular fa-calendar-days me-3"></i>{{ auth()->user()->created_at->format('d/m/y') }}
    </div>
</div>
