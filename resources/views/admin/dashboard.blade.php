<x-admin-layout>
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Only Manage AddOns -->
            <a href="{{ route('admin.addons.manage') }}" 
               class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-4 rounded shadow text-center">
                Manage AddOns
            </a>

            <!-- Manage Gifts -->
            <a href="{{ route('admin.gifts.manage') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-4 rounded shadow text-center">
                Manage Gifts
            </a>

            <!-- Manage customers -->
            <a href="{{ route('admin.customers.manage') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold px-6 py-4 rounded shadow text-center">
            Manage Customers
        </a>
        </div>

        <!-- Logout Button -->
        <form id="logoutForm" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded shadow">
                Logout
            </button>
        </form>
    </div>
</x-admin-layout>

{{-- Axios CDN --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.getElementById('logoutForm').addEventListener('submit', async function(e){
    e.preventDefault();

    const token = localStorage.getItem('admin_token');
    if (!token) {
        window.location.href = "/admin/login";
        return;
    }

    try {
        await axios.post('/api/admin/logout', {}, {
            headers: { Authorization: `Bearer ${token}` }
        });
    } catch (err) {
        console.error("Logout failed:", err);
    }

    localStorage.removeItem('admin_token');
    window.location.href = "/admin/login";
});
</script>

