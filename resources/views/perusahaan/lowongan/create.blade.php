@extends('layouts.app')

@section('title', 'Posting Lowongan Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
            <h1 class="text-xl font-bold text-white">Posting Lowongan Baru</h1>
            <p class="text-indigo-100 text-sm mt-1">Isi form di bawah untuk memposting lowongan pekerjaan</p>
        </div>

        <!-- Form -->
        <form action="{{ route('perusahaan.lowongan.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Posisi -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Posisi / Jabatan <span class="text-rose-500">*</span></label>
                <input type="text" name="posisi" value="{{ old('posisi') }}" 
                       class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                       placeholder="Contoh: Staff Administrasi, Web Developer" required>
                @error('posisi') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Deskripsi Pekerjaan -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Pekerjaan <span class="text-rose-500">*</span></label>
                <textarea name="deskripsi" rows="5" 
                          class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                          placeholder="Jelaskan tanggung jawab dan tugas pekerjaan..." required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Gaji -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Gaji Minimum (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="gaji_min" value="{{ old('gaji_min') }}" 
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                           placeholder="Contoh: 3000000" required>
                    @error('gaji_min') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Gaji Maksimum (Rp) (Opsional)</label>
                    <input type="number" name="gaji_max" value="{{ old('gaji_max') }}" 
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                           placeholder="Contoh: 5000000">
                    @error('gaji_max') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Lokasi -->
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi <span class="text-rose-500">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" 
                       class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                       placeholder="Contoh: Jakarta Selatan, Makassar" required>
                @error('lokasi') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Skill yang Dibutuhkan -->
<div>
    <label class="block text-sm font-bold text-slate-700 mb-2">Skill yang Dibutuhkan <span class="text-rose-500">*</span></label>
    <div class="border border-slate-200 rounded-xl p-3 bg-slate-50">
        <div class="flex flex-wrap gap-2 mb-3" id="skills-container">
            <!-- Skills akan ditampilkan di sini -->
        </div>
        <div class="flex gap-2">
            <input type="text" id="skill-input" 
                   class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none"
                   placeholder="Contoh: Microsoft Excel, PHP, Javascript">
            <button type="button" id="add-skill-btn" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Tambah
            </button>
        </div>
        <p class="text-xs text-slate-400 mt-2">Klik Tambah untuk menambahkan skill. Bisa menambahkan beberapa skill.</p>
    </div>
    <input type="hidden" name="skill_dibutuhkan" id="skills-input" value="[]">
    @error('skill_dibutuhkan') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

            <!-- Kuota & Deadline -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kuota Pelamar <span class="text-rose-500">*</span></label>
                    <input type="number" name="kuota" value="{{ old('kuota', 1) }}" 
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                           min="1" required>
                    @error('kuota') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Deadline Lamar <span class="text-rose-500">*</span></label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}" 
                           class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                           required>
                    @error('deadline') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition">
                    <i class="fa-solid fa-save mr-2"></i> Posting Lowongan
                </button>
                <a href="{{ route('perusahaan.dashboard') }}" class="px-6 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 rounded-xl transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Skill Management
    let skills = [];
    const skillsContainer = document.getElementById('skills-container');
    const skillsInput = document.getElementById('skills-input');
    const skillInput = document.getElementById('skill-input');
    const addBtn = document.getElementById('add-skill-btn');

    function updateSkillsDisplay() {
        skillsContainer.innerHTML = '';
        skills.forEach((skill, index) => {
            const skillBadge = document.createElement('span');
            skillBadge.className = 'inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-indigo-100 text-indigo-800 text-sm';
            skillBadge.innerHTML = `${skill} <button type="button" class="remove-skill text-indigo-600 hover:text-red-600 ml-1" data-index="${index}">&times;</button>`;
            skillsContainer.appendChild(skillBadge);
        });
        skillsInput.value = JSON.stringify(skills);
    }

    addBtn.addEventListener('click', function() {
        const newSkill = skillInput.value.trim();
        if (newSkill && !skills.includes(newSkill)) {
            skills.push(newSkill);
            updateSkillsDisplay();
            skillInput.value = '';
        } else if (skills.includes(newSkill)) {
            alert('Skill sudah ada!');
        }
    });

    skillsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-skill')) {
            const index = parseInt(e.target.dataset.index);
            skills.splice(index, 1);
            updateSkillsDisplay();
        }
    });

    skillInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addBtn.click();
        }
    });
</script>
@endsection