<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-PRONOC</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .dashboard-bg {
            background-color: #f8f9fa;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pronoc-red': '#d62828',
                        'pronoc-red-dark': '#b71d23',
                    },
                }
            }
        }
    </script>
</head>
<body class="dashboard-bg antialiased">

<div class="min-h-screen flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-pronoc-red">Admin Panel</h2>
        </div>
        <nav class="mt-6">
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100">Dashboard</a>
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100">User Management</a>
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100">System Overview</a>
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100">Reports</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>

        <!-- User Management Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">User Management</h2>
            <p class="text-gray-600 mb-4">Manage users, roles, and permissions.</p>
            <button class="bg-pronoc-red text-white px-4 py-2 rounded hover:bg-pronoc-red-dark">Add New User</button>
            <div class="mt-4">
                <!-- Placeholder for user list -->
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">John Doe</td>
                            <td class="border px-4 py-2">Admin</td>
                            <td class="border px-4 py-2">
                                <button class="text-blue-500 hover:underline">Edit</button>
                                <button class="text-red-500 hover:underline ml-2">Delete</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- System Overview Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">System Overview</h2>
            <p class="text-gray-600 mb-4">Monitor system performance and statistics.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-100 p-4 rounded">
                    <h3 class="font-semibold">Total Users</h3>
                    <p class="text-2xl">150</p>
                </div>
                <div class="bg-gray-100 p-4 rounded">
                    <h3 class="font-semibold">Active Sessions</h3>
                    <p class="text-2xl">45</p>
                </div>
                <div class="bg-gray-100 p-4 rounded">
                    <h3 class="font-semibold">System Uptime</h3>
                    <p class="text-2xl">99.9%</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
