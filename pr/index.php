<?php
require __DIR__.'/includes/bootstrap.php';

$niche=current_niche();
$cat=trim((string)get('cat',''));
$pdo=db();

function home_catalog(string $niche,string $cat=''): array {
    $pdo=db();
    $sql="SELECT p.*,c.name category_name,c.slug category_slug,
         (SELECT image FROM product_images WHERE product_id=p.id ORDER BY sort_order,id LIMIT 1) AS image
         FROM products p JOIN categories c ON c.id=p.category_id
         WHERE p.status=1 AND c.type=?";
    $params=[$niche];
    if($cat!==''){ $sql.=" AND c.slug=?"; $params[]=$cat; }
    $sql.=" ORDER BY p.featured DESC,p.is_best_seller DESC,p.created_at DESC LIMIT 12";
    $st=$pdo->prepare($sql);$st->execute($params);$products=$st->fetchAll();
    $cs=$pdo->prepare('SELECT * FROM categories WHERE type=? AND status=1 ORDER BY sort_order,name LIMIT 12');$cs->execute([$niche]);$categories=$cs->fetchAll();
    return [$products,$categories];
}
[$products,$categories]=home_catalog($niche,$cat);
$themes=[
 'gadgets'=>['eyebrow'=>'NEW ARRIVAL','title'=>"SMART TECH\nFOR SMART LIFE",'desc'=>"Latest Gadgets at\nBest Prices",'cta'=>'EXPLORE GADGETS','fallback'=>'https://placehold.co/1600x760/071513/ffffff?text=SMART+TECH+FOR+SMART+LIFE'],
 'jersey'=>['eyebrow'=>'NEW COLLECTION','title'=>"YOUR TEAM.\nYOUR JERSEY.",'desc'=>"Club, National & Custom",'cta'=>'SHOP JERSEYS','fallback'=>'https://placehold.co/1600x760/071513/ffffff?text=YOUR+TEAM+YOUR+JERSEY'],
 'fashion'=>['eyebrow'=>'NEW COLLECTION','title'=>"STAY STYLISH\nEVERYDAY",'desc'=>"Premium Quality Fashion",'cta'=>'SHOP FASHION','fallback'=>'https://placehold.co/1600x760/efe4c8/151515?text=STAY+STYLISH+EVERYDAY']
];
$heroWidget=null;
if(setting('home_banner_enabled','1')==='1'){
 $wst=$pdo->prepare("SELECT * FROM widgets WHERE status=1 AND placement='home' AND widget_type='banner' AND (niche=? OR niche='all' OR niche IS NULL) ORDER BY id LIMIT 1");
 $wst->execute([$niche]);
 if($row=$wst->fetch()){ $cfg=json_decode($row['config']??'{}',true)?:[];$heroWidget=$cfg; }
}
$theme=$themes[$niche];
$title=APP_NAME;
require __DIR__.'/includes/header.php';
?>
<div id="homeApp" data-niche="<?=e($niche)?>" data-category="<?=e($cat)?>">
<?php if(setting('home_banner_enabled','1')==='1'):?>
<section id="heroSection" class="max-w-[1480px] mx-auto px-3 sm:px-5 pt-4">
 <div class="relative overflow-hidden rounded-[26px] bg-[var(--surface)] border line" style="aspect-ratio: 16/5;">
  <?php $heroImg=!empty($heroWidget['image'])?$heroWidget['image']:$theme['fallback']; ?>
  <img id="heroImage" src="<?=e($heroImg)?>" alt="" class="absolute inset-0 w-full h-full object-contain">
  <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2"><span class="w-2.5 h-2.5 rounded-full bg-[var(--accent)]"></span><span class="w-2.5 h-2.5 rounded-full bg-white/45"></span><span class="w-2.5 h-2.5 rounded-full bg-white/45"></span></div>
 </div>
</section>
<?php endif;?>

<section class="max-w-[1480px] mx-auto px-3 sm:px-5 py-5">
 <div class="grid grid-cols-4 rounded-2xl border line overflow-hidden">
  <?php foreach([['solar:verified-check-linear','7 Days','Warranty'],['solar:hand-money-linear','Cash on','Delivery'],['solar:delivery-linear','Fast','Delivery'],['solar:shield-check-linear','Secure','Payment']] as $b):?>
   <div class="p-3 sm:p-4 flex items-center justify-center gap-2 border-r last:border-r-0 line"><span class="iconify text-xl sm:text-2xl text-[var(--accent-soft)]" data-icon="<?=$b[0]?>"></span><div class="text-[10px] sm:text-xs"><b class="block"><?=$b[1]?></b><span class="opacity-55"><?=$b[2]?></span></div></div>
  <?php endforeach;?>
 </div>
</section>

