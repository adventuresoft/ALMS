@php
    $steps = [
        [
            'key' => 'personal',
            'label' => 'Personal',
            'icon' => 'fas fa-user',
            'url' => isset($user->id) ? route('farmer.edit', $user->id) : '#',
            'clickable' => isset($user->id)
        ],
        [
            'key' => 'family',
            'label' => 'Family',
            'icon' => 'fas fa-users',
            'url' => isset($user->id) ? route('farmer.family', $user->id) : '#',
            'clickable' => isset($user->id)
        ],
        [
            'key' => 'address',
            'label' => 'Address',
            'icon' => 'fas fa-map-marker-alt',
            'url' => isset($user->id) ? route('farmer.address', $user->id) : '#',
            'clickable' => isset($user->id)
        ],
        [
            'key' => 'cultivation',
            'label' => 'Cultivation',
            'icon' => 'fas fa-seedling',
            'url' => isset($user->id) ? route('farmer.cultivation', $user->id) : '#',
            'clickable' => isset($user->id)
        ],
        [
            'key' => 'land',
            'label' => 'Land Info',
            'icon' => 'fas fa-map',
            'url' => isset($user->id) ? route('farmer.land', $user->id) : '#',
            'clickable' => isset($user->id)
        ],
        [
            'key' => 'classification',
            'label' => 'Initial Loan Info',
            'icon' => 'fas fa-hand-holding-usd',
            'url' => isset($user->id) ? route('farmer.classification', $user->id) : '#',
            'clickable' => isset($user->id)
        ]
    ];

    // Find active step index
    $activeIndex = 0;
    foreach ($steps as $index => $step) {
        if ($step['key'] === $active_tab) {
            $activeIndex = $index;
            break;
        }
    }
@endphp

