<div class="flex items-center border bg-gray-10 rounded-[10px] w-full lg:w-64 h-9 px-5">
    <input id="searchNotifikasi" type="text" class="flex-grow outline-none bg-transparent" placeholder="Cari dinas...">
    <span class="bi bi-search text-gray-700"></span>
</div>

<script>
document.addEventListener("DOMContentLoaded",(function(){let e;document.getElementById("searchNotifikasi").addEventListener("input",(function(){const t=this.value.toLowerCase().trim();clearTimeout(e),e=setTimeout((()=>{!function(e){const t=document.querySelectorAll(".notif-item");let n=!1;t.forEach((t=>{const o=t.querySelector(".text-gray-600"),i=t.querySelector(".text-yellow-500"),l=o?o.textContent.toLowerCase():"",s=i?i.textContent.toLowerCase():"";""===e||l.includes(e)||s.includes(e)?(t.style.display="flex",n=!0):t.style.display="none"}))}(t)}),300)}))}));
</script>