<?php
$flash=flashes();
$niche=current_niche();
$themeMode=setting('theme_mode','dark');
$themePreset=setting('theme_preset','teal600');
$themes=[
 'teal600'=>['accent'=>'#588580','accentSoft'=>'#86aaa5','gold'=>'#d8b35a'],
 'blue600'=>['accent'=>'#2563eb','accentSoft'=>'#60a5fa','gold'=>'#d2ad62'],
 'violet600'=>['accent'=>'#7c3aed','accentSoft'=>'#a78bfa','gold'=>'#d2ad62'],
 'gold600'=>['accent'=>'#c79a38','accentSoft'=>'#e0bd6c','gold'=>'#d8b35a'],
];
$tc=$themes[$themePreset]??$themes['teal600'];
?>
<!doctype html>
<html lang="en" data-theme="<?=e($themeMode)?>">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=e($title ?? APP_NAME)?> · <?=APP_NAME?></title>
<meta name="description" content="<?=e($meta_description ?? setting('site_description','Gadgets, jerseys and fashion in one modern store.'))?>">
<meta name="keywords" content="<?=e($meta_keywords ?? setting('site_keywords','gadgets, jersey, fashion, Bangladesh'))?>">
<meta name="robots" content="<?=e(setting('seo_robots','index,follow'))?>">
<link rel="canonical" href="<?=e($canonical ?? (APP_URL!==''?APP_URL:((isset($_SERVER['REQUEST_SCHEME'])?$_SERVER['REQUEST_SCHEME']:'http').'://'.($_SERVER['HTTP_HOST']??'localhost').($_SERVER['REQUEST_URI']??'/'))) )?>">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
:root{
 --paroko-font:'<?=e(setting('typography_font','Inter'))?>',Inter,ui-sans-serif,system-ui,sans-serif;
 --paroko-base:<?=e(setting('typography_base','16'))?>px;
 --paroko-radius:<?=e(setting('ui_radius','18'))?>px;
 --accent:<?=$tc['accent']?>;--accent-soft:<?=$tc['accentSoft']?>;--gold:<?=$tc['gold']?>;
 --bg:#070b0b;--surface:#0f1716;--surface-2:#131e1d;--text:#f8fafc;--muted:#9ca3af;--line:rgba(255,255,255,.10);--card-bg:#101817;
}
html[data-theme="light"]{--bg:#fbfaf4;--surface:#ffffff;--surface-2:#fffaf0;--text:#101010;--muted:#6b7280;--line:#e8e0ce;--card-bg:#fff9eb}
*{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;font-family:var(--paroko-font);font-size:var(--paroko-base);background:var(--bg);color:var(--text)}a{color:inherit}
.glass{background:color-mix(in srgb,var(--surface) 88%,transparent);backdrop-filter:blur(18px)}
.soft{box-shadow:0 18px 60px rgba(0,0,0,.22)}
html[data-theme="light"] .soft{box-shadow:0 16px 55px rgba(54,43,17,.09)}
.line{border-color:var(--line)}
.grad600{background:linear-gradient(135deg,#050606 0%,var(--accent) 68%,var(--gold) 120%)}
.grad600b{background:linear-gradient(135deg,var(--accent) 0%,#14211f 80%)}
.shine{position:relative;overflow:hidden}
.ios-card{position:relative;border-radius:24px;background:var(--card-bg);border:1px solid color-mix(in srgb,var(--accent) 46%,transparent);box-shadow:inset 0 1px 0 rgba(255,255,255,.08),0 16px 45px rgba(0,0,0,.18)}
.ios-card:before{content:"";position:absolute;inset:-1px;border-radius:25px;padding:1px;background:linear-gradient(140deg,rgba(255,255,255,.66),color-mix(in srgb,var(--accent) 72%,transparent),transparent 42%,rgba(255,255,255,.16));-webkit-mask:linear-gradient(#000 0 0) content-box,linear-gradient(#000 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none}
html[data-theme="dark"] .bg-white{background-color:var(--surface)!important}html[data-theme="dark"] .bg-slate-50{background-color:var(--surface-2)!important}html[data-theme="dark"] .bg-slate-100{background-color:color-mix(in srgb,var(--surface-2) 86%,#000)!important}html[data-theme="dark"] .text-slate-900,html[data-theme="dark"] .text-slate-800,html[data-theme="dark"] .text-slate-700{color:var(--text)!important}html[data-theme="dark"] .text-slate-600,html[data-theme="dark"] .text-slate-500,html[data-theme="dark"] .text-slate-400{color:var(--muted)!important}html[data-theme="dark"] .border-slate-200,html[data-theme="dark"] .border-slate-100{border-color:var(--line)!important}html[data-theme="dark"] input,html[data-theme="dark"] select,html[data-theme="dark"] textarea{background:var(--surface-2)!important;color:var(--text)!important;border-color:var(--line)!important;padding:12px 14px!important;font-size:14px!important;min-height:44px!important}
html[data-theme="light"] input,html[data-theme="light"] select,html[data-theme="light"] textarea{padding:12px 14px!important;font-size:14px!important;min-height:44px!important}html[data-theme="dark"] .text-slate-900,html[data-theme="dark"] .text-slate-800,html[data-theme="dark"] .text-slate-700{color:var(--text)!important}html[data-theme="dark"] .text-slate-600,html[data-theme="dark"] .text-slate-500,html[data-theme="dark"] .text-slate-400{color:var(--muted)!important}html[data-theme="dark"] .border-slate-200,html[data-theme="dark"] .border-slate-100{border-color:var(--line)!important}html[data-theme="dark"] input,html[data-theme="dark"] select,html[data-theme="dark"] textarea{background:var(--surface-2)!important;color:var(--text)!important;border-color:var(--line)!important;padding:12px 14px!important}
html[data-theme="light"] .ios-card{background:linear-gradient(180deg,#fffdf8,#f7efd9);border-color:rgba(199,154,56,.28);box-shadow:inset 0 1px 0 #fff,0 14px 40px rgba(71,52,15,.08)}
html[data-theme="light"] .ios-card:before{background:linear-gradient(140deg,#fff,rgba(199,154,56,.55),transparent 48%,rgba(0,0,0,.08))}
.pill-accent{background:color-mix(in srgb,var(--accent) 24%,transparent);color:var(--accent-soft);border:1px solid color-mix(in srgb,var(--accent) 32%,transparent)}
html[data-theme="light"] .pill-accent{background:#f2e3bb;color:#7c5c10;border-color:#dfc98d}
.category-tile{background:color-mix(in srgb,var(--surface) 86%,transparent);border:1px solid var(--line)}
html[data-theme="light"] .category-tile{background:#fffdf7;border-color:#eee2c8}
.hide-scrollbar::-webkit-scrollbar{display:none}.hide-scrollbar{scrollbar-width:none}
</style>
</head>
<body x-data="{mobile:false}">
<div class="bg-black text-white text-xs sm:text-sm text-center py-2 px-4"> <?=e(setting('announcement'))?></div>

<header class="z-40 glass border-b line">
 <div class="max-w-[1480px] mx-auto px-3 sm:px-5">
  <div class="h-16 flex items-center gap-2">
   <button class="lg:hidden p-2 rounded-xl" @click="mobile=!mobile"><span class="iconify text-xl" data-icon="solar:hamburger-menu-linear"></span></button>
   <a href="/" class="shrink-0 flex items-center gap-2">
    <div class="w-10 h-10 rounded-2xl grad600 text-white grid place-items-center shadow-lg"><span class="iconify text-xl" data-icon="solar:bag-2-bold-duotone"></span></div>
    <div class="leading-none"><div class="font-black text-[20px] tracking-tight">PAROKO</div><div class="text-[9px] mt-1 opacity-60">GEAR UP. PLAY ON.</div></div>
   </a>
   <div class="hidden md:block flex-1 max-w-2xl mx-auto">
    <form action="/search.php" class="relative"><input name="q" value="<?=e((string)get('q',''))?>" placeholder="Search gadgets, accessories..." class="w-full h-11 rounded-2xl border line bg-[var(--surface-2)] pl-11 pr-12 outline-none focus:ring-2 focus:ring-[color:var(--accent)]/40"><span class="iconify absolute left-4 top-3 text-xl opacity-60" data-icon="solar:magnifer-linear"></span><span class="iconify absolute right-4 top-3 text-xl opacity-60" data-icon="solar:tuning-2-linear"></span></form>
   </div>
   <div class="ml-auto flex items-center gap-1">
    <a href="/wishlist.php" class="hidden sm:grid w-10 h-10 place-items-center rounded-xl hover:bg-white/5 relative"><span class="iconify text-2xl" data-icon="solar:heart-linear"></span><span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white min-w-4 h-4 rounded-full text-[9px] grid place-items-center">3</span></a>
    <button type="button" id="themeToggle" class="grid w-10 h-10 place-items-center rounded-xl hover:bg-white/5"><span id="themeIcon" class="iconify text-2xl" data-icon="solar:moon-linear"></span></button>
    <a href="/cart.php" class="relative grid w-10 h-10 place-items-center rounded-xl hover:bg-white/5"><span class="iconify text-2xl" data-icon="solar:cart-large-2-linear"></span><span id="cartCount" class="absolute -top-0.5 -right-0.5 bg-red-500 text-white min-w-4 h-4 rounded-full text-[9px] grid place-items-center"><?=cart_count()?></span></a>
    <?php if(user()): ?><a href="<?=admin()?'/admin/index.php':'/account.php'?>" class="hidden sm:grid w-10 h-10 place-items-center rounded-xl"><span class="iconify text-2xl" data-icon="solar:user-linear"></span></a><?php else: ?><a href="/login.php" class="hidden sm:block text-sm font-bold px-3">Login</a><?php endif; ?>
   </div>
  </div>

  <div id="nicheTabs" class="grid grid-cols-3 overflow-hidden rounded-2xl border line">
   <?php
   $tabs=[
     'gadgets'=>['solar:headphones-round-linear','Smart Tech'],
     'jersey'=>['solar:shirt-linear','Club, National & Custom'],
     'fashion'=>['solar:t-shirt-linear','Clothing & Lifestyle']
   ];
   foreach($tabs as $key=>$tab):
   ?>
   <a href="/<?=$key?>" data-niche-tab="<?=$key?>" class="niche-tab group px-2 sm:px-5 py-3 sm:py-3.5 border-r last:border-r-0 line <?=($niche===$key?'is-active':'')?>">
     <div class="flex items-center justify-center gap-2"><span class="iconify text-xl sm:text-2xl" data-icon="<?=$tab[0]?>"></span><span class="text-left"><b class="block text-xs sm:text-sm"><?=ucfirst($key)?></b><small class="hidden sm:block text-[10px] opacity-60 mt-0.5"><?=$tab[1]?></small></span></div>
   </a>
   <?php endforeach;?>
  </div>

  <div class="hidden lg:flex justify-center gap-7 py-2 text-xs opacity-70"><a href="/">Home</a><a href="/articles">Articles</a><a href="/docs">Docs</a><a href="/pages">Pages</a><a href="/category/<?=$niche?>/best">Best Sellers</a><a href="/category/<?=$niche?>/sale">Offers</a><a href="/track.php">Track Order</a></div>
  <div class="md:hidden py-2"><form action="/search.php" class="relative"><input name="q" placeholder="Search gadgets, accessories..." class="w-full h-10 rounded-2xl border line bg-[var(--surface-2)] pl-10 pr-10"><span class="iconify absolute left-3 top-2.5 text-lg opacity-60" data-icon="solar:magnifer-linear"></span><span class="iconify absolute right-3 top-2.5 text-lg opacity-60" data-icon="solar:tuning-2-linear"></span></form></div>
  <div x-show="mobile" x-cloak class="lg:hidden fixed inset-y-0 left-0 w-64 bg-[var(--surface)] border-r line overflow-y-auto z-50 p-4"><div class="space-y-2"><a class="block p-3 rounded-xl hover:bg-[var(--surface-2)] transition" href="/">Home</a><a class="block p-3 rounded-xl hover:bg-[var(--surface-2)] transition" href="/articles">Articles</a><a class="block p-3 rounded-xl hover:bg-[var(--surface-2)] transition" href="/docs">Docs</a><a class="block p-3 rounded-xl hover:bg-[var(--surface-2)] transition" href="/category/<?=$niche?>">Browse</a><a class="block p-3 rounded-xl hover:bg-[var(--surface-2)] transition" href="/category/<?=$niche?>/best">Best Sellers</a><a class="block p-3 rounded-xl hover:bg-[var(--surface-2)] transition" href="/category/<?=$niche?>/sale">Offers</a><a class="block p-3 rounded-xl hover:bg-[var(--surface-2)] transition" href="/track.php">Track Order</a><hr class="border-line my-3"><a class="block p-3 rounded-xl hover:bg-[var(--surface-2)] transition" href="/account.php">My Account</a></div></div><div x-show="mobile" @click="mobile=false" class="lg:hidden fixed inset-0 bg-black/20 z-40" x-cloak></div>
 </div>
</header>

<style>
.niche-tab{background:var(--surface);color:var(--text);transition:.2s}
.niche-tab.is-active{background:var(--accent);color:#fff;box-shadow:inset 0 -2px 0 rgba(255,255,255,.35)}
html[data-theme="light"] .niche-tab.is-active{background:var(--gold);color:#161616}
.niche-tab.is-active:after{content:"";display:block;margin:-1px auto -10px;width:20px;height:10px;background:currentColor;clip-path:polygon(50% 100%,0 0,100% 0);opacity:.9}
</style>
<script>
document.getElementById('themeToggle')?.addEventListener('click', function() {
  const html = document.documentElement;
  const isDark = html.getAttribute('data-theme') === 'dark';
  const newTheme = isDark ? 'light' : 'dark';
  html.setAttribute('data-theme', newTheme);
  localStorage.setItem('paroko-theme', newTheme);
  const icon = document.getElementById('themeIcon');
  icon.setAttribute('data-icon', newTheme === 'dark' ? 'solar:sun-linear' : 'solar:moon-linear');
});
const savedTheme = localStorage.getItem('paroko-theme') || 'dark';
document.documentElement.setAttribute('data-theme', savedTheme);
document.getElementById('themeIcon').setAttribute('data-icon', savedTheme === 'dark' ? 'solar:sun-linear' : 'solar:moon-linear');
</script>
<?php foreach($flash as $f): ?><div class="max-w-[1480px] mx-auto px-3 sm:px-5 pt-3"><div class="rounded-2xl px-4 py-3 text-sm <?=($f['type']==='success'?'bg-emerald-100 text-emerald-900':'bg-rose-100 text-rose-800')?>"><?=e($f['message'])?></div></div><?php endforeach; ?>
<main class="min-h-screen">
<script>
window.PAROKO_THEME={mode:<?=json_encode($themeMode)?>,accent:<?=json_encode($tc['accent'])?>};
window.PAROKO_HOME_ACTIVE="<?=e($niche)?>";
</script>