<style>
    /* Dynamically applied class to target card-header containing this stepper */
    .stepper-card-header {
        background-color: #ffffff !important;
        border-bottom: 1px solid #eef2f6 !important;
        padding: 24px 20px !important;
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
    }

    .farmer-stepper-wrapper {
        width: 100%;
        overflow-x: auto;
        padding: 10px 0;
        -webkit-overflow-scrolling: touch;
    }

    .farmer-stepper {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        width: 100%;
        position: relative;
        min-width: 850px; /* Prevent squishing on smaller layouts */
    }

    .stepper-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        width: 110px;
        text-align: center;
    }

    .stepper-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none !important;
        color: inherit;
        width: 100%;
        transition: transform 0.2s ease;
    }

    .stepper-link:hover:not(.disabled) {
        transform: translateY(-2px);
    }

    .stepper-link.disabled {
        cursor: default;
        pointer-events: none;
    }

    .stepper-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 12px;
    }

    .stepper-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        transition: color 0.3s ease;
        text-align: center;
        line-height: 1.4;
    }

    /* Connectors */
    .stepper-line {
        flex: 1;
        height: 3px;
        background-color: #e2e8f0;
        margin-top: 25px; /* Half of icon height (50px) */
        transform: translateY(-50%);
        z-index: 1;
        transition: background-color 0.3s ease;
    }

    /* Active State */
    .stepper-item.active .stepper-icon-box {
        background-color: #5e3cf7;
        border: 2px solid #5e3cf7;
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(94, 60, 247, 0.35);
    }

    .stepper-item.active .stepper-label {
        color: #5e3cf7;
    }

    /* Completed State */
    .stepper-item.completed .stepper-icon-box {
        background-color: #ecfdf5;
        border: 2px solid #10b981;
        color: #10b981;
        box-shadow: none;
    }

    .stepper-item.completed .stepper-label {
        color: #10b981;
    }

    .stepper-line.completed {
        background-color: #10b981;
    }

    /* Inactive State */
    .stepper-item.inactive .stepper-icon-box {
        background-color: #f8fafc;
        border: 2px solid #e2e8f0;
        color: #94a3b8;
    }

    .stepper-item.inactive .stepper-label {
        color: #94a3b8;
    }

    .stepper-line.inactive {
        background-color: #e2e8f0;
    }

    /* Professional jQuery UI Datepicker CSS Theme override */
    #ui-datepicker-div {
        display: none;
        background-color: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        padding: 16px !important;
        width: 290px !important;
        z-index: 9999 !important;
        font-family: inherit !important;
    }

    .ui-datepicker-header {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        position: relative !important;
        padding-bottom: 12px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        margin-bottom: 12px !important;
    }

    .ui-datepicker-title {
        display: flex !important;
        gap: 6px !important;
        align-items: center !important;
        justify-content: center !important;
        flex-grow: 1 !important;
        margin: 0 10px !important;
    }

    .ui-datepicker-title select {
        padding: 4px 6px !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        background-color: #ffffff !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #334155 !important;
        outline: none !important;
        cursor: pointer !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
    }

    .ui-datepicker-title select:focus {
        border-color: #5e3cf7 !important;
    }

    .ui-datepicker-prev, .ui-datepicker-next {
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 28px !important;
        height: 28px !important;
        border-radius: 6px !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #ffffff !important;
        color: #64748b !important;
        transition: all 0.2s ease !important;
    }

    .ui-datepicker-prev:hover, .ui-datepicker-next:hover {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
    }

    .ui-datepicker-prev span, .ui-datepicker-next span {
        display: none !important;
    }

    .ui-datepicker-prev::after {
        content: '\f053' !important; /* chevron-left */
        font-family: 'Font Awesome 5 Free' !important;
        font-weight: 900 !important;
        font-size: 11px !important;
    }

    .ui-datepicker-next::after {
        content: '\f054' !important; /* chevron-right */
        font-family: 'Font Awesome 5 Free' !important;
        font-weight: 900 !important;
        font-size: 11px !important;
    }

    .ui-datepicker-calendar {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    .ui-datepicker-calendar th {
        text-align: center !important;
        font-weight: 600 !important;
        font-size: 11px !important;
        color: #94a3b8 !important;
        padding-bottom: 8px !important;
        text-transform: uppercase !important;
    }

    .ui-datepicker-calendar td {
        padding: 2px !important;
        text-align: center !important;
    }

    .ui-datepicker-calendar td a {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 8px !important;
        color: #334155 !important;
        font-size: 13px !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
    }

    .ui-datepicker-calendar td a:hover {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
    }

    /* Today's date */
    .ui-datepicker-today a {
        background-color: #f8fafc !important;
        border: 1px solid #cbd5e1 !important;
        font-weight: bold !important;
    }

    /* Selected date */
    .ui-datepicker-current-day a {
        background-color: #5e3cf7 !important;
        color: #ffffff !important;
        font-weight: bold !important;
    }
</style>

<div class="farmer-stepper-wrapper">
    <div class="farmer-stepper">
        @foreach($steps as $index => $step)
            @php
                if ($index < $activeIndex) {
                    $statusClass = 'completed';
                } elseif ($index == $activeIndex) {
                    $statusClass = 'active';
                } else {
                    $statusClass = 'inactive';
                }
            @endphp
            
            <div class="stepper-item {{ $statusClass }}">
                @if($step['clickable'])
                    <a href="{{ $step['url'] }}" class="stepper-link">
                @else
                    <div class="stepper-link disabled">
                @endif
                    <div class="stepper-icon-box">
                        @if($statusClass === 'completed')
                            <i class="fas fa-check"></i>
                        @else
                            <i class="{{ $step['icon'] }}"></i>
                        @endif
                    </div>
                    <div class="stepper-label">{{ $step['label'] }}</div>
                @if($step['clickable'])
                    </a>
                @else
                    </div>
                @endif
            </div>

            @if(!$loop->last)
                <div class="stepper-line {{ $index < $activeIndex ? 'completed' : 'inactive' }}"></div>
            @endif
        @endforeach
    </div>
</div>

<script>
    (function() {
        function init() {
            var stepper = document.querySelector('.farmer-stepper-wrapper');
            if (stepper) {
                var cardHeader = stepper.closest('.card-header');
                if (cardHeader) {
                    cardHeader.classList.add('stepper-card-header');
                }
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
</script>
