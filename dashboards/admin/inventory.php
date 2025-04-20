<?php   include '../../includes/session_check.php'; 
        include '../../includes/admin_header.php'; 
        include '../../includes/admin_sidebar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Table with Tailwind CSS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold">Inventory</h1>
                <p class="text-gray-600">Manage your materials, fabrics, threads, and supplies</p>
            </div>
            <div class="flex space-x-2">
                <select class="border rounded px-2 py-1 text-sm">
                    <option>All Categories</option>
                    <option>Fabrics</option>
                    <option>Threads</option>
                    <option>Sublimation Supplies</option>
                    <option>Embroidery Supplies</option>
                    <option>Other Supplies</option>
                </select>
                <select class="border rounded px-2 py-1 text-sm">
                    <option>All Status</option>
                    <option>In Stock</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                    <option>On Order</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Category</th>
                        <th class="py-3 px-4 text-left">SKU</th>
                        <th class="py-3 px-4 text-left">Quantity</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Supplier</th>
                        <th class="py-3 px-4 text-left">Unit Price</th>
                        <th class="py-3 px-4 text-left">Reorder Level</th>
                        <th class="py-3 px-4 text-left">Last Updated</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <!-- Row 1 -->
                    <tr class="border-t">
                        <td class="py-3 px-4">Cotton Fabric - Black  (Example)</td>
                        <td class="py-3 px-4">Fabrics</td>
                        <td class="py-3 px-4">FAB-COT-BLK</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-2">
                                <button class="px-2 py-1 border rounded">-</button>
                                <span>45</span>
                                <button class="px-2 py-1 border rounded">+</button>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded">In Stock</span>
                        </td>
                        <td class="py-3 px-4">Textile World Inc.</td>
                        <td class="py-3 px-4">$8.50</td>
                        <td class="py-3 px-4">20</td>
                        <td class="py-3 px-4">Mar 18, 2025</td>
                        <td class="py-3 px-4">
                            <button class="text-gray-500 hover:text-gray-700">Edit</button>
                            <button class="text-gray-500 hover:text-gray-700">Delete</button>
                        </td>
                    </tr>

</body>
</html>
<?php include '../../includes/admin_footer.php'; ?>