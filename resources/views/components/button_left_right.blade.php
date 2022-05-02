<div class="container">
    <div class="btn-group field-button-left-right">
        @if ($data['left']['show'])
            <a class="btn btn-primary btn-lg menu-modal-button button-left"  href="{{ url($data['left']['url']) }}">
                {{ $data['left']['content'] }}
            </a>
        @endif
        @if ($data['right']['show'])
            <a class="btn btn-primary btn-lg menu-modal-button button-right" href="{{ url($data['right']['url']) }}">
                {{ $data['right']['content'] }}
            </a>
        @endif
    </div>
</div>
<style>
@if ($data['left']['show'] && $data['right']['show'])
.button-left {
    border-right: 1px #35352b solid !important;
}
@endif
</style>