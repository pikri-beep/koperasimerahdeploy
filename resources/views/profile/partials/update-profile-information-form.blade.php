<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- ========================
         FORM 1 — UPLOAD FOTO
         (berdiri sendiri, terpisah)
    ======================== --}}
    <form action="{{ route('profile.uploadFoto') }}" method="POST"
          enctype="multipart/form-data" class="mt-6">
        @csrf
        <div class="upload-row">
            <div class="form-group-custom">
                <label class="form-label-custom" for="foto">Ganti Foto</label>
                <div class="file-upload-wrapper">
                    <input type="file"
                        class="@error('foto') is-invalid @enderror"
                        id="foto" name="foto" accept="image/*"
                        onchange="previewFoto(this)">
                </div>
                @error('foto')
                    <div class="invalid-msg">{{ $message }}</div>
                @enderror
                <div class="field-hint">Format: JPG, PNG, GIF — Maks. 2MB</div>
            </div>
            <div>

                <style>
                    .btn-upload{
                        background: rgb(43, 36, 36);
                        color: white;
                        padding: 5px;
                        border-radius: 5px
                    }
                    .btn-upload:hover{
                        background: rgb(150, 148, 148)
                    }
                </style>

                <button type="submit" class="btn-upload">
                    Upload Foto
                </button>

               



            </div>
        </div>
    </form>

    {{-- ========================
         FORM 2 — UPDATE NAMA & EMAIL
         (berdiri sendiri, terpisah)
    ======================== --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-600">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