<section id="bestSection" class="<?=setting('home_best_enabled','1')==='1'?'':'hidden'?> max-w-[1480px] mx-auto px-3 sm:px-5 pb-8">
 <div class="flex items-end justify-between gap-3 mb-4"><h2 id="productSectionTitle" class="text-2xl sm:text-3xl font-black">BEST SELLING <?=strtoupper(e($niche))?></h2><a href="/category/<?=$niche?>/best" class="text-sm font-black">View All <span class="text-[var(--accent-soft)]">→</span></a></div>
 <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4"><?php foreach($products as $p): include __DIR__.'/includes/product_card.php'; endforeach;?></div><button id="loadMoreBtn" type="button" class="mt-6 mx-auto flex items-center gap-2 rounded-xl border line bg-[var(--surface)] px-5 py-3 font-black">Show More <span class="iconify" data-icon="solar:alt-arrow-down-linear"></span></button>
</section>

<section id="categorySection" class="<?=setting('home_shop_categories_enabled','1')==='1'?'':'hidden'?> max-w-[1480px] mx-auto px-3 sm:px-5 pb-10">
 <div class="flex items-end justify-between mb-4"><div><div class="text-xs tracking-[.2em] text-[var(--accent-soft)] font-black">DISCOVER</div><h2 class="text-2xl font-black mt-1">Shop by Category</h2></div><a href="/category/<?=$niche?>" class="font-black text-sm">View All →</a></div>
 <div id="categoryGrid" class="flex gap-3 overflow-x-auto hide-scrollbar pb-2">
 <?php
 $iconMap=['Smartwatch'=>'solar:watch-square-linear','Earbuds'=>'solar:headphones-round-linear','Bluetooth Speakers'=>'solar:speaker-linear','Chargers'=>'solar:plug-circle-linear','Cables'=>'solar:usb-circle-linear','Power Banks'=>'solar:battery-charge-linear','Accessories'=>'solar:scissors-square-linear','Club Jerseys'=>'solar:shirt-linear','National Teams'=>'solar:flag-linear','Football'=>'solar:football-linear','Cricket'=>'solar:ball-linear','Retro Jerseys'=>'solar:rewind-linear','Kids Jersey'=>'solar:user-id-linear','Custom Jersey'=>'solar:pen-new-square-linear','T-Shirts'=>'solar:t-shirt-linear','Shirts'=>'solar:shirt-linear','Pants'=>'solar:closet-linear','Jackets'=>'solar:wind-linear','Shoes'=>'solar:running-2-linear','Hoodies'=>'solar:t-shirt-linear'];
 foreach($categories as $c): $ic=$iconMap[$c['name']]??'solar:box-linear';
 ?>
  <button type="button" data-cat="<?=e($c['slug'])?>" class="category-tile min-w-[92px] sm:min-w-[112px] rounded-2xl p-3 text-center hover:-translate-y-0.5 transition">
    <span class="mx-auto w-12 h-12 rounded-full grid place-items-center bg-[var(--surface)] border line text-[var(--accent-soft)]"><span class="iconify text-2xl" data-icon="<?=e($ic)?>"></span></span>
    <span class="block mt-2 text-xs font-black"><?=e($c['name'])?></span>
  </button>
 <?php endforeach;?>
 </div>
</section>

<?php if(setting('home_promo_enabled','1')==='1'):?>
<section id="promoSection" class="max-w-[1480px] mx-auto px-3 sm:px-5 pb-10">
 <div class="ios-card p-6 sm:p-8 overflow-hidden"><div class="text-xs font-black tracking-[.18em] text-[var(--accent-soft)]">EXCLUSIVE OFFERS</div><h2 class="text-2xl sm:text-3xl font-black mt-2">Save more on your favourites.</h2><p class="opacity-65 mt-2 max-w-md">Curated deals, fast delivery and easy checkout.</p><a href="/category/<?=$niche?>/sale" class="inline-flex mt-5 rounded-xl bg-[var(--accent)] text-white px-4 py-3 font-black">SHOP NOW →</a></div>
</section>
<?php endif;?>

