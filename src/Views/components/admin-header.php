<!DOCTYPE html>
<html class="h-full bg-white" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="<?php __(url('public/css/style.css')) ?>" />

  <script defer src="<?php __(url('public/js/alpine.js')) ?>"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <title><?php __($data['page_title'] ?? 'Eventyo') ?></title>
  
  <style>
    * {
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
        'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
        'Helvetica Neue', sans-serif;
    }
  </style>
</head>

<body class="min-h-screen">

<div class="bg-blue-600 pb-32">
    <!-- Navigation -->
    <nav class="border-b border-blue-400/40 bg-blue-600" x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex items-center px-2 lg:px-0">
                    <div class="hidden sm:block">
                        <div class="flex space-x-4">
                            <?php
                            $getMenuItemClasses = function ($route) {
                                return request()->getRoutePath() == $route ? "bg-blue-700 text-white rounded-md py-2 px-3 text-sm font-medium" : "text-white hover:bg-blue-500 hover:bg-opacity-75 rounded-md py-2 px-3 text-sm font-medium";
                            }
                            ?>
                            <a href="<?php __(url('/admin/dashboard')) ?>" class="<?php echo $getMenuItemClasses('/admin/dashboard') ?>" aria-current="page">Dashboard</a>
                            <a href="<?php __(url('/admin/events')) ?>" class="<?php echo $getMenuItemClasses('/admin/events') ?>">Events</a>
                            <a href="<?php __(url('/')) ?>" class="<?php echo $getMenuItemClasses('/') ?>">Visit Website</a>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex gap-2 sm:items-center">
                    <!-- Profile dropdown -->
                    <div class="relative ml-3" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" type="button" class="cursor-pointer flex rounded-full bg-white text-sm focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                                    <span class="font-medium leading-none text-blue-700"><?php __(getFirstTwoLetter(authUser()->fullname)) ?></span>
                                </span>
                            </button>
                        </div>

                        <!-- Dropdown menu -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="<?php __(url('/logout')) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                        </div>
                    </div>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="cursor-pointer inline-flex items-center justify-center rounded-md p-2 text-blue-100 hover:bg-blue-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed -->
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>

                        <!-- Icon when menu is open -->
                        <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div x-show="mobileMenuOpen" class="sm:hidden" id="mobile-menu">
            <div class="space-y-1 pt-2 pb-3">
                <a href="<?php __(url('/admin/dashboard')) ?>" class="text-white <?php __(request()->getRoutePath() == '/admin/dashboard' ? 'bg-blue-700' : '') ?> hover:bg-blue-700 hover:bg-opacity-75 block rounded-md py-2 px-3 text-base font-medium">Dashboard</a>
                <a href="<?php __(url('/admin/events')) ?>" class="text-white <?php __(request()->getRoutePath() == '/admin/events' ? 'bg-blue-700' : '') ?> hover:bg-blue-700 hover:bg-opacity-75 block rounded-md py-2 px-3 text-base font-medium">Events</a>
                <a href="<?php __(url('/')) ?>" class="text-white <?php __(request()->getRoutePath() == '/' ? 'bg-blue-700' : '') ?> hover:bg-blue-700 hover:bg-opacity-75 block rounded-md py-2 px-3 text-base font-medium">Visit Website</a>
            </div>
            <div class="border-t border-blue-700 pb-3 pt-4">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-100">
                            <span class="font-medium leading-none text-blue-700"><?php __(getFirstTwoLetter(authUser()->fullname)) ?></span>
                        </span>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">
                            <?php __(authUser()->fullname) ?>
                        </div>
                        <div class="text-sm font-medium text-blue-300">
                            <?php __(authUser()->email) ?>
                        </div>
                    </div>
                    <button type="button" class="ml-auto flex-shrink-0 rounded-full bg-blue-600 p-1 text-blue-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600">
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </button>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="<?php __(url('/logout')) ?>" class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-blue-500 hover:bg-opacity-75">Sign out</a>
                </div>
            </div>
        </div>
    </nav>
    <header class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">
                <?php __($data['page_title'] ?? 'Untitled') ?>
            </h1>
        </div>
    </header>
</div>