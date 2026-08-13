</main>
<footer class="mt-14 border-t line bg-[var(--surface)]">
 <div class="max-w-[1480px] mx-auto px-5 py-10 grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
  <div class="lg:col-span-2"><div class="font-black text-2xl">PAROKO</div><p class="text-sm opacity-60 mt-3 max-w-md">Gadgets, jerseys and fashion with a fast checkout experience built for Bangladesh.</p></div>
  <div><div class="font-bold mb-3">Shop</div><a class="block text-sm opacity-60 mb-2" href="/gadgets">Gadgets</a><a class="block text-sm opacity-60 mb-2" href="/jersey">Jersey</a><a class="block text-sm opacity-60" href="/fashion">Fashion</a></div>
  <div><div class="font-bold mb-3">Support</div><div class="text-sm opacity-60 space-y-2"><div>Cash on Delivery</div><div>Fast Delivery</div><div>WhatsApp <?=e(setting('store_phone'))?></div></div></div>
 </div>
 <div class="border-t line py-4 text-center text-xs opacity-45">© <?=date('Y')?> PAROKO</div>
</footer>

<nav class="lg:hidden fixed bottom-0 inset-x-0 z-50 bg-[color-mix(in_srgb,var(--surface)_92%,transparent)] backdrop-blur-xl border-t line px-2 py-2">
 <div class="grid grid-cols-5 text-center">
  <a href="/" class="py-1.5 text-[10px] font-bold"><span class="iconify block mx-auto text-xl mb-0.5" data-icon="solar:home-2-linear"></span>Home</a>
  <a href="/category/<?=e(current_niche())?>" class="py-1.5 text-[10px] font-bold opacity-70"><span class="iconify block mx-auto text-xl mb-0.5" data-icon="solar:widget-4-linear"></span>Categories</a>
  <a href="/search.php" class="py-1.5 text-[10px] font-bold opacity-70"><span class="iconify block mx-auto text-xl mb-0.5" data-icon="solar:magnifer-linear"></span>Search</a>
  <a href="/wishlist.php" class="py-1.5 text-[10px] font-bold opacity-70"><span class="iconify block mx-auto text-xl mb-0.5" data-icon="solar:heart-linear"></span>Wishlist</a>
  <a href="/account.php" class="py-1.5 text-[10px] font-bold opacity-70"><span class="iconify block mx-auto text-xl mb-0.5" data-icon="solar:user-linear"></span>Account</a>
 </div>
</nav>

<script>
async function api(url, body){const r=await fetch(url,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'<?=e(csrf_token())?>'},body:JSON.stringify(body)});return await r.json();}
function setCartCount(n){const e=document.getElementById('cartCount');if(e)e.textContent=n;}
async function addToCart(payload){const d=await api('/api/cart.php',payload);if(!d.ok){alert(d.message||'Unable to add');return d;}setCartCount(d.count);return d;}
async function addQuick(id){const d=await addToCart({product_id:id,qty:1});if(d.ok)setCartCount(d.count);}
async function compareProduct(id){const r=await fetch('/api/compare.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({product_id:id})});if(r.ok)location.href='/compare.php';}
</script>
<script>(function(){const r=document.documentElement,s=localStorage.getItem('paroko-theme');if(s==='dark'||s==='light')r.dataset.theme=s;const b=document.getElementById('themeToggle'),i=document.getElementById('themeIcon');function sync(){const d=r.dataset.theme==='dark';if(i){i.setAttribute('data-icon',d?'solar:sun-2-linear':'solar:moon-linear');if(window.Iconify)Iconify.scan(i)}}b?.addEventListener('click',()=>{r.dataset.theme=r.dataset.theme==='dark'?'light':'dark';localStorage.setItem('paroko-theme',r.dataset.theme);sync()});sync()})();</script></body></html>