<?php
if(setting('home_widgets_enabled','1')==='1'){
 $wst=$pdo->prepare("SELECT * FROM widgets WHERE status=1 AND placement='home' AND widget_type!='banner' AND (niche=? OR niche='all' OR niche IS NULL) ORDER BY id LIMIT 8");$wst->execute([$niche]);$widgets=$wst->fetchAll();
 if($widgets):
?>
<section id="widgetsSection" class="max-w-[1480px] mx-auto px-3 sm:px-5 pb-12">
 <div class="grid md:grid-cols-2 gap-3">
 <?php foreach($widgets as $w):$wc=json_decode($w['config']??'{}',true)?:[];?>
  <div class="ios-card overflow-hidden">
   <?php if(!empty($wc['image'])):?><img src="<?=e($wc['image'])?>" alt="" class="w-full h-36 object-cover opacity-90"><?php endif;?>
   <div class="p-6"><div class="text-xs tracking-[.18em] text-[var(--accent-soft)] font-black"><?=e($w['widget_type'])?></div><h2 class="text-2xl font-black mt-1"><?=e($wc['title']??$w['name'])?></h2><div class="opacity-65 mt-2 text-sm"><?=($w['widget_type']==='html'?(string)($wc['text']??''):nl2br(e($wc['text']??'')))?></div><?php if(!empty($wc['cta_label'])):?><a href="<?=e($wc['cta_url']??'#')?>" class="inline-flex mt-5 rounded-xl grad600 text-white px-4 py-3 font-black"><?=e($wc['cta_label'])?></a><?php endif;?></div>
  </div>
 <?php endforeach;?>
 </div>
</section>
<?php endif;} ?>

<section class="max-w-[1480px] mx-auto px-3 sm:px-5 pb-24">
 <div class="grid md:grid-cols-3 gap-3">
  <a href="/articles" class="grad600 text-white rounded-[24px] p-6"><div class="text-xs uppercase tracking-[.2em] text-white/60">Knowledge</div><div class="text-2xl font-black mt-2">Articles</div><div class="text-sm text-white/70 mt-1">Guides, product tips and stories.</div></a>
  <a href="/docs" class="bg-[var(--surface-2)] border line rounded-[24px] p-6"><div class="text-xs uppercase tracking-[.2em] text-[var(--accent-soft)]">Documentation</div><div class="text-2xl font-black mt-2">Docs</div><div class="text-sm opacity-60 mt-1">Product and customer help.</div></a>
  <a href="/pages" class="bg-black text-white rounded-[24px] p-6"><div class="text-xs uppercase tracking-[.2em] text-white/60">Information</div><div class="text-2xl font-black mt-2">Pages</div><div class="text-sm text-white/60 mt-1">About, shipping, privacy and more.</div></a>
 </div>
</section>
</div>

