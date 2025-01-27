<div class="min-h-full">
  <?php component('admin-header', $data) ?>

  <main class="-mt-32">
    <div class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="py-8 bg-white rounded-lg overflow-scroll lg:overflow-hidden">
        <!-- List of All The events -->
        <div class="px-4 sm:px-6 lg:px-8">
          <?php component('flash-message') ?>
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <p class="mt-2 text-sm text-gray-600">
                A list of all the events including their name, date, time, location and capacity.
              </p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
              <a href="<?php __(url('/admin/events/create')) ?>" type="button" class="px-3 py-2 text-sm font-semibold text-center text-white rounded-md shadow-sm bg-sky-600 hover:bg-sky-500">
                Add Event
              </a>
            </div>
          </div>

          <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
            <form action="<?php __(url('/admin/events')) ?>" method="GET" class="pt-">
              <div class="flex items-center mt-4 text-sm">
                <input type="text" name="q" value="<?php __(request()->q) ?>" placeholder="Search by name" class="px-4 py-2 font-semibold text-gray-600 rounded-l-md shadow-sm bg-gray-100 focus:outline-none focus:ring-2 focus:ring-sky-600 focus:ring-opacity-50">
                <button type="submit" class="cursor-pointer px-2 py-2 font-semibold text-center text-white rounded-r-md shadow-sm bg-blue-600 hover:bg-blue-500">
                  Search
                </button>
              </div>
            </form>

            <form action="<?php __(url('/admin/events')) ?>" method="GET">
              <div class="flex items-center gap-2 mt-4 text-sm">
                <label for="all"><input type="radio" name="filter" value="all" <?php __(request()->filter == 'all' || !request()->filter ? 'checked' : '') ?> id="all"> All</label>
                <label for="upcoming"><input type="radio" name="filter" value="upcoming" <?php __(request()->filter == 'upcoming' ? 'checked' : '') ?> id="upcoming"> Upcoming</label>
                <label for="past"><input type="radio" name="filter" value="past" <?php __(request()->filter == 'past' ? 'checked' : '') ?> id="past"> Past</label>
                <button type="submit" class="cursor-pointer px-2 py-1 text-xs font-semibold text-center text-white rounded-md shadow-sm bg-gray-600 hover:bg-gray-500">
                  Apply Filter
                </button>
              </div>
            </form>
          </div>

          <table class="min-w-full divide-y divide-gray-300 mt-4">
            <thead>
              <tr>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  #
                </th>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  <?php
                  $sort_type = 'asc';
                  $sort_icon = '▲▼';
                  $sort = request()->sort ? explode(':', request()->sort) : null;
                  if ($sort && $sort[0] == 'name') {
                    $sort_type = $sort[1] == 'asc' ? 'desc' : 'asc';
                    $sort_icon = $sort[1] == 'asc' ? '▲' : '▼';
                  }
                  ?>
                  <a href="<?php __(url('/admin/events/?'
                              . (request()->q ? 'q=' . request()->q . '&' : '')
                              . (request()->filter ? 'filter=' . request()->filter . '&' : '')
                              . 'sort=name:' . $sort_type)) ?>">
                    Name <span class="text-xs text-gray-400"><?php __($sort_icon) ?></span>
                  </a>
                </th>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  <?php
                  $sort_type = 'asc';
                  $sort_icon = '▲▼';
                  $sort = request()->sort ? explode(':', request()->sort) : null;
                  if ($sort && $sort[0] == 'date') {
                    $sort_type = $sort[1] == 'asc' ? 'desc' : 'asc';
                    $sort_icon = $sort[1] == 'asc' ? '▲' : '▼';
                  }
                  ?>
                  <a href="<?php __(url('/admin/events/?'
                              . (request()->q ? 'q=' . request()->q . '&' : '')
                              . (request()->filter ? 'filter=' . request()->filter . '&' : '')
                              . 'sort=date:' . $sort_type)) ?>">
                    Date <span class="text-xs text-gray-400"><?php __($sort_icon) ?></span>
                  </a>
                </th>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  Time
                </th>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  Capacity
                </th>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  Action
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <?php if ($data['events']): ?>
                <?php foreach ($data['events'] as $index => $item) : ?>
                  <tr key={item?.id}>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-800">
                      <?php __($index + 1 + ($data['current_page'] - 1) * $data['per_page']) ?>
                    </td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-800">
                      <?php __($item->name) ?>
                    </td>

                    <td class="whitespace-nowrap p-4 text-sm text-gray-800">
                      <?php __($item->date) ?>
                    </td>

                    <td class="whitespace-nowrap p-4 text-sm text-gray-800">
                      <?php __($item->time) ?>
                    </td>

                    <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                      <?php __($item->attendees_count . '/' . $item->capacity) ?>
                    </td>
                    <td class="flex items-center gap-3 whitespace-nowrap p-4 text-xs text-gray-500">
                      <a
                        href="<?php __(url('/event/' . $item->id)) ?>"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 border rounded transition-all">
                        View
                      </a>
                      <a
                        href="<?php __(url('/admin/events/' . $item->id . '/edit')) ?>"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 border rounded transition-all">
                        Edit
                      </a>
                      <form class="inline-block m-0" action="<?php __(url('/admin/events/' . $item->id)) ?>" method="POST">
                        <?php method('DELETE') ?>
                        <button type="submit" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1 border rounded transition-all">
                          Delete</button>
                      </form>
                      <a
                        href="<?php __(url('/admin/events/' . $item->id . '/attendees')) ?>"
                        class="bg-black hover:bg-black text-white px-3 py-1 border rounded transition-all">
                        Attendees
                      </a>
                    </td>
                  </tr>
                <?php endforeach ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center p-4 text-sm text-gray-800">No events found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

          <!-- Pagination start  -->
          <div class="mt-4">
            <?php $last_page = ceil($data['count'] / $data['per_page']); ?>
            <?php if ($last_page > 1): ?>
              <nav class="flex gap-2 items-center">
                <span class="text-sm">Page</span>
                <?php for ($i = 1; $i <= $last_page; $i++): ?>
                  <?php if ($data['current_page'] != $i): ?>
                    <a href="<?php __(url('/admin/events/?'
                                . (request()->q ? 'q=' . request()->q . '&' : '')
                                . (request()->filter ? 'filter=' . request()->filter . '&' : '')
                                . (request()->sort ? 'sort=' . request()->sort . '&' : '')
                                . 'page=' . $i)) ?>"
                      class="px-4 py-1 text-sm <?php __($data['current_page'] != $i ? 'bg-gray-100' : 'bg-gray-300') ?> text-black rounded border border-gray-300"><?php __($i) ?></a>
                  <?php else: ?>
                    <div class="px-4 py-1 text-sm <?php __($data['current_page'] != $i ? 'bg-gray-100' : 'bg-gray-300') ?> text-black rounded border border-gray-300"><?php __($i) ?></div>
                <?php endif;
                endfor; ?>
              </nav>
            <?php endif; ?>
          </div>
          <!-- Pagination end -->
        </div>
      </div>
    </div>
  </main>
</div>
<?php component('admin-footer') ?>