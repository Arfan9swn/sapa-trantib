@extends('layout.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Log Aktivitas</h1>
            <p class="text-white/60 text-sm">Catatan aktivitas perubahan data laporan masyarakat</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Aktivitas
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 text-sm">{{ session('error') }}</div>
    @endif

    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] p-6 mb-6">
        <div class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1 relative">
                <input type="text" id="activitySearch" placeholder="Cari aktivitas, laporan atau user..." onkeyup="filterActivities()" class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
            </div>
            <div class="text-right hidden sm:block">
                <p class="text-xs text-white/50" id="activityCount">0 aktivitas</p>
            </div>
        </div>
    </div>

    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] shadow-lg overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#1a3326]/50">
                    <tr class="border-b border-[#4a6a56]">
                        <th class="px-4 py-3 text-white/70 text-sm font-medium w-8">#</th>
                        <th class="px-4 py-3 text-white/70 text-sm font-medium">Laporan</th>
                        <th class="px-4 py-3 text-white/70 text-sm font-medium">User</th>
                        <th class="px-4 py-3 text-white/70 text-sm font-medium">Aksi</th>
                        <th class="px-4 py-3 text-white/70 text-sm font-medium">Nilai Lama</th>
                        <th class="px-4 py-3 text-white/70 text-sm font-medium">Nilai Baru</th>
                        <th class="px-4 py-3 text-white/70 text-sm font-medium">Tanggal</th>
                        <th class="px-4 py-3 text-white/70 text-sm font-medium text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody id="activitiesTableBody" class="text-white/90 divide-y divide-[#4a6a56]/30">
                    <tr><td colspan="8" class="px-4 py-8 text-center text-white/50">Memuat aktivitas...</td></tr>
                </tbody>
            </table>
        </div>
        <div id="activitiesEmpty" class="hidden px-8 py-12 text-center">
            <p class="text-white/50 text-sm">Belum ada aktivitas tercatat.</p>
            <button onclick="openCreateModal()" class="mt-4 inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 text-sm font-medium underline underline-offset-4">Tambah aktivitas pertama</button>
        </div>
    </div>
</div>

<!-- Modal: Tambah / Ubah Aktivitas -->
<div id="activityModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeActivityModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-[#2d4a3a] border border-[#4a6a56] rounded-2xl p-6 w-full max-w-2xl shadow-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 id="activityModalTitle" class="text-white font-semibold text-lg">Tambah Aktivitas</h3>
                <button onclick="closeActivityModal()" class="text-white/50 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div id="activityFormError" class="mb-4 hidden p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 text-sm"></div>
            <form id="activityForm" onsubmit="handleSaveActivity(event)" class="space-y-4">
                <input type="hidden" id="activityId">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-1">Laporan <span class="text-red-500">*</span></label>
                        <select id="activityReportId" required class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Pilih laporan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-1">User</label>
                        <select id="activityUserId" class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="">Pilih user (opsional)</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-1">Aksi <span class="text-red-500">*</span></label>
                    <input type="text" id="activityAction" required placeholder="Contoh: Status diubah" maxlength="50" class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-1">Nilai Lama</label>
                        <textarea id="activityOldValue" rows="2" class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/90 mb-1">Nilai Baru</label>
                        <textarea id="activityNewValue" rows="2" class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/90 mb-1">Tanggal <span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="activityCreatedAt" required class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#4a6a56]/50">
                    <button type="button" onclick="closeActivityModal()" class="px-6 py-2 rounded-xl bg-[#4a6a56] text-white text-sm font-medium hover:bg-[#4a6a56]/80 transition-colors">Batal</button>
                    <button type="submit" id="activitySaveBtn" class="px-6 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-500 transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Detail Aktivitas (Show) -->
<div id="activityDetailModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeActivityDetailModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-[#2d4a3a] border border-[#4a6a56] rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-white font-semibold text-lg">Detail Aktivitas</h3>
                <button onclick="closeActivityDetailModal()" class="text-white/50 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div id="activityDetailBody" class="space-y-4 text-sm"></div>
            <div class="pt-6 border-t border-[#4a6a56]/50 flex justify-end">
                <button onclick="closeActivityDetailModal()" class="px-6 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-500 transition-colors">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Konfirmasi Hapus -->
<div id="activityDeleteModal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeActivityDeleteModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="bg-[#2d4a3a] border border-[#4a6a56] rounded-2xl p-6 w-full max-w-sm shadow-2xl">
            <h3 class="text-white font-semibold text-lg mb-1">Hapus Aktivitas</h3>
            <p class="text-white/60 text-sm mb-6">Apakah Anda yakin ingin menghapus aktivitas ini? Data tidak dapat dikembalikan.</p>
            <div class="flex gap-3">
                <button onclick="closeActivityDeleteModal()" class="flex-1 py-2 rounded-xl bg-[#4a6a56] text-white text-sm font-medium hover:bg-[#4a6a56]/80 transition-colors">Batal</button>
                <button onclick="confirmDeleteActivity()" class="flex-1 py-2 rounded-xl bg-[#a63d3d] text-white text-sm font-medium hover:bg-[#8f3333] transition-colors">Hapus</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const API_ACTIVITY = '/api/rep-activity';
const API_REPS = '/api/reps';
const API_USERS = '/api/users';

let activities = [];
let pendingDeleteId = null;

const els = {
    search: document.getElementById('activitySearch'),
    tbody: document.getElementById('activitiesTableBody'),
    empty: document.getElementById('activitiesEmpty'),
    count: document.getElementById('activityCount'),
    modal: document.getElementById('activityModal'),
    modalTitle: document.getElementById('activityModalTitle'),
    detailModal: document.getElementById('activityDetailModal'),
    deleteModal: document.getElementById('activityDeleteModal'),
    form: document.getElementById('activityForm'),
    formError: document.getElementById('activityFormError'),
    saveBtn: document.getElementById('activitySaveBtn'),
    id: document.getElementById('activityId'),
    reportId: document.getElementById('activityReportId'),
    userId: document.getElementById('activityUserId'),
    action: document.getElementById('activityAction'),
    oldValue: document.getElementById('activityOldValue'),
    newValue: document.getElementById('activityNewValue'),
    createdAt: document.getElementById('activityCreatedAt'),
    detailBody: document.getElementById('activityDetailBody'),
};

function escapeHtml(str) {
    if (str == null) return '';
    return String(str).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#039;"}[c]));
}

function nowDateTimeLocal() {
    const d = new Date();
    const pad = n => String(n).padStart(2, '0');
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
}

function formatDate(value) {
    if (!value) return '—';
    const d = new Date(String(value).replace(' ', 'T'));
    if (isNaN(d.getTime())) return String(value);
    return d.toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

function toDateTimeLocal(value) {
    if (!value) return '';
    const d = new Date(String(value).replace(' ', 'T'));
    return isNaN(d.getTime()) ? '' : d.toISOString().slice(0, 16);
}

function actionBadge(action) {
    const a = String(action || '').toLowerCase();
    let color = 'border-gray-500 text-gray-400';
    if (a.includes('status')) color = 'border-emerald-500 text-emerald-400';
    else if (a.includes('assign')) color = 'border-blue-500 text-blue-400';
    else if (a.includes('hapus') || a.includes('delete')) color = 'border-red-500 text-red-400';
    else if (a.includes('update') || a.includes('ubah')) color = 'border-amber-500 text-amber-400';
    return `<span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium border ${color}">${escapeHtml(action || '—')}</span>`;
}

async function init() {
    try {
        const [repsRes, usersRes] = await Promise.all([fetch(API_REPS), fetch(API_USERS)]);
        const reps = await repsRes.json();
        const users = await usersRes.json();
        els.reportId.innerHTML = '<option value="">Pilih laporan</option>' + reps.map(r => `<option value="${r.report_id}">${escapeHtml(r.reference_code)} - ${escapeHtml(r.title)}</option>`).join('');
        els.userId.innerHTML = '<option value="">Pilih user (opsional)</option>' + users.map(u => `<option value="${u.user_id}">${escapeHtml(u.username)}</option>`).join('');
        await loadActivities();
    } catch (e) {
        showToast('Gagal memuat data awal: ' + e.message, 'error');
    }
}

async function loadActivities() {
    try {
        const res = await fetch(API_ACTIVITY);
        activities = await res.json();
    } catch (e) {
        activities = [];
        showToast('Gagal memuat aktivitas: ' + e.message, 'error');
    }
    renderTable(activities);
}

function renderTable(list) {
    els.count.textContent = list.length + ' aktivitas';
    if (list.length === 0) {
        els.tbody.innerHTML = '';
        els.empty.classList.remove('hidden');
        return;
    }
    els.empty.classList.add('hidden');
    els.tbody.innerHTML = list.map((a, i) => {
        const report = a.report || {};
        const user = a.user || {};
        const reportLabel = (report.reference_code || '') + (report.title ? ' - ' + report.title : '');
        return `<tr class="border-b border-[#4a6a56]/30 hover:bg-[#1a3326]/30 transition-colors">
            <td class="px-4 py-3 text-white/50 text-sm text-center">${i + 1}</td>
            <td class="px-4 py-3 text-sm"><div class="text-white font-medium truncate" title="${escapeHtml(reportLabel)}">${escapeHtml(reportLabel) || '—'}</div><div class="text-xs text-white/50">ID ${a.report_id}</div></td>
            <td class="px-4 py-3 text-sm"><div class="text-white font-medium">${escapeHtml(user.username || '—')}</div><div class="text-xs text-white/50">ID ${a.user_id || '—'}</div></td>
            <td class="px-4 py-3 text-sm">${actionBadge(a.action)}</td>
            <td class="px-4 py-3 text-sm"><div class="text-white/80 truncate max-w-xs" title="${escapeHtml(a.old_value)}">${escapeHtml(a.old_value) || '<span class="text-white/40">—</span>'}</div></td>
            <td class="px-4 py-3 text-sm"><div class="text-white/80 truncate max-w-xs" title="${escapeHtml(a.new_value)}">${escapeHtml(a.new_value) || '<span class="text-white/40">—</span>'}</div></td>
            <td class="px-4 py-3 text-sm text-white/80">${formatDate(a.created_at)}</td>
            <td class="px-4 py-3 text-center">
                <div class="flex items-center justify-center gap-1">
                    <button onclick="viewActivity(${a.activity_id})" class="w-8 h-8 rounded-lg bg-[#4a6a56]/60 flex items-center justify-center text-[#8fd89b] hover:bg-[#4a6a56] hover:text-white transition-colors text-xs" title="Lihat"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></button>
                    <button onclick="openEditModal(${a.activity_id})" class="w-8 h-8 rounded-lg bg-[#4a6a56]/60 flex items-center justify-center text-[#8fd89b] hover:bg-[#4a6a56] hover:text-white transition-colors text-xs" title="Ubah"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.414l8.586-8.586z"></path></svg></button>
                    <button onclick="openDeleteModal(${a.activity_id})" class="w-8 h-8 rounded-lg bg-[#a63d3d]/20 flex items-center justify-center text-red-400 hover:bg-[#a63d3d] hover:text-white transition-colors text-xs" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                </div>
            </td>
        </tr>`;
    }).join('');
}

function filterActivities() {
    const q = els.search.value.toLowerCase();
    const filtered = activities.filter(a => {
        const report = a.report || {};
        const user = a.user || {};
        const haystack = ((report.reference_code || '') + ' ' + (report.title || '') + ' ' + (user.username || '') + ' ' + (a.action || '') + ' ' + (a.old_value || '') + ' ' + (a.new_value || '')).toLowerCase();
        return haystack.includes(q);
    });
    renderTable(filtered);
}

function openCreateModal() {
    els.form.reset();
    els.id.value = '';
    els.modalTitle.textContent = 'Tambah Aktivitas';
    els.formError.classList.add('hidden');
    els.createdAt.value = nowDateTimeLocal();
    els.saveBtn.textContent = 'Simpan';
    els.modal.classList.remove('hidden');
}

function closeActivityModal() {
    els.modal.classList.add('hidden');
}

function openEditModal(id) {
    const a = activities.find(x => x.activity_id == id);
    if (!a) { showToast('Aktivitas tidak ditemukan', 'error'); return; }
    els.id.value = a.activity_id;
    els.modalTitle.textContent = 'Ubah Aktivitas';
    els.formError.classList.add('hidden');
    els.reportId.value = a.report_id || '';
    els.userId.value = a.user_id || '';
    els.action.value = a.action || '';
    els.oldValue.value = a.old_value || '';
    els.newValue.value = a.new_value || '';
    els.createdAt.value = toDateTimeLocal(a.created_at);
    els.saveBtn.textContent = 'Perbarui';
    els.modal.classList.remove('hidden');
}

function viewActivity(id) {
    fetch(`${API_ACTIVITY}/${id}`)
        .then(res => res.json())
        .then(a => {
            const report = a.report || {};
            const user = a.user || {};
            els.detailBody.innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div><span class="text-white/50 block text-xs">Laporan</span><div class="text-white">${escapeHtml(report.reference_code)} - ${escapeHtml(report.title)}</div><span class="text-xs text-white/50">ID ${a.report_id}</span></div>
                    <div><span class="text-white/50 block text-xs">User</span><div class="text-white">${escapeHtml(user.username) || '—'}</div><span class="text-xs text-white/50">ID ${a.user_id || '—'}</span></div>
                    <div><span class="text-white/50 block text-xs">Aksi</span>${actionBadge(a.action)}</div>
                    <div><span class="text-white/50 block text-xs">Tanggal</span><div class="text-white">${formatDate(a.created_at)}</div></div>
                </div>
                <div><span class="text-white/50 block text-xs">Nilai Lama</span><div class="text-white/90 whitespace-pre-wrap break-words">${escapeHtml(a.old_value) || '<span class="text-white/40">—</span>'}</div></div>
                <div><span class="text-white/50 block text-xs">Nilai Baru</span><div class="text-white/90 whitespace-pre-wrap break-words">${escapeHtml(a.new_value) || '<span class="text-white/40">—</span>'}</div></div>
            `;
            els.detailModal.classList.remove('hidden');
        })
        .catch(() => showToast('Gagal memuat detail aktivitas', 'error'));
}

function closeActivityDetailModal() { els.detailModal.classList.add('hidden'); }
function openDeleteModal(id) { pendingDeleteId = id; els.deleteModal.classList.remove('hidden'); }
function closeActivityDeleteModal() { pendingDeleteId = null; els.deleteModal.classList.add('hidden'); }

function confirmDeleteActivity() {
    if (!pendingDeleteId) return;
    fetch(`${API_ACTIVITY}/${pendingDeleteId}`, { method: 'DELETE', headers: { Accept: 'application/json' } })
        .then(res => {
            if (!res.ok) throw new Error('Gagal menghapus');
            closeActivityDeleteModal();
            loadActivities();
            showToast('Aktivitas berhasil dihapus', 'success');
        })
        .catch(() => showToast('Gagal menghapus aktivitas', 'error'));
}

async function handleSaveActivity(e) {
    e.preventDefault();
    els.formError.classList.add('hidden');
    const id = els.id.value;
    const url = id ? `${API_ACTIVITY}/${id}` : API_ACTIVITY;
    const method = id ? 'PUT' : 'POST';
    const body = {
        report_id: els.reportId.value ? parseInt(els.reportId.value) : null,
        user_id: els.userId.value ? parseInt(els.userId.value) : null,
        action: els.action.value,
        old_value: els.oldValue.value || null,
        new_value: els.newValue.value || null,
        created_at: els.createdAt.value,
    };
    els.saveBtn.disabled = true;
    els.saveBtn.textContent = 'Menyimpan...';
    try {
        const res = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
            body: JSON.stringify(body),
        });
        const data = await res.json();
        if (!res.ok) throw data;
        closeActivityModal();
        await loadActivities();
        showToast(id ? 'Aktivitas diperbarui' : 'Aktivitas ditambahkan', 'success');
    } catch (err) {
        els.saveBtn.disabled = false;
        els.saveBtn.textContent = id ? 'Perbarui' : 'Simpan';
        if (err && err.errors) {
            let msg = 'Perbaiki berikut:<ul class="list-disc list-inside mt-1 text-sm">';
            for (const [key, arr] of Object.entries(err.errors)) {
                msg += `<li>${escapeHtml(key)}: ${Array.isArray(arr) ? arr.join(', ') : arr}</li>`;
            }
            msg += '</ul>';
            els.formError.innerHTML = msg;
            els.formError.classList.remove('hidden');
        } else {
            showToast(err && err.message ? err.message : 'Gagal menyimpan aktivitas', 'error');
        }
    }
}

function showToast(message, type = 'success') {
    const el = document.createElement('div');
    el.className = `fixed bottom-5 right-5 px-4 py-3 rounded-xl text-sm font-medium text-white shadow-lg z-[60] ${type === 'success' ? 'bg-emerald-600' : 'bg-red-600'}`;
    el.textContent = message;
    document.body.appendChild(el);
    setTimeout(() => {
        el.style.transition = 'opacity 0.3s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 300);
    }, 2500);
}

init();
</script>
@endpush