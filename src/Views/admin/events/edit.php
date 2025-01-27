<div class="min-h-full">
  <?php component('admin-header', $data) ?>

  <main class="-mt-32">
    <div class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg">
        <?php component('flash-message') ?>
        <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" action="<?php __(url('/admin/events/' . $data['event']->id)) ?>" method="POST">
          <?php method('PUT') ?>

          <div class="px-4 py-6 sm:p-8">
            <div class="flex flex-col gap-y-6">
              <div class="w-full">
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                <div class="mt-2">
                  <input type="text" name="name" id="name" value="<?php __($data['event']->name) ?>" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                </div>
              </div>

              <div class="w-full">
                <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                <div class="mt-2">
                  <textarea type="text" name="description" id="description" class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6"><?php __($data['event']->description) ?></textarea>
                </div>
              </div>

              <div class="w-full">
                <label for="date" class="block text-sm font-medium leading-6 text-gray-900">Date</label>
                <div class="mt-2">
                  <input type="date" name="date" id="date" value="<?php __($data['event']->date) ?>" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                </div>
              </div>

              <div class="w-full">
                <label for="time" class="block text-sm font-medium leading-6 text-gray-900">Time</label>
                <div class="mt-2">
                  <input type="text" name="time" id="time" value="<?php __($data['event']->time) ?>" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                </div>
              </div>

              <div class="w-full">
                <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Location</label>
                <div class="mt-2">
                  <input type="text" name="location" id="location" value="<?php __($data['event']->location) ?>" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                </div>
              </div>

              <div class="w-full">
                <label for="capacity" class="block text-sm font-medium leading-6 text-gray-900">Capacity</label>
                <div class="mt-2">
                  <input type="text" name="capacity" id="capacity" value="<?php __($data['event']->capacity) ?>" required class="block w-full p-2 text-gray-900 border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" />
                </div>
              </div>

            </div>
          </div>
          <div class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
            <button type="reset" class="cursor-pointer text-sm font-semibold leading-6 text-gray-900">
              Cancel
            </button>
            <button type="submit" class="cursor-pointer px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-sky-600 hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
              Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
<?php component('admin-footer') ?>