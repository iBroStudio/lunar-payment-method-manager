<div>
    @if($payment_method_id)
        <livewire:dynamic-component :is="$this->component" :key="$this->component" :cart="$this->cart" />
    @endif
</div>
