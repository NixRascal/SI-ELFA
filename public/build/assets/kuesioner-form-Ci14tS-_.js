let m=0;document.addEventListener("DOMContentLoaded",function(){const e=document.getElementById("icon");e&&(e.addEventListener("change",y),y.call(e));const t=document.getElementById("daftarPertanyaan");if(t){const n=t.dataset.questions;if(n)try{const a=JSON.parse(n);Array.isArray(a)&&a.length>0?a.forEach(i=>o(i)):o()}catch(a){console.error("Error parsing questions data:",a),o()}else o()}});function y(){const e=this.value,t=document.getElementById("iconPreview");t&&(e?t.innerHTML=`<i class="${e} text-blue-600"></i>`:t.innerHTML='<i class="fas fa-image"></i>')}function o(e=null){const t=document.getElementById("daftarPertanyaan");if(!t)return;const n=m,a=t.querySelectorAll(".pertanyaan-item").length+1,i=e?e.teks_pertanyaan:"",s=e?e.jenis_pertanyaan:"",f=e&&e.kategori||"",b=e?e.wajib_diisi==1||e.wajib_diisi===!0:!0,g=e&&e.id?`<input type="hidden" name="pertanyaan[${n}][id]" value="${e.id}">`:"";let l="",p="none";if(s==="pilihan_ganda"){p="block";let r=[];e&&e.opsi_jawaban&&(r=Array.isArray(e.opsi_jawaban)?e.opsi_jawaban:JSON.parse(e.opsi_jawaban)),r.length===0&&!e&&(r=["",""]),r.forEach((v,x)=>{l+=c(n,x+1,v)})}else l+=c(n,1,""),l+=c(n,2,"");const h=`
        <div class="pertanyaan-item bg-gray-50 rounded-lg border border-gray-200 p-5 mb-4" data-index="${n}">
            ${g}
            <div class="flex items-start justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Pertanyaan ${a}</h4>
                <button type="button" onclick="konfirmasiHapusPertanyaan(this)" class="text-red-600 hover:text-red-800 cursor-pointer" title="Hapus Pertanyaan">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Teks Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="pertanyaan[${n}][teks_pertanyaan]" 
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
                        name="pertanyaan[${n}][jenis_pertanyaan]"
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
                            name="pertanyaan[${n}][kategori]"
                            value="${f}"
                            class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Contoh: Layanan, Fasilitas, dll"
                        >
                        
                        <div class="flex items-center flex-shrink-0">
                            <input 
                                type="checkbox" 
                                name="pertanyaan[${n}][wajib_diisi]"
                                value="1"
                                ${b?"checked":""}
                                class="rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                                id="wajib_${n}"
                            >
                            <label for="wajib_${n}" class="ml-2 text-sm text-gray-700">
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
                    <div class="space-y-2 opsi-list" data-pertanyaan="${n}">
                        ${l}
                    </div>
                    <button type="button" onclick="tambahOpsi(${n})" class="mt-2 text-sm text-blue-600 hover:text-blue-800 cursor-pointer inline-flex items-center">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Tambah Opsi
                    </button>
                </div>
            </div>
        </div>
    `;t.insertAdjacentHTML("beforeend",h),m++}function c(e,t,n=""){return`
        <div class="flex gap-2 opsi-item">
            <input 
                type="text" 
                name="pertanyaan[${e}][opsi][]"
                value="${n.replace(/"/g,"&quot;")}"
                class="flex-1 px-3.5 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="Opsi ${t}"
            >
            <button type="button" onclick="hapusOpsi(this)" class="px-3 py-2 text-red-600 hover:text-red-800 cursor-pointer" title="Hapus Opsi">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `}let u=null;function w(e){u=e.closest(".pertanyaan-item"),k()}function k(){const e=document.getElementById("deleteQuestionModal"),t=document.getElementById("confirmDeleteQuestionBtn");e&&(e.classList.remove("hidden"),document.body.classList.add("modal-open"),t&&(t.disabled=!1,t.classList.remove("opacity-50","cursor-not-allowed"),t.focus()))}function d(){const e=document.getElementById("deleteQuestionModal");e&&(e.classList.add("hidden"),document.body.classList.remove("modal-open")),u=null}document.addEventListener("DOMContentLoaded",function(){const e=document.getElementById("confirmDeleteQuestionBtn"),t=document.getElementById("deleteQuestionModal");e&&e.addEventListener("click",function(){u&&(u.remove(),$(),d())}),t&&t.addEventListener("click",function(n){n.target===t&&d()}),document.addEventListener("keydown",function(n){n.key==="Escape"&&d()})});function $(){document.querySelectorAll(".pertanyaan-item").forEach((t,n)=>{t.querySelector("h4").textContent=`Pertanyaan ${n+1}`})}function j(e){const t=e.closest(".pertanyaan-item"),n=t.querySelector(".opsi-jawaban-container"),a=t.querySelectorAll('.opsi-jawaban-container input[type="text"]');e.value==="pilihan_ganda"?(n.style.display="block",a.forEach(i=>i.required=!0)):(n.style.display="none",a.forEach(i=>i.required=!1))}function E(e){const t=document.querySelector(`.opsi-list[data-pertanyaan="${e}"]`);if(!t)return;const n=t.querySelectorAll(".opsi-item").length+1,a=c(e,n,"");if(t.insertAdjacentHTML("beforeend",a),t.closest(".opsi-jawaban-container").style.display!=="none"){const s=t.lastElementChild.querySelector("input");s&&(s.required=!0)}}function L(e){const t=e.closest(".opsi-list");t.querySelectorAll(".opsi-item").length>2?(e.closest(".opsi-item").remove(),O(t)):alert("Minimal harus ada 2 opsi jawaban")}function O(e){e.querySelectorAll(".opsi-item").forEach((n,a)=>{const i=n.querySelector("input");i.placeholder=`Opsi ${a+1}`})}window.tambahPertanyaan=o;window.konfirmasiHapusPertanyaan=w;window.toggleOpsiJawaban=j;window.tambahOpsi=E;window.hapusOpsi=L;window.closeDeleteQuestionModal=d;
