<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <h2 class="text-2xl font-bold text-center text-gray-800">Admin Panel</h2>
        </x-slot>

        <div id="error-message" class="mb-4 font-medium text-sm text-red-600 hidden"></div>

        <form id="adminLoginForm">
            @csrf
            <div>
                <x-label for="username" value="Username" />
                <x-input id="username" class="block mt-1 w-full" type="text" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="password" value="Password" />
                <x-input id="password" class="block mt-1 w-full" type="password" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button type="submit">Login</x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('adminLoginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    try {
        const res = await axios.post('/api/admin/login', { username, password });
        localStorage.setItem('admin_token', res.data.token);
        window.location.href = "/admin/dashboard";
    } catch (err) {
        const errorDiv = document.getElementById('error-message');
        errorDiv.innerText = err.response?.data?.message || "Invalid credentials";
        errorDiv.classList.remove('hidden');
    }
});
</script>
