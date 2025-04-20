<?php   include '../../includes/session_check.php'; 
        include '../../includes/admin_header.php'; 
        include '../../includes/admin_sidebar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
  <main class="p-6">
    
  <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p class="text-gray-600">Overview of your tailoring shop inventory and orders</p>
            </div>
            
        </div>
   
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <div class="bg-white p-4 rounded-2xl shadow">
        <h2 class="text-lg font-semibold">Total Materials</h2>
        <p class="text-3xl font-bold mt-2">1,284 Example (fetch from cusomter)<p>
        <p class="text-sm text-green-500 mt-1">+12 added this week Example (fetch from cusomter)</p>
      </div>
      <div class="bg-white p-4 rounded-2xl shadow">
        <h2 class="text-lg font-semibold">Low Stock Items</h2>
        <p class="text-3xl font-bold mt-2">24 Example (fetch from cusomter)<p>
        <p class="text-sm text-yellow-500 mt-1">+2 since yesterday Example (fetch from cusomter)<p>
      </div>
      <div class="bg-white p-4 rounded-2xl shadow">
        <h2 class="text-lg font-semibold">Active Orders</h2>
        <p class="text-3xl font-bold mt-2">36 Example (fetch from cusomter)</p>
        <p class="text-sm text-green-500 mt-1">+8 new today Example (fetch from cusomter)</p>
      </div>
      <div class="bg-white p-4 rounded-2xl shadow">
        <h2 class="text-lg font-semibold">Services Booked</h2>
        <p class="text-3xl font-bold mt-2">42 Example (fetch from cusomter)</p>
        <p class="text-sm text-red-500 mt-1">-6 from last week Example (fetch from cusomter)</p>
      </div>
    </div>

   
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Overview Chart Placeholder -->
      <div class="bg-white p-6 rounded-2xl shadow col-span-2">
        <h2 class="text-xl font-semibold mb-4">Overview</h2>
        <div class="h-64 flex items-center justify-center text-gray-400">
          <!-- Replace with actual chart -->
          [Bar Chart Placeholder]
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
        <ul class="space-y-4">
          <li class="flex items-center justify-between">
            <div>
              <p class="font-medium">John Smith</p>
              <p class="text-sm text-gray-500">Embroidery - Mar 19, 2025</p>
            </div>
            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">In Progress</span>
          </li>
        
</body>
</html>

<?php include '../../includes/admin_footer.php'; ?>
