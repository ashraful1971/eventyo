<?php component('header') ?>

<style>
    .hero {
        background: linear-gradient(45deg, #f3e5f5, #e1bee7, #bbdefb, #b2ebf2, #c8e6c9, #fff9c4);
        background-size: 400% 400%;
        animation: gradientAnimation 10s ease infinite;
    }

    @keyframes gradientAnimation {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }
</style>

<title><?php __($data['page_title']) ?></title>

<!-- Hero Section -->
<section class="hero bg-blue-600 text-black py-20 text-center bg-center">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold mb-4">Discover and Manage Events</h1>
        <p class="text-lg">Join or create events seamlessly. No hassle, just fun!</p>
    </div>
</section>

<!-- Events Listing Section -->
<section class="container mx-auto px-6 py-12">
    <h2 class="text-3xl font-bold text-center mb-8">Latest Events</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if ($data['events']): ?>
            <?php foreach ($data['events'] as $event) : ?>
                <!-- Event Card 1 -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                    <a href="<?php __(url('/event/' . $event->id)) ?>">
                        <h3 class="text-xl font-bold text-blue-600 mb-2"><?php __($event->name) ?></h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-4"><?php __(the_excerpt($event->description)) ?></p>
                    <div class="flex justify-between text-sm text-gray-500 mb-4">
                        <span>📅 <?php __($event->date) ?></span>
                        <span>📍 <?php __($event->location) ?></span>
                    </div>
                    <a href="<?php __(url('/event/' . $event->id)) ?>" class="block w-full text-center text-sm bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition-colors">Register Now</a>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </div>
    <?php if (!$data['events']): ?>
        <div class="text-center p-4 text-sm text-gray-800">No events found.</div>
    <?php endif; ?>

    <!-- Pagination start  -->
    <div class="mt-8 flex justify-center items-center">
        <?php $last_page = ceil($data['count'] / $data['per_page']); ?>
        <?php if ($last_page > 1): ?>
            <nav class="flex gap-2 items-center">
                <span class="text-sm">Page</span>
                <?php for ($i = 1; $i <= $last_page; $i++): ?>
                    <?php if ($data['current_page'] != $i): ?>
                        <a href="<?php __(url('/?' . (request()->filter ? 'filter=' . request()->filter . '&' : '') . (request()->sort ? 'sort=' . request()->sort . '&' : '') . 'page=' . $i)) ?>" class="px-4 py-1 text-sm <?php __($data['current_page'] != $i ? 'bg-gray-100' : 'bg-gray-300') ?> text-black rounded border border-gray-300"><?php __($i) ?></a>
                    <?php else: ?>
                        <div class="px-4 py-1 text-sm <?php __($data['current_page'] != $i ? 'bg-gray-100' : 'bg-gray-300') ?> text-black rounded border border-gray-300"><?php __($i) ?></div>
                <?php endif;
                endfor; ?>
            </nav>
        <?php endif; ?>
    </div>
    <!-- Pagination end -->
</section>

<?php component('footer') ?>