<?php component('header') ?>

<title>Register</title>

<section class="h-full min-h-screen bg-slate-100">
    <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">
                Create A New Account
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="px-6 py-12 bg-white shadow sm:rounded-lg sm:px-12">

                <?php component('flash-message') ?>

                <form class="space-y-6" action="<?php __(url('/register')) ?>" method="POST">
                    <div>
                        <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First Name <span class="text-red-600 text-sm">*</span></label>
                        <div class="mt-2">
                            <input id="first_name" name="first_name" type="text" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 p-2">
                        </div>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
                        <div class="mt-2">
                            <input id="last_name" name="last_name" type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 p-2">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address <span class="text-red-600 text-sm">*</span></label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 p-2 sm:text-sm sm:leading-6" />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password <span class="text-red-600 text-sm">*</span></label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6" />
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="cursor-pointer flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            Register
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-10 text-sm text-center text-gray-500">
                Already a customer?
                <a href="<?php __(url('/login')) ?>" class="font-semibold leading-6 text-blue-600 hover:text-blue-500">Sign-in</a>
            </p>
        </div>
    </div>
</section>

<?php component('footer') ?>