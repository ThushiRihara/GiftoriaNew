<x-admin-layout>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Manage Gifts</h2>

        <div class="flex gap-4 mb-4">
            <button id="addBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">+ Add Gift</button>
            <button id="refreshBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Refresh</button>
        </div>

        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Image</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Stock</th>
                    <th class="border px-4 py-2">Category</th>
                    <th class="border px-4 py-2">Add-Ons</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="giftsTable"></tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="giftModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow w-11/12 md:w-2/3 lg:w-1/2">
            <h3 id="modalTitle" class="text-lg font-bold mb-4">Add Gift</h3>

            <div class="grid grid-cols-1 gap-3">
                <input id="giftName" type="text" placeholder="Name" class="w-full border p-2">
                <input id="giftPrice" type="number" step="0.01" placeholder="Price" class="w-full border p-2">
                <input id="giftStock" type="number" placeholder="Stock Quantity" class="w-full border p-2">

                <select id="giftCategory" class="w-full border p-2">
                    <option value="">Select Category</option>
                </select>

                <div>
                    <label class="block mb-1 font-medium">Available Add-Ons (select multiple):</label>
                    <select id="giftAddOns" multiple class="w-full border p-2 h-32"></select>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Image</label>
                    <input id="giftImage" type="file" accept="image/*" class="w-full">
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button id="saveGiftBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save</button>
                    <button id="cancelGiftBtn" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .gift-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px; /* optional rounded corners */
        }
    </style>
</x-admin-layout>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
const token = localStorage.getItem('admin_token');
if (!token) {
    alert('Please login as admin.');
    window.location.href = '/admin/login';
}
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

let gifts = [], categories = [], addOns = [], editingId = null;

const giftModal = document.getElementById('giftModal');
const giftName = document.getElementById('giftName');
const giftPrice = document.getElementById('giftPrice');
const giftStock = document.getElementById('giftStock');
const giftCategory = document.getElementById('giftCategory');
const giftAddOns = document.getElementById('giftAddOns');
const giftImage = document.getElementById('giftImage');

// Populate dropdowns
function populateCategories() {
    giftCategory.innerHTML = '<option value="">Select Category</option>';
    categories.forEach(c => {
        giftCategory.innerHTML += `<option value="${c.id}">${c.category_name || c.name}</option>`;
    });
}

function populateAddOns() {
    giftAddOns.innerHTML = '';
    addOns.forEach(a => {
        giftAddOns.innerHTML += `<option value="${a.id}">${a.name} (Rs ${a.price})</option>`;
    });
}

// Fetch categories, add-ons, gifts
function fetchData() {
    axios.get('/api/gifts/form-data')
        .then(res => {
            categories = res.data.categories;
            addOns = res.data.addOns;
            populateCategories();
            populateAddOns();
        })
        .catch(console.error);

    fetchGifts();
}

// Fetch gifts
function fetchGifts() {
    axios.get('/api/gifts')
        .then(res => { gifts = res.data; renderGiftsTable(); })
        .catch(err => {
            console.error(err);
            if (err.response?.status === 401) {
                localStorage.removeItem('admin_token');
                window.location.href = '/admin/login';
            }
        });
}

// Render gifts table
function renderGiftsTable() {
    const tbody = document.getElementById('giftsTable');
    tbody.innerHTML = '';
    gifts.forEach(g => {
        const addonNames = (g.addOns || g.add_ons || []).map(a => a.name).join(', ');
        const imageHtml = g.image ? `<img src="/storage/${g.image}" class="gift-image" />` : '';
        tbody.innerHTML += `
            <tr>
                <td class="border px-4 py-2">${g.id}</td>
                <td class="border px-4 py-2">${imageHtml}</td>
                <td class="border px-4 py-2">${g.name}</td>
                <td class="border px-4 py-2">${g.price}</td>
                <td class="border px-4 py-2">${g.stock_quantity}</td>
                <td class="border px-4 py-2">${g.category?.category_name || g.category?.name || '-'}</td>
                <td class="border px-4 py-2">${addonNames}</td>
                <td class="border px-4 py-2 space-x-2">
                    <button onclick="openEdit(${g.id})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                    <button onclick="removeGift(${g.id})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                </td>
            </tr>
        `;
    });
}

// Modal Handlers
document.getElementById('addBtn').addEventListener('click', () => {
    editingId = null;
    document.getElementById('modalTitle').textContent = 'Add Gift';
    resetForm();
    giftModal.classList.remove('hidden');
});

document.getElementById('cancelGiftBtn').addEventListener('click', () => giftModal.classList.add('hidden'));

// Save gift
document.getElementById('saveGiftBtn').addEventListener('click', async () => {
    const name = giftName.value.trim();
    const price = giftPrice.value;
    const stock = giftStock.value;
    const categoryId = giftCategory.value;
    const selectedAddOns = Array.from(giftAddOns.selectedOptions).map(o => o.value);

    if (!name || !price || !stock || !categoryId) return alert('Please fill name, price, stock, category.');

    const form = new FormData();
    form.append('name', name);
    form.append('price', price);
    form.append('stock_quantity', stock);
    form.append('category_id', categoryId);
    selectedAddOns.forEach(id => form.append('add_ons[]', id));
    if (giftImage.files[0]) form.append('image', giftImage.files[0]);

    try {
        if (editingId) {
            form.append('_method','PUT');
            await axios.post(`/api/gifts/${editingId}`, form, { headers:{'Content-Type':'multipart/form-data'} });
        } else {
            await axios.post('/api/gifts', form, { headers:{'Content-Type':'multipart/form-data'} });
        }
        giftModal.classList.add('hidden');
        fetchGifts();
    } catch(err){
        console.error(err);
        const errors = err.response?.data?.errors;
        if (errors) alert(Object.values(errors).flat().join('\n'));
        else alert(err.response?.data?.message || 'Failed to save gift');
    }
});

// Open edit modal
function openEdit(id) {
    const g = gifts.find(x=>x.id===id);
    if (!g) return alert('Gift not found locally.');

    editingId = id;
    document.getElementById('modalTitle').textContent = 'Edit Gift';

    giftName.value = g.name;
    giftPrice.value = g.price;
    giftStock.value = g.stock_quantity;
    giftCategory.value = g.category_id ?? g.category?.id ?? '';

    const addonIds = (g.addOns || []).map(a => String(a.id));
    Array.from(giftAddOns.options).forEach(opt => opt.selected = addonIds.includes(opt.value));

    giftImage.value = '';
    giftModal.classList.remove('hidden');
}

// Delete gift
async function removeGift(id) {
    if (!confirm('Delete this gift?')) return;
    try { await axios.delete(`/api/gifts/${id}`); fetchGifts(); }
    catch(err){ console.error(err); alert('Failed to delete gift'); }
}

// Refresh button
document.getElementById('refreshBtn').addEventListener('click', fetchGifts);

// Reset form
function resetForm() {
    giftName.value = '';
    giftPrice.value = '';
    giftStock.value = '';
    giftCategory.value = '';
    giftAddOns.selectedIndex = -1;
    giftImage.value = '';
}

// Initial fetch
fetchData();
</script>
