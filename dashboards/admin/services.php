<?php   include '../../includes/session_check.php'; 
        include '../../includes/admin_header.php'; 
        include '../../includes/admin_sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services with Tailwind CSS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="text-2xl font-bold">Services</h1>
            <p class="text-gray-600">Manage your tailoring services including sublimation, embroidery, and alterations</p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Service 1: Sublimation Printing -->
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Sublimation Printing</h2>
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded">Active</span>
                </div>
                <p class="text-gray-600 text-sm mb-4">Full-color dye sublimation printing on polyester fabrics and items</p>
                <p class="text-gray-700"><span class="font-medium">Base Price:</span> $25.00</p>
                <p class="text-gray-700"><span class="font-medium">Materials:</span> Sublimation Paper, Sublimation Ink, Heat Press</p>
                <p class="text-gray-700"><span class="font-medium">Avg. Completion Time:</span> 1-2 days</p>
                <div class="flex justify-between items-center mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" checked>
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                    <div class="flex space-x-2">
                        <button class="text-gray-500 hover:text-gray-700">✏️</button>
                        <button class="text-gray-500 hover:text-gray-700">🗑️</button>
                    </div>
                </div>
            </div>

            <!-- Service 2: Custom Embroidery -->
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Custom Embroidery</h2>
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded">Active</span>
                </div>
                <p class="text-gray-600 text-sm mb-4">Personalized embroidery for garments, hats, bags, and more</p>
                <p class="text-gray-700"><span class="font-medium">Base Price:</span> $15.00</p>
                <p class="text-gray-700"><span class="font-medium">Materials:</span> Embroidery Thread, Stabilizers, Hoops</p>
                <p class="text-gray-700"><span class="font-medium">Avg. Completion Time:</span> 2-3 days</p>
                <div class="flex justify-between items-center mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" checked>
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                    <div class="flex space-x-2">
                        <button class="text-gray-500 hover:text-gray-700">✏️</button>
                        <button class="text-gray-500 hover:text-gray-700">🗑️</button>
                    </div>
                </div>
            </div>

            <!-- Service 3: Alterations -->
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Alterations</h2>
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded">Active</span>
                </div>
                <p class="text-gray-600 text-sm mb-4">Garment alterations including hemming, taking in/out, and repairs</p>
                <p class="text-gray-700"><span class="font-medium">Base Price:</span> $20.00</p>
                <p class="text-gray-700"><span class="font-medium">Materials:</span> Thread, Fabric (if needed)</p>
                <p class="text-gray-700"><span class="font-medium">Avg. Completion Time:</span> 3-5 days</p>
                <div class="flex justify-between items-center mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" checked>
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                    <div class="flex space-x-2">
                        <button class="text-gray-500 hover:text-gray-700">✏️</button>
                        <button class="text-gray-500 hover:text-gray-700">🗑️</button>
                    </div>
                </div>
            </div>

            <!-- Service 4: Custom Tailoring -->
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Custom Tailoring</h2>
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded">Active</span>
                </div>
                <p class="text-gray-600 text-sm mb-4">Made-to-measure clothing creation from scratch</p>
                <p class="text-gray-700"><span class="font-medium">Base Price:</span> $150.00</p>
                <p class="text-gray-700"><span class="font-medium">Materials:</span> Fabric, Thread, Buttons, Zippers</p>
                <p class="text-gray-700"><span class="font-medium">Avg. Completion Time:</span> 7-14 days</p>
                <div class="flex justify-between items-center mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" checked>
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                    <div class="flex space-x-2">
                        <button class="text-gray-500 hover:text-gray-700">✏️</button>
                        <button class="text-gray-500 hover:text-gray-700">🗑️</button>
                    </div>
                </div>
            </div>

            <!-- Service 5: Patch Creation -->
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Patch Creation</h2>
                    <span class="px-2 py-1 bg-red-100 text-red-600 text-xs rounded">Inactive</span>
                </div>
                <p class="text-gray-600 text-sm mb-4">Custom embroidered patches for uniforms and apparel</p>
                <p class="text-gray-700"><span class="font-medium">Base Price:</span> $12.00</p>
                <p class="text-gray-700"><span class="font-medium">Materials:</span> Backing Material, Embroidery Thread, Adhesive</p>
                <p class="text-gray-700"><span class="font-medium">Avg. Completion Time:</span> 2-3 days</p>
                <div class="flex justify-between items-center mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600">
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                    <div class="flex space-x-2">
                        <button class="text-gray-500 hover:text-gray-700">✏️</button>
                        <button class="text-gray-500 hover:text-gray-700">🗑️</button>
                    </div>
                </div>
            </div>

            <!-- Service 6: Screen Printing -->
            <div class="bg-white shadow rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Screen Printing</h2>
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs rounded">Active</span>
                </div>
                <p class="text-gray-600 text-sm mb-4">Multi-color screen printing for t-shirts and apparel</p>
                <p class="text-gray-700"><span class="font-medium">Base Price:</span> $18.00</p>
                <p class="text-gray-700"><span class="font-medium">Materials:</span> Screens, Ink, Squeegees</p>
                <p class="text-gray-700"><span class="font-medium">Avg. Completion Time:</span> 3-5 days</p>
                <div class="flex justify-between items-center mt-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" checked>
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                    <div class="flex space-x-2">
                        <button class="text-gray-500 hover:text-gray-700">✏️</button>
                        <button class="text-gray-500 hover:text-gray-700">🗑️</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php include '../../includes/admin_footer.php'; ?>