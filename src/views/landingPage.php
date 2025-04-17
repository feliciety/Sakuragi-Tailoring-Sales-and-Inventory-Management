<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <!-- Header -->
  <div class="p-4 bg-white shadow">
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold">Dashboard</h1>
      <div class="flex justify-between w-1/10">
  <button class="bg-gray-200 px-4 py-2 rounded mr-2 flex items-center gap-x-2">
    <img src="../resources/LandingPageImages/Vector.png" alt="" class="w-4 h-4">Design Mockup
  </button>
  <button class="bg-blue-600 text-white px-4 py-2 rounded">Place New Order</button>
</div>

    </div>
    <p class="text-sm text-gray-500 mt-1">Manage your orders and designs in one place</p>
  </div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
    <div class="bg-white p-4 rounded shadow">
      <p class="text-gray-500">Total Orders</p>
      <h2 class="text-xl font-bold">12</h2>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <p class="text-gray-500">In Progress</p>
      <h2 class="text-xl font-bold">4</h2>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <p class="text-gray-500">Completed</p>
      <h2 class="text-xl font-bold">8</h2>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <p class="text-gray-500">Attention Needed</p>
      <h2 class="text-xl font-bold">2</h2>
    </div>
  </div>

  <!-- Tabs & Content -->
  <div class="p-4">
    <div class="flex space-x-4 border-b pb-2 mb-4">
      <button class="text-blue-600 font-semibold border-b-2 border-blue-600 pb-1">Overview</button>
      <button class="text-gray-600">Orders</button>
      <button class="text-gray-600">Design Files</button>
      <button class="text-gray-600">Price Calculator</button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <!-- Recent Orders -->
      <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between mb-2">
          <h3 class="font-semibold">Recent Orders</h3>
          <a href="#" class="text-blue-600 text-sm">View all</a>
        </div>
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left text-gray-500">
              <th class="py-2">Order ID</th>
              <th class="py-2">Date</th>
              <th class="py-2">Items</th>
              <th class="py-2">Total</th>
              <th class="py-2">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t">
              <td class="py-2 text-blue-600">ORD-001</td>
              <td>2023-06-15</td>
              <td>10 Custom T-Shirts</td>
              <td>$259.90</td>
              <td><span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">In Production</span></td>
            </tr>
            <tr class="border-t">
              <td class="py-2 text-blue-600">ORD-002</td>
              <td>2023-06-10</td>
              <td>10 Custom Hoodies</td>
              <td>$199.95</td>
              <td><span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">Design Review</span></td>
            </tr>
            <tr class="border-t">
              <td class="py-2 text-blue-600">ORD-003</td>
              <td>2023-06-05</td>
              <td>20 Custom Caps</td>
              <td>$159.80</td>
              <td><span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">Completed</span></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pending Actions -->
      <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold mb-4">Pending Actions</h3>
        <div class="space-y-4 text-sm">
          <div>
            <p class="font-medium">Pending Design Uploads</p>
            <div class="flex justify-between items-center">
              <div>
                <p>Custom Hoodies</p>
                <p class="text-gray-500 text-xs">Due by 2023-06-18</p>
              </div>
              <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs">Upload</button>
            </div>
            <div class="flex justify-between items-center mt-2">
              <div>
                <p>Custom Polo Shirts</p>
                <p class="text-gray-500 text-xs">Due by 2023-06-18</p>
              </div>
              <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs">Upload</button>
            </div>
          </div>
          <div>
            <p class="font-medium">Design Feedback</p>
            <div class="flex justify-between items-center">
              <div>
                <p>Custom Caps</p>
                <p class="text-red-600 text-xs">Resolution too low. Please upload a higher quality image.</p>
              </div>
              <button class="bg-gray-200 px-3 py-1 rounded text-xs">View</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>