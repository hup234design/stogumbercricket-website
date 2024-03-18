<div>
    @if( $submitted )
        <div class="border-2 bg-green-100 border-green-300 text-green-800 p-8 text-center">
            THANK YOU FOR YOUR  MESSAGE
        </div>
    @else
        <form method="POST" wire:submit="submit">
            <x-honeypot livewire-model="extraFields" />
            {{ $this->form }}
            <div class="mt-10">
                <button class="block w-full rounded-md bg-green-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    SUBMIT
                </button>
            </div>
        </form>
    @endif
</div>
