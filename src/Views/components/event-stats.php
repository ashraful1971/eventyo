<dl class="mx-auto grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-4">
    <div class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-10 sm:px-6 xl:px-8">
        <dt class="text-sm font-medium leading-6 text-gray-500">
            Total Events
        </dt>
        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
            <?php __(count(authUser()->events)) ?>
        </dd>
    </div>
</dl>