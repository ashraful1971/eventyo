<div class="min-h-full">
  <?php component('admin-header', $data) ?>

  <main class="-mt-32">
    <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg p-2">
        <!-- Current Balance Stat -->
        <?php component('event-stats') ?>

        <!-- List of All The events -->
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <p class="mt-2 text-sm text-gray-700">
                Here's a list of your latest 5 events
              </p>
            </div>
          </div>
          <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead>
                    <tr>
                      <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                        Name
                      </th>
                      <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                        Capacity
                      </th>
                      <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                        Time
                      </th>
                      <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                        Date
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    <?php if ($data['events']) : ?>
                      <?php foreach ($data['events'] as $event) : ?>
                        <tr>
                          <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                            <?php __($event->name) ?>
                          </td>
                          <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                          <?php __($event->attendees_count . '/' . $event->capacity) ?>
                          </td>
                          <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                            <?php __($event->time) ?>
                          </td>
                          <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                            <?php __($event->date) ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr>
                        <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">No records found!</td>
                      </tr>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<?php component('admin-footer') ?>