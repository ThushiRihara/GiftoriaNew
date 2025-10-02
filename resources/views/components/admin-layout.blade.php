<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite('resources/css/app.css') <!-- Tailwind CSS -->
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Admin Panel</h1>
        <button id="logoutBtn" class="bg-red-500 text-white px-4 py-2 rounded">Logout</button>
    </header>

    <!-- Main Content -->
    <main class="p-6">
        {{ $slot }}
    </main>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('logoutBtn').addEventListener('click', async () => {
            const token = localStorage.getItem('admin_token');
            if (!token) {
                window.location.href = '/admin/login';
                return;
            }

            try {
                await axios.post('/api/admin/logout', {}, {
                    headers: { Authorization: `Bearer ${token}` }
                });
            } catch (err) {
                console.error(err);
            }

            localStorage.removeItem('admin_token');
            window.location.href = '/admin/login';
        });
    </script>
</body>
</html>
