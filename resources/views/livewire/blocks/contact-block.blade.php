<div>

    <div class="grid gap-16 lg:grid-cols-3">
        <div class="prose">
            @if($name = trim(cms('contact_name')))
                <p class="font-semibold">{{ cms('contact_name') }}</p>
            @endif

            @if($telephone = trim(cms('contact_telephone')))
                <p>
                    <a href="tel:{{ $telephone }}">
                        {{ $telephone }}
                    </a>
                </p>
            @endif

            @if($email = trim(cms('contact_email')))
                <a>
                    <a href="mailto:{{ $email }}" class="hover:cursor-pointer hover:text-brand">
                        {{ $email }}
                    </a>
                </p>
            @endif

            @if($address = trim(cms('contact_address')))
                <p>{!! nl2br($address)  !!} </p>
            @endif

        </div>
        <div class="lg:col-span-2">
            {!! cms('contact_map') !!}
        </div>
    </div>

</div>
