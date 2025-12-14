<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Researcher Dashboard - E-PRONOC</title>
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
            <h2 class="text-2xl font-bold text-pronoc-red">Researcher Panel</h2>
        </div>
        <nav class="mt-6">
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100">Dashboard</a>
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100">Research Tools</a>
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100">Data Visualization</a>
            <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-gray-100">Reports</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Researcher Dashboard</h1>

        <!-- Research Tools Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Research Tools</h2>
            <p class="text-gray-600 mb-4">Access various tools for your research activities.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button class="bg-pronoc-red text-white px-4 py-2 rounded hover:bg-pronoc-red-dark">Data Analysis Tool</button>
                <button class="bg-pronoc-red text-white px-4 py-2 rounded hover:bg-pronoc-red-dark">Survey Builder</button>
                <button class="bg-pronoc-red text-white px-4 py-2 rounded hover:bg-pronoc-red-dark">Literature Review</button>
                <button class="bg-pronoc-red text-white px-4 py-2 rounded hover:bg-pronoc-red-dark">Collaboration Hub</button>
            </div>
        </div>

        <!-- Data Visualization Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Data Visualization</h2>
            <p class="text-gray-600 mb-4">Visualize your research data with interactive charts and graphs.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-100 p-4 rounded">
                    <h3 class="font-semibold">Chart 1</h3>
                    <p class="text-sm text-gray-600">Placeholder for chart</p>
                </div>
                <div class="bg-gray-100 p-4 rounded">
                    <h3 class="font-semibold">Chart 2</h3>
                    <p class="text-sm text-gray-600">Placeholder for chart</p>
                </div>
                <div class="bg-gray-100 p-4 rounded">
                    <h3 class="font-semibold">Chart 3</h3>
                    <p class="text-sm text-gray-600">Placeholder for chart</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
