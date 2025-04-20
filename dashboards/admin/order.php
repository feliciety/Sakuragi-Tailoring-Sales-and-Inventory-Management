<?php   include '../../includes/session_check.php'; 
        include '../../includes/admin_header.php'; 
        include '../../includes/admin_sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Table with Tailwind CSS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold">Orders</h1>
                <p class="text-gray-600">Manage customer orders and track their progress</p>
            </div>
            <div>
                <select class="border rounded px-2 py-1 text-sm">
                    <option>All Orders</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 text-left">Order ID</th>
                        <th class="py-3 px-4 text-left">Customer</th>
                        <th class="py-3 px-4 text-left">Service</th>
                        <th class="py-3 px-4 text-left">Date</th>
                        <th class="py-3 px-4 text-left">Total</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Progress</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <!-- Row 1 -->
                    <tr class="border-t">
                        <td class="py-3 px-4">#001 Example(01)</td>
                        <td class="py-3 px-4">John Smith</td>
                        <td class="py-3 px-4">Embroidery</td>
                        <td class="py-3 px-4">Mar 19, 2025</td>
                        <td class="py-3 px-4">$45.00</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded">In Progress</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="w-24 bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 80%"></div>
                            </div>
                        </td>
                        <td class="py-3 px-4 flex space-x-2">
                            <button class="text-gray-500 hover:text-gray-700">👁️</button>
                            <button class="text-gray-500 hover:text-gray-700">✏️</button>
                            <button class="text-gray-500 hover:text-gray-700">🗑️</button>
                        </td>
                    </tr>
                   
</body>
</html>
<?php include '../../includes/admin_footer.php'; ?>