<script>
const escapeHtml = s => String(s??'').replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
function iconFor(name){
 const map={};
 return name;
}
function productCardHTML(p){
 const sale=p.compare_price?Math.max(1,Math.round((1-(Number(p.price)/Number(p.compare_price)))*100)):0;
 return `<article class="group ios-card overflow-hidden relative">
  <div class="absolute z-20 top-3 left-3">${sale?`<span class="pill-accent text-[10px] font-black px-2.5 py-1.5 rounded-full">-${sale}%</span>`:''}</div>
  <div class="absolute z-20 top-3 right-3 flex gap-2">
    <button class="w-9 h-9 rounded-full bg-black/55 text-white backdrop-blur grid place-items-center" onclick="compareProduct(${p.id})"><span class="iconify" data-icon="solar:transfer-horizontal-linear"></span></button>
    <button class="w-9 h-9 rounded-full bg-black/55 text-white backdrop-blur grid place-items-center" onclick="location.href='/login.php'"><span class="iconify" data-icon="solar:heart-linear"></span></button>
  </div>
  <a href="/product/${encodeURIComponent(p.slug)}" class="block"><div class="aspect-square bg-[var(--surface-2)] overflow-hidden rounded-t-[24px]"><img src="${escapeHtml(p.image)}" alt="${escapeHtml(p.name)}" loading="lazy" class="w-full h-full object-cover group-hover:scale-[1.035] transition duration-500"></div></a>
  <div class="p-4"><div class="text-[10px] uppercase tracking-wider opacity-55">${escapeHtml(p.category_name)}</div><a class="block font-black mt-1 text-sm leading-5 line-clamp-2" href="/product/${encodeURIComponent(p.slug)}">${escapeHtml(p.name)}</a>
  <div class="flex items-center gap-2 mt-2 text-xs"><span class="text-amber-400 text-base">★</span><span>${Number(p.rating).toFixed(1)}</span><span class="opacity-50">(${p.review_count})</span></div>
  <div class="mt-3 flex items-end justify-between"><div><div class="text-xl font-black">${moneyJS(p.price)}</div>${p.compare_price?`<div class="text-xs line-through opacity-45">${moneyJS(p.compare_price)}</div>`:''}</div><button type="button" onclick="addQuick(${p.id})" class="w-11 h-11 rounded-2xl grad600 text-white grid place-items-center"><span class="iconify text-xl" data-icon="solar:cart-plus-linear"></span></button></div></div></article>`;
}
function moneyJS(v){return "<?=$currencySymbol = e(setting('currency_symbol','৳'))?>" + Number(v||0).toLocaleString();}
function renderCategories(cats){
 document.getElementById('categoryGrid').innerHTML=cats.map(c=>`<button type="button" data-cat="${escapeHtml(c.slug)}" class="category-tile min-w-[92px] sm:min-w-[112px] rounded-2xl p-3 text-center hover:-translate-y-0.5 transition"><span class="mx-auto w-12 h-12 rounded-full grid place-items-center bg-[var(--surface)] border line text-[var(--accent-soft)]"><span class="iconify text-2xl" data-icon="${escapeHtml(c.icon||'solar:box-linear')}"></span></span><span class="block mt-2 text-xs font-black">${escapeHtml(c.name)}</span></button>`).join('');
 document.querySelectorAll('#categoryGrid [data-cat]').forEach(btn=>btn.onclick=()=>loadHome(window.PAROKO_HOME_ACTIVE,btn.dataset.cat,true));
}
function renderProducts(products,title,append=false){document.getElementById('productSectionTitle').textContent=title;const html=products.map(productCardHTML).join('');if(append)document.getElementById('productGrid').insertAdjacentHTML('beforeend',html);else document.getElementById('productGrid').innerHTML=html;if(window.Iconify)Iconify.scan(document.getElementById('productGrid'));}
async function fetchHome(type,cat='',offset=0,limit=6){const r=await fetch(`/api/home.php?type=${encodeURIComponent(type)}&cat=${encodeURIComponent(cat)}&offset=${offset}&limit=${limit}`,{headers:{Accept:'application/json'}});return await r.json();}
async function loadHome(type,cat='',push=true){const app=document.getElementById('homeApp');app.classList.add('opacity-60','pointer-events-none');try{const d=await fetchHome(type,cat,0,6);if(!d.ok)throw new Error('Load failed');window.PAROKO_HOME_ACTIVE=type;window.PAROKO_HOME_OFFSET=d.offset+d.products.length;window.PAROKO_HOME_HAS_MORE=!!d.has_more;renderCategories(d.categories);renderProducts(d.products,cat?cat.replaceAll('-',' ').toUpperCase():`BEST SELLING ${type.toUpperCase()}`);updateLoadMore();if(document.getElementById('heroImage'))document.getElementById('heroImage').src=d.hero.image||d.theme.fallback;document.querySelectorAll('[data-niche-tab]').forEach(t=>t.classList.toggle('is-active',t.dataset.nicheTab===type));if(push)history.pushState({},'',cat?`/${type}?cat=${encodeURIComponent(cat)}`:`/${type}`)}catch(e){console.error(e)}finally{app.classList.remove('opacity-60','pointer-events-none');if(window.Iconify)Iconify.scan()}}
async function loadMore(){const btn=document.getElementById('loadMoreBtn');if(!btn||!window.PAROKO_HOME_HAS_MORE)return;const cat=new URLSearchParams(location.search).get('cat')||'';btn.disabled=true;btn.textContent='Loading...';try{const d=await fetchHome(window.PAROKO_HOME_ACTIVE,cat,window.PAROKO_HOME_OFFSET||0,6);if(d.ok){renderProducts(d.products,document.getElementById('productSectionTitle').textContent,true);window.PAROKO_HOME_OFFSET+=d.products.length;window.PAROKO_HOME_HAS_MORE=!!d.has_more}}finally{btn.disabled=false;updateLoadMore();if(window.Iconify)Iconify.scan()}}
function updateLoadMore(){const btn=document.getElementById('loadMoreBtn');if(!btn)return;btn.classList.toggle('hidden',!window.PAROKO_HOME_HAS_MORE);btn.innerHTML='Load More <span class="iconify" data-icon="solar:alt-arrow-down-linear"></span>';btn.onclick=loadMore}
window.PAROKO_HOME_OFFSET=<?=count($products)?>;window.PAROKO_HOME_HAS_MORE=true;updateLoadMore();
document.querySelectorAll('[data-niche-tab]').forEach(t=>t.classList.toggle('is-active',t.dataset.nicheTab===type));
   if(push){history.pushState({},'',cat?`/${type}?cat=${encodeURIComponent(cat)}`:`/${type}`);}
 }catch(e){console.error(e)}
 finally{app.classList.remove('opacity-60','pointer-events-none');if(window.Iconify)Iconify.scan();}
}
document.querySelectorAll('[data-niche-tab]').forEach(tab=>tab.addEventListener('click',e=>{e.preventDefault();loadHome(tab.dataset.nicheTab,'',true)}));
window.addEventListener('popstate',()=>{const seg=location.pathname.split('/').filter(Boolean);const t=['gadgets','jersey','fashion'].includes(seg[0])?seg[0]:'gadgets';const c=new URLSearchParams(location.search).get('cat')||'';loadHome(t,c,false)});
</script>
<?php require __DIR__.'/includes/footer.php'; ?>
