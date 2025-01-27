<div class="min-h-full">
  <?php component('admin-header', $data) ?>

  <main class="-mt-32">
    <div class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="py-8 bg-white rounded-lg overflow-scroll lg:overflow-hidden">
        <!-- List of All The events -->
        <div class="px-4 sm:px-6 lg:px-8">
          <?php component('flash-message') ?>
          <div class="md:flex sm:items-center">
            <div class="sm:flex-auto">
              <p class="mt-2 text-sm text-gray-600">
                A list of all the attendees including their name, phone and email.
              </p>
            </div>
            <div class="mt-4">
              <a href="<?php __(url('/admin/events/' . $data['event_id'] . '/attendees/download')) ?>" type="button" class="px-3 py-2 text-sm font-semibold text-center text-white rounded-md shadow-sm bg-sky-600 hover:bg-sky-500">
                Download Attendees List
              </a>
            </div>
          </div>

          <div>
            <form action="<?php __(url('admin/events/' . $data['event_id'] . '/attendees')) ?>" method="GET">
              <div class="flex items-center mt-4 text-sm">
                <input type="text" name="q" value="<?php __(request()->q) ?>" placeholder="Search by name" class="px-4 py-2 font-semibold text-gray-600 rounded-l-md shadow-sm bg-gray-100 focus:outline-none focus:ring-2 focus:ring-sky-600 focus:ring-opacity-50">
                <button type="submit" class="px-2 py-2 font-semibold text-center text-white rounded-r-md shadow-sm bg-blue-600 hover:bg-blue-500">
                  Search
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
                  Name
                </th>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  Phone
                </th>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  Email
                </th>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  Registered At
                </th>
                <th
                  scope="col"
                  class="whitespace-nowrap p-4 text-left text-sm font-semibold text-gray-900">
                  Action
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <?php if ($data['attendees']): ?>
                <?php foreach ($data['attendees'] as $index => $item) : ?>
                  <tr key={item?.id}>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-800">
                      <?php __($index + 1 + ($data['current_page'] - 1) * $data['per_page']) ?>
                    </td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-800">
                      <?php __($item->name) ?>
                    </td>

                    <td class="whitespace-nowrap p-4 text-sm text-gray-800">
                      <?php __($item->phone) ?>
                    </td>

                    <td class="whitespace-nowrap p-4 text-sm text-gray-800">
                      <?php __($item->email) ?>
                    </td>

                    <td class="whitespace-nowrap p-4 text-sm text-gray-500">
                      <?php __($item->created_at) ?>
                    </td>
                    <td class="flex items-center gap-3 whitespace-nowrap p-4 text-xs text-gray-500">
                      <form class="inline-block" action="<?php __(url('/admin/events/' . $item->event_id . '/attendees/' . $item->id)) ?>" method="POST">
                        <?php method('DELETE') ?>
                        <button type="submit" class="cursor-pointer bg-red-500 hover:bg-red-600 text-white px-3 py-1 border rounded transition-all">
                          Delete</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center p-4 text-sm text-gray-800">No attendees found.</td>
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
                    <a href="<?php __(url('/admin/events/' . $data['event_id'] . '/attendees/?'
                                . (request()->q ? 'q=' . request()->q . '&' : '')
                                . 'page=' . $i)) ?>" class="px-4 py-1 text-sm <?php __($data['current_page'] != $i ? 'bg-gray-100' : 'bg-gray-300') ?> text-black rounded border border-gray-300"><?php __($i) ?></a>
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