<x-admin-layout>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Manage Offers</h2>

        <div class="flex gap-4 mb-4">
            <button id="addBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">+ Add Offer</button>
            <button id="refreshBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Refresh</button>
        </div>

        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Created</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="offersTable"></tbody>
        </table>
    </div>

    <!-- modal -->
    <div id="offerModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow w-11/12 md:w-2/3 lg:w-1/2">
            <h3 id="modalTitle" class="text-lg font-bold mb-4">Add Offer</h3>

            <div class="grid grid-cols-1 gap-3">
                <input id="offerTitle" type="text" placeholder="Title" class="w-full border p-2">
                <textarea id="offerDescription" placeholder="Description" class="w-full border p-2"></textarea>

                <div class="flex justify-end gap-2 mt-4">
                    <button id="saveOfferBtn" class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded">Save</button>
                    <button id="cancelOfferBtn" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const token = localStorage.getItem('admin_token');
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

axios.get('/api/offers')
  .then(res => {
    // render offers table
  })
  .catch(err => {
    if(err.response?.status === 401){
        localStorage.removeItem('admin_token');
        window.location.href = '/admin/login';
    }
});

    async function fetchOffers() {
        try {
            const res = await axios.get('/api/admin/offers');
            offers = res.data;
            renderOffers();
        } catch (err) {
            console.error(err);
            if (err.response?.status === 401) {
                alert('Session expired. Please login again.');
                localStorage.removeItem('admin_token');
                window.location.href = '/admin/login';
            }
        }
    }

    function renderOffers() {
        const tbody = document.getElementById('offersTable');
        tbody.innerHTML = '';
        offers.forEach((o, i) => {
            tbody.innerHTML += `
                <tr class="${i % 2 === 0 ? 'bg-white' : 'bg-gray-50'}">
                    <td class="border px-4 py-2">${o._id ?? o.id}</td>
                    <td class="border px-4 py-2">${escapeHtml(o.title)}</td>
                    <td class="border px-4 py-2">${escapeHtml(o.description ?? '')}</td>
                    <td class="border px-4 py-2">${new Date(o.created_at ?? o.createdAt ?? Date.now()).toLocaleString()}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <button onclick="openEdit('${o._id ?? o.id}')" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button onclick="deleteOffer('${o._id ?? o.id}')" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </td>
                </tr>
            `;
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>"'`=\/]/g, s => ({
            '&': '&amp;','<': '&lt;','>': '&gt;','"': '&quot;', "'": '&#39;',
            '/': '&#x2F;','`':'&#x60;','=':'&#x3D;'
        })[s]);
    }

    document.getElementById('addBtn').addEventListener('click', () => {
        editingId = null;
        document.getElementById('modalTitle').textContent = 'Add Offer';
        document.getElementById('offerTitle').value = '';
        document.getElementById('offerDescription').value = '';
        document.getElementById('offerModal').classList.remove('hidden');
    });

    document.getElementById('cancelOfferBtn').addEventListener('click', () => {
        document.getElementById('offerModal').classList.add('hidden');
    });

    document.getElementById('saveOfferBtn').addEventListener('click', async () => {
        const title = document.getElementById('offerTitle').value.trim();
        const description = document.getElementById('offerDescription').value.trim();

        if (!title) return alert('Title is required');

        try {
            if (editingId) {
                // update via POST with _method=PUT (works better in some setups)
                const fd = new FormData();
                fd.append('title', title);
                fd.append('description', description);
                fd.append('_method', 'PUT');
                await axios.post(`/api/admin/offers/${editingId}`, fd);
            } else {
                await axios.post('/api/admin/offers', { title, description });
            }

            document.getElementById('offerModal').classList.add('hidden');
            fetchOffers();
        } catch (err) {
            console.error(err);
            alert(err.response?.data?.message || 'Failed to save offer');
        }
    });

    window.openEdit = async function(id) {
        editingId = id;
        document.getElementById('modalTitle').textContent = 'Edit Offer';
        try {
            const res = await axios.get(`/api/admin/offers/${id}`);
            const o = res.data;
            document.getElementById('offerTitle').value = o.title || '';
            document.getElementById('offerDescription').value = o.description || '';
            document.getElementById('offerModal').classList.remove('hidden');
        } catch (err) {
            console.error(err);
            alert('Failed to load offer');
        }
    };

    async function deleteOffer(id) {
        if (!confirm('Delete this offer?')) return;
        try {
            await axios.delete(`/api/admin/offers/${id}`);
            fetchOffers();
        } catch (err) {
            console.error(err);
            alert('Failed to delete');
        }
    }

    document.getElementById('refreshBtn').addEventListener('click', fetchOffers);

    // load initially
    fetchOffers();
</script>
