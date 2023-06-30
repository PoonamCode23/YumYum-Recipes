<section class="space-y-6">
    <header>
        <h3 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h3>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="btn btn-primary">{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable id="confirm-user-deletion">
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 red-bordered">
            @csrf
            @method('delete')

            <h4 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h4>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 form-control" placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="btn btn-danger ms-3">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
<style>
    .red-bordered {
        border: 2px solid red;
        border-radius: 8px;
        padding: 20px;
        margin-top: 10px;
    }
</style>