let u=0;document.addEventListener("DOMContentLoaded",function(){const e=document.getElementById("icon");e&&(e.addEventListener("change",d),d.call(e));const t=document.getElementById("daftarPertanyaan");if(t){const a=t.dataset.questions;if(a)try{const n=JSON.parse(a);Array.isArray(n)&&n.length>0?n.forEach(i=>o(i)):o()}catch(n){console.error("Error parsing questions data:",n),o()}else o()}});function d(){const e=this.value,t=document.getElementById("iconPreview");t&&(e?t.innerHTML=`<i class="${e} text-blue-600"></i>`:t.innerHTML='<i class="fas fa-image"></i>')}function o(e=null){const t=document.getElementById("daftarPertanyaan");if(!t)return;const a=u,n=t.querySelectorAll(".pertanyaan-item").length+1,i=e?e.teks_pertanyaan:"",s=e?e.jenis_pertanyaan:"",y=e&&e.kategori||"",m=e?e.wajib_diisi==1||e.wajib_diisi===!0:!0,b=e&&e.id?`<input type="hidden" name="pertanyaan[${a}][id]" value="${e.id}">`:"";let r="",p="none";if(s==="pilihan_ganda"){p="block";let l=[];e&&e.opsi_jawaban&&(l=Array.isArray(e.opsi_jawaban)?e.opsi_jawaban:JSON.parse(e.opsi_jawaban)),l.length===0&&!e&&(l=["",""]),l.forEach((g,h)=>{r+=c(a,h+1,g)})}else r+=c(a,1,""),r+=c(a,2,"");const f=`
        <div class="pertanyaan-item bg-gray-50 rounded-lg border border-gray-200 p-5 mb-4" data-index="${a}">
            ${b}
            <div class="flex items-start justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Pertanyaan ${n}</h4>
                <button type="button" onclick="hapusPertanyaan(this)" class="text-red-600 hover:text-red-800 cursor-pointer" title="Hapus Pertanyaan">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Teks Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="pertanyaan[${a}][teks_pertanyaan]" 
                        rows="2"
                        class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan pertanyaan..."
                        required
                    >${i}</textarea>
                </div>
                
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="pertanyaan[${a}][jenis_pertanyaan]"
                        class="jenis-pertanyaan-select w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        onchange="toggleOpsiJawaban(this)"
                        required
                    >
                        <option value="">Pilih Jenis</option>
                        <option value="likert" ${s==="likert"?"selected":""}>Skala Likert (1-5)</option>
                        <option value="pilihan_ganda" ${s==="pilihan_ganda"?"selected":""}>Pilihan Ganda</option>
                        <option value="isian" ${s==="isian"?"selected":""}>Isian Teks</option>
                    </select>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori
                    </label>
                    <div class="flex items-center gap-3">
                        <input 
                            type="text" 
                            name="pertanyaan[${a}][kategori]"
                            value="${y}"
                            class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Contoh: Layanan, Fasilitas, dll"
                        >
                        
                        <div class="flex items-center flex-shrink-0">
                            <input 
                                type="checkbox" 
                                name="pertanyaan[${a}][wajib_diisi]"
                                value="1"
                                ${m?"checked":""}
                                class="rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                                id="wajib_${a}"
                            >
                            <label for="wajib_${a}" class="ml-2 text-sm text-gray-700">
                                <i class="fas fa-asterisk text-red-500 text-xs mr-1"></i>
                                Wajib diisi
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Opsi Jawaban untuk Pilihan Ganda -->
                <div class="md:col-span-3 opsi-jawaban-container" style="display: ${p};">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Opsi Jawaban <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-2 opsi-list" data-pertanyaan="${a}">
                        ${r}
                    </div>
                    <button type="button" onclick="tambahOpsi(${a})" class="mt-2 text-sm text-blue-600 hover:text-blue-800 cursor-pointer inline-flex items-center">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Tambah Opsi
                    </button>
                </div>
            </div>
        </div>
    `;t.insertAdjacentHTML("beforeend",f),u++}function c(e,t,a=""){return`
        <div class="flex gap-2 opsi-item">
            <input 
                type="text" 
                name="pertanyaan[${e}][opsi][]"
                value="${a.replace(/"/g,"&quot;")}"
                class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="Opsi ${t}"
            >
            <button type="button" onclick="hapusOpsi(this)" class="px-3 py-2 text-red-600 hover:text-red-800 cursor-pointer" title="Hapus Opsi">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `}function x(e){confirm("Yakin ingin menghapus pertanyaan ini?")&&(e.closest(".pertanyaan-item").remove(),v())}function v(){document.querySelectorAll(".pertanyaan-item").forEach((t,a)=>{t.querySelector("h4").textContent=`Pertanyaan ${a+1}`})}function w(e){const t=e.closest(".pertanyaan-item"),a=t.querySelector(".opsi-jawaban-container"),n=t.querySelectorAll('.opsi-jawaban-container input[type="text"]');e.value==="pilihan_ganda"?(a.style.display="block",n.forEach(i=>i.required=!0)):(a.style.display="none",n.forEach(i=>i.required=!1))}function k(e){const t=document.querySelector(`.opsi-list[data-pertanyaan="${e}"]`);if(!t)return;const a=t.querySelectorAll(".opsi-item").length+1,n=c(e,a,"");if(t.insertAdjacentHTML("beforeend",n),t.closest(".opsi-jawaban-container").style.display!=="none"){const s=t.lastElementChild.querySelector("input");s&&(s.required=!0)}}function $(e){const t=e.closest(".opsi-list");t.querySelectorAll(".opsi-item").length>2?(e.closest(".opsi-item").remove(),j(t)):alert("Minimal harus ada 2 opsi jawaban")}function j(e){e.querySelectorAll(".opsi-item").forEach((a,n)=>{const i=a.querySelector("input");i.placeholder=`Opsi ${n+1}`})}window.tambahPertanyaan=o;window.hapusPertanyaan=x;window.toggleOpsiJawaban=w;window.tambahOpsi=k;window.hapusOpsi=$;
