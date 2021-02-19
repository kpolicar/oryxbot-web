<div class="anchor" id="features"></div>
<section class="bg-gray-900 py-8">


    <div class="container mx-auto pt-4 pb-12">

        <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-100">
            {{ __('features.heading') }}
        </h2>
        <div class="w-full mb-4">
            <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
        </div>

        <div class="-mx-3 flex flex-wrap">
            <x-feature-card icon="expand">
                <x-slot name="title">
                    {{ __('features.ocr') }}
                </x-slot>
                {{ __('features.ocr_details') }}
            </x-feature-card>

            <x-feature-card icon="mouse-pointer">
                <x-slot name="title">
                    {{ __('features.human_like') }}
                </x-slot>
                {{ __('features.human_like_details') }}
            </x-feature-card>

            <x-feature-card icon="sync">
                <x-slot name="title">
                    {{ __('features.updates') }}
                </x-slot>
                {{ __('features.updates_details') }}
            </x-feature-card>

            <x-feature-card icon="comments">
                <x-slot name="title">
                    {{ __('features.community') }}
                </x-slot>
                {{ __('features.community_details') }}
            </x-feature-card>

            <x-feature-card icon="code">
                <x-slot name="title">
                    {{ __('features.scriptless') }}
                </x-slot>
                {{ __('features.scriptless_details') }}
            </x-feature-card>

            <x-feature-card icon="bell">
                <x-slot name="title">
                    {{ __('features.notifications') }}
                </x-slot>
                {{ __('features.notifications_details') }}
            </x-feature-card>

        </div>
    </div>

</section>
