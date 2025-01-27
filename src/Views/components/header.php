<!DOCTYPE html>
<html class="h-full bg-white" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="<?php __(url('public/css/style.css')) ?>" />
  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    * {
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
        'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
        'Helvetica Neue', sans-serif;
    }
  </style>
</head>

<body class="min-h-screen">

  <!-- Header with Login/Register Links -->
  <header class="bg-white shadow-sm">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="<?php __(url('/')) ?>"><img class="w-32" src="<?php echo url('public/images/logo.png') ?>" alt="Logo"></a>
      <div class="space-x-4">
        <?php if(!authUser()):?>
        <a href="<?php __(url('/login'))?>" class="text-gray-800 hover:text-blue-500 font-medium">Login</a>
        <a href="<?php __(url('/register'))?>" class="text-white hover:bg-blue-600 font-medium bg-blue-500 px-4 py-1.5 rounded">Register</a>
        <?php else:?>
        <a href="<?php __(url('/admin/dashboard'))?>" class="text-gray-800 hover:text-blue-500 font-medium">Dashboard</a>
        <a href="<?php __(url('/logout'))?>" class="text-red-600 font-bold hover:text-red-400">Logout</a>
        <?php endif;?>
      </div>
    </nav>
  </header>