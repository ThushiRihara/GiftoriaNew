<x-admin-layout>
    <h2 class="text-2xl font-bold mb-4">Manage AddOns</h2>

    <button id="addBtn" class="bg-green-500 text-white px-4 py-2 rounded mb-4">+ Add New AddOn</button>

    <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Price</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody id="addonsTable"></tbody>
    </table>

    <!-- Modal -->
    <div id="addonModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow w-1/3">
            <h3 class="text-lg font-bold mb-4" id="modalTitle">Add AddOn</h3>
            <input id="addonName" type="text" placeholder="Name" class="w-full border p-2 mb-2">
            <input id="addonPrice" type="number" placeholder="Price" class="w-full border p-2 mb-2">
            <div class="flex justify-end space-x-2">
                <button id="saveBtn" class="bg-green-500 text-black px-4 py-2 rounded">Save</button>
                <button id="cancelBtn" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
            </div>
        </div>
    </div>
</x-admin-layout>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
let addons = [];
let editingId = null;
const token = localStorage.getItem('admin_token');

if (!token) {
    alert("Please log in first.");
    window.location.href = "/admin/login";
}

axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

const modal = document.getElementById('addonModal');
const addonName = document.getElementById('addonName');
const addonPrice = document.getElementById('addonPrice');
const modalTitle = document.getElementById('modalTitle');

function fetchAddOns() {
    axios.get('/api/addons')
        .then(res => { addons = res.data; renderTable(); })
        .catch(err => {
            console.error(err);
            if (err.response?.status === 401) {
                alert("Session expired. Please log in again.");
                localStorage.removeItem('admin_token');
                window.location.href = "/admin/login";
            }
        });
}

function renderTable() {
    const tbody = document.getElementById('addonsTable');
    tbody.innerHTML = '';
    addons.forEach(a => {
        tbody.innerHTML += `
            <tr>
                <td class="border px-4 py-2">${a.id}</td>
                <td class="border px-4 py-2">${a.name}</td>
                <td class="border px-4 py-2">${a.price}</td>
                <td class="border px-4 py-2 space-x-2">
                    <button onclick="editAddOn(${a.id})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                    <button onclick="deleteAddOn(${a.id})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                </td>
            </tr>
        `;
    });
}

document.getElementById('addBtn').addEventListener('click', () => {
    editingId = null;
    modalTitle.textContent = "Add AddOn";
    addonName.value = '';
    addonPrice.value = '';
    modal.classList.remove('hidden');
});

document.getElementById('cancelBtn').addEventListener('click', () => modal.classList.add('hidden'));

document.getElementById('saveBtn').addEventListener('click', () => {
    const data = { name: addonName.value, price: addonPrice.value };
    if (!data.name || !data.price) return alert("Fill all fields");

    if (editingId) {
        axios.put(`/api/addons/${editingId}`, data)
            .then(() => { fetchAddOns(); modal.classList.add('hidden'); })
            .catch(err => console.error(err));
    } else {
        axios.post('/api/addons', data)
            .then(() => { fetchAddOns(); modal.classList.add('hidden'); })
            .catch(err => console.error(err));
    }
});

function editAddOn(id) {
    const addon = addons.find(a => a.id === id);
    if (!addon) return;
    editingId = id;
    modalTitle.textContent = "Edit AddOn";
    addonName.value = addon.name;
    addonPrice.value = addon.price;
    modal.classList.remove('hidden');
}

function deleteAddOn(id) {
    if (!confirm("Are you sure?")) return;
    axios.delete(`/api/addons/${id}`)
        .then(() => fetchAddOns())
        .catch(err => console.error(err));
}

fetchAddOns();
</script>
