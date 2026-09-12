<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-sm btn-flex justify-content-center btn-light-primary']) }}>
    <span class="indicator-label">{{ $slot }}</span>
    <span class="indicator-progress">الرجاء الانتظار
        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
</button>
