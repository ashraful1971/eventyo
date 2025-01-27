<?php component('header') ?>

<title><?php __($data['page_title']) ?></title>

<section class="bg-cover bg-center px-12 py-16" style="background-image: url(<?php __(url('public/images/beams.jpg')) ?>);">
    <div class="flex flex-col gap-10 lg:flex-row pt-10">
        <div class="w-full space-y-4">
            <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl">
                <?php __($data['event']->name) ?>
                <?php __($data['is_expired'] ? '<span class="px-2 py-1 rounded-full text-xs text-white bg-red-500 align-top">Expired</span>' : '') ?>
                <?php __($data['is_full'] ? '<span class="px-2 py-1 rounded-full text-xs text-white bg-yellow-500 align-top">Full</span>' : '') ?>
            </h1>
            <div>📅 <?php __($data['event']->date) ?></div>
            <div>⏲️ <?php __($data['event']->time) ?></div>
            <div>📍 <?php __($data['event']->location) ?></div>
            <p class="my-4 text-lg font-normal text-gray-500">
                <?php __($data['event']->description) ?>
            </p>
        </div>
        <div class="w-full space-y-4">
            <form id="attendee_registration" class="bg-white shadow ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" action="<?php __(url('event/' . $data['event']->id . '/attendees')) ?>" method="POST">
                <div class="px-4 py-6 sm:p-8">
                    <h2 class="font-bold text-2xl text-black mb-4">Register Your Spot Now</h2>

                    <?php if ($data['is_expired'] || $data['is_full']) : ?>
                        <div class="p-4 my-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 border border-yellow-200" role="alert">
                            <strong>Notice! </strong>
                            <?php __($data['is_expired'] ? 'Event has already expired.' : 'Event is full.') ?>
                        </div>
                    <?php endif ?>

                    <div id="flash-message-success" class="hidden p-4 my-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert"><strong>Success! </strong><span id="success-msg"></span></div>
                    <div id="flash-message-error" class="hidden p-4 my-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert"><strong>Error! </strong><span id="error-msg"></span></div>

                    <div class="flex flex-col gap-y-6">
                        <div class="w-full">
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone</label>
                            <div class="mt-2">
                                <input type="text" name="phone" id="phone" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2">
                                <input type="email" name="email" id="email" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                            </div>
                        </div>

                        <button id="submit-btn" <?php __($data['is_expired'] || $data['is_full'] ? 'disabled' : '') ?> type="submit" class="w-full cursor-pointer px-3 py-2 bg-blue-600 hover:bg-blue-500 text-sm font-semibold text-white rounded-md shadow-sm disabled:bg-gray-400">
                            <?php __($data['is_expired'] || $data['is_full'] ? 'Unavailable' : 'Register') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('#attendee_registration').submit(function(e) {
            e.preventDefault();
            $('#submit-btn').attr('disabled', true);
            
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#submit-btn').attr('disabled', false);
                    $('#attendee_registration').trigger('reset');
                    $('#flash-message-success').show();
                    $('#success-msg').text(response?.message);

                    setTimeout(function() {
                        $('#flash-message-success').hide();
                    }, 2500);
                },
                error: function(response) {
                    $('#submit-btn').attr('disabled', false);
                    $('#flash-message-error').show();

                    $('#error-msg').text(response?.responseJSON?.message);
                    setTimeout(function() {
                        $('#flash-message-error').hide();
                    }, 2500);
                }
            });
        });
    });
</script>

<?php component('footer') ?>