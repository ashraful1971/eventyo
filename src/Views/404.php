<?php component('header')?>

<main class="">
    <div class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12">
        <img src="<?php __(public_path('/images/beams.jpg'))?>" alt="" class="absolute top-1/2 left-1/2 max-w-none -translate-x-1/2 -translate-y-1/2" width="1308" />
        <div class="absolute inset-0 bg-[url(./images/grid.svg)] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
        <div class="relative bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-lg sm:rounded-lg sm:px-10">
            <div class="mx-auto max-w-xl">
                <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                    <div class="mx-auto w-full max-w-xl text-center">
                        <h1 class="block text-center font-bold text-3xl">404 Page Not Found</h1>
                        <h3 class="text-gray-500 my-2">The page was not found!</h3>
                    </div>

                    <div class="mt-10 mx-auto w-full max-w-xl">
                        <img src="<?php __(public_path('/images/404.png'))?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php component('footer') ?>