@php
    $platformLabels = [
        'google_meet' => 'Google Meet',
        'zoom' => 'Zoom',
        'teams' => 'Microsoft Teams',
        'other' => 'Other',
    ];

    $platformIcons = [
        'google_meet' => 'bi-camera-video-fill',
        'zoom' => 'bi-camera-reels-fill',
        'teams' => 'bi-microsoft-teams',
        'other' => 'bi-link-45deg',
    ];

    $statusBadge = match ($liveClass->status) {
        'live' => ['label' => 'Live Now', 'class' => 'bg-success-subtle text-success-emphasis'],
        'scheduled' => ['label' => 'Scheduled', 'class' => 'bg-info-subtle text-info-emphasis'],
        'completed' => ['label' => 'Completed', 'class' => 'bg-secondary-subtle text-secondary-emphasis'],
        'cancelled' => ['label' => 'Cancelled', 'class' => 'bg-danger-subtle text-danger-emphasis'],
        default => ['label' => ucfirst($liveClass->status), 'class' => 'bg-secondary-subtle text-secondary-emphasis'],
    };

    $canJoin = in_array($liveClass->status, ['scheduled', 'live']) && $liveClass->meeting_url;
@endphp

<div
    class="card border-0 shadow-sm rounded-4 h-100 lc-card
    @if ($variant === 'live') border-start border-4 border-success @endif
    @if ($variant === 'past') opacity-75 @endif">

    <div class="card-body p-3 p-md-4 d-flex flex-column gap-3">

        {{-- Top row: status + platform --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">

            <span class="badge rounded-pill {{ $statusBadge['class'] }} px-3 py-2 fw-semibold">
                @if ($liveClass->status === 'live')
                    <span class="lc-pulse-dot d-inline-block me-1" style="width:6px;height:6px;"></span>
                @endif
                {{ $statusBadge['label'] }}
            </span>

            <span class="badge rounded-pill bg-light text-secondary border px-3 py-2">
                <i class="bi {{ $platformIcons[$liveClass->platform] ?? 'bi-link-45deg' }} me-1"></i>
                {{ $platformLabels[$liveClass->platform] ?? ucfirst($liveClass->platform) }}
            </span>

        </div>


        {{-- Title + course --}}
        <div>
            <h3 class="h6 fw-bold text-dark mb-1">
                {{ $liveClass->title }}
            </h3>

            <p class="small text-muted mb-0 d-flex align-items-center gap-1">
                <i class="bi bi-mortarboard"></i>
                {{ $liveClass->course?->title ?? '—' }}
            </p>
        </div>


        {{-- Module / Cohort tags (only when present) --}}
        @if ($liveClass->module || $liveClass->cohort)
            <div class="d-flex flex-wrap gap-2">

                @if ($liveClass->module)
                    <span class="badge rounded-pill bg-light text-secondary border px-2 py-1 fw-normal">
                        <i class="bi bi-diagram-3 me-1"></i>
                        {{ $liveClass->module->title }}
                    </span>
                @endif

                @if ($liveClass->cohort)
                    <span class="badge rounded-pill bg-light text-secondary border px-2 py-1 fw-normal">
                        <i class="bi bi-people me-1"></i>
                        {{ $liveClass->cohort->name }}
                    </span>
                @endif

            </div>
        @endif


        {{-- Description --}}
        @if ($liveClass->description)
            <p class="small text-muted mb-0">
                {{ \Illuminate\Support\Str::limit($liveClass->description, 200) }}
            </p>
        @endif


        <hr class="my-1 text-muted opacity-25">


        {{-- Facilitator / Date / Time --}}
        <div class="d-flex flex-column gap-2 small text-secondary">

            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-video3 text-primary"></i>
                <span>{{ $liveClass->facilitator?->name ?? 'null' }}</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-calendar-event text-primary"></i>
                <span>{{ $liveClass->date?->format('D, M d, Y') }}</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-clock text-primary"></i>
                <span>
                    {{ \Carbon\Carbon::parse($liveClass->start_time)->format('g:i A') }}
                    &ndash;
                    {{ \Carbon\Carbon::parse($liveClass->end_time)->format('g:i A') }}
                </span>
            </div>

        </div>


        {{-- Join button --}}
        @if ($canJoin)
            <a href="{{ $liveClass->meeting_url }}" target="_blank" rel="noopener"
                class="btn {{ $variant === 'live' ? 'btn-success' : 'btn-primary' }} rounded-pill fw-semibold lc-join-btn mt-1">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                {{ $variant === 'live' ? 'Join Now' : 'Join Class' }}
            </a>
        @elseif ($liveClass->status === 'cancelled')
            <div class="text-center small text-danger fw-medium mt-1">
                <i class="bi bi-x-circle me-1"></i>
                This session was cancelled.
            </div>
        @elseif ($liveClass->status === 'completed')
            <div class="text-center small text-muted mt-1">
                <i class="bi bi-check-circle me-1"></i>
                Session ended.
            </div>
        @endif

    </div>

</div>
