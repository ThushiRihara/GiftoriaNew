<x-admin-layout>
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Registered Customers</h2>

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Registered At</th>
            </tr>
        </thead>
        <tbody id="customersTable">
            <!-- rows injected by JS -->
        </tbody>
    </table>
</div>
</x-admin-layout>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const token = localStorage.getItem('admin_token');
if(!token){ alert('Login first'); window.location.href='/admin/login'; }
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

async function fetchCustomers() {
    try{
        const res = await axios.get('/api/admin/customers');
        const customers = res.data;
        const tbody = document.getElementById('customersTable');
        tbody.innerHTML = '';
        customers.forEach((c, idx)=>{
            tbody.innerHTML += `<tr>
                <td class="border px-4 py-2">${idx+1}</td>
                <td class="border px-4 py-2">${c.name}</td>
                <td class="border px-4 py-2">${c.email}</td>
                <td class="border px-4 py-2">${c.phone ?? '-'}</td>
                <td class="border px-4 py-2">${new Date(c.created_at).toLocaleString()}</td>
            </tr>`;
        });
    }catch(err){ console.error(err); alert('Failed to fetch customers'); }
}

fetchCustomers();
</script>
