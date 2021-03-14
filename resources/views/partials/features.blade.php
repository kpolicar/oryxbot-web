<div class="anchor" id="features"></div>
<section class="bg-gray-900 py-8">


    <div class="container mx-auto pt-4 pb-12">

        <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-100">
            {{ __('features.heading') }}
        </h2>
        <div class="w-full mb-4">
            <div class="h-1 mx-auto gradient w-64 opacity-75 my-0 py-0 rounded-t"></div>
        </div>

        <div class="-mx-3 flex flex-wrap">
            <x-feature-card icon="box-open">
                <x-slot name="title">
                    {{ __('features.external') }}
                </x-slot>
                {{ __('features.external_details') }}
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

            <x-feature-card icon="coins">
                <x-slot name="title">
                    {{ __('features.profitable') }}
                </x-slot>
                {{ __('features.profitable_details') }}
            </x-feature-card>

            <x-feature-card icon="code">
                <x-slot name="title">
                    {{ __('features.scriptless') }}
                </x-slot>
                {{ __('features.scriptless_details') }}
            </x-feature-card>

            <x-feature-card icon="route" :tags="['in-development']">
                <x-slot name="title">
                    {{ __('features.customizable') }}
                </x-slot>
                {{ __('features.customizable_details') }}
            </x-feature-card>

        </div>
    </div>

</section>
