<?php
$title='Settings';require __DIR__.'/inc/header.php';$pdo=db();$message='';
$keys=['store_name','store_phone','whatsapp','shipping_inside','shipping_outside','printing_charge','announcement','currency','currency_symbol','site_tagline','social_facebook','social_instagram','social_youtube','social_tiktok','social_whatsapp','payment_enabled','payment_bkash_key','payment_bkash_secret','payment_nagad_key','payment_nagad_secret','payment_ssl_key','payment_ssl_secret','meta_pixel_id','meta_capi_token','google_analytics','seo_robots','theme_mode','theme_preset','theme_accent','theme_light_card'];

if(is_post()){
 verify_csrf();
 $a=(string)post('action','save');
 if($a==='save_typography'){
   foreach(['typography_font','typography_base','typography_heading_weight','ui_preset','ui_radius'] as $k)
      $pdo->prepare('INSERT INTO settings(key,value) VALUES(?,?) ON CONFLICT(key) DO UPDATE SET value=excluded.value')->execute([$k,(string)post($k)]);
   flash('success','Typography settings saved.');redirect('/admin/settings.php');
 }
 $st=$pdo->prepare('INSERT INTO settings(key,value) VALUES(?,?) ON CONFLICT(key) DO UPDATE SET value=excluded.value');
 foreach($keys as $k)$st->execute([$k,(string)post($k,'')]);
 foreach(['logo_file'=>'logo_url','favicon_file'=>'favicon_url'] as $input=>$settingKey){
   if(!empty($_FILES[$input]['name'])){
      try{$u=save_public_upload($_FILES[$input],['jpg','jpeg','png','webp','gif','svg','ico'],12000000,'site');$st->execute([$settingKey,$u['path']]);}
      catch(Throwable $e){$message=$e->getMessage();}
   }
 }
 flash('success','Settings saved.');redirect('/admin/settings.php');
}
$v=[];foreach($keys as $k)$v[$k]=setting($k);
$logo=setting('logo_url');$favicon=setting('favicon_url');
?>
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6"><div><div class="text-xs tracking-[.2em] text-slate-400 font-black">CONFIGURATION</div><h1 class="text-3xl font-black">Settings</h1><p class="text-sm text-slate-500 mt-1">Site identity, visual system, payments, social links and analytics.</p></div></div>
<?php if($message):?><div class="mb-4 bg-rose-50 text-rose-700 border border-rose-100 p-3 rounded-xl"><?=e($message)?></div><?php endif;?>

<form method="post" enctype="multipart/form-data" class="space-y-6"><?=csrf_input()?><input type="hidden" name="action" value="save">
<div class="grid lg:grid-cols-2 gap-6">

<div class="bg-white border rounded-2xl p-5 soft">
 <div class="font-black text-lg">Visual Theme Preset</div>
 <p class="text-sm text-slate-500 mt-1">Choose the storefront base. No rainbow colors — one controlled accent system.</p>
 <div class="grid grid-cols-2 gap-3 mt-4">
  <label class="rounded-2xl border p-4 cursor-pointer"><input class="sr-only" type="radio" name="theme_mode" value="dark" <?=$v['theme_mode']==='dark'?'checked':''?>><span class="block rounded-xl h-16 bg-[#070b0b] border border-white/10"></span><b class="block mt-2">Dark</b></label>
  <label class="rounded-2xl border p-4 cursor-pointer"><input class="sr-only" type="radio" name="theme_mode" value="light" <?=$v['theme_mode']==='light'?'checked':''?>><span class="block rounded-xl h-16 bg-[#fbfaf4] border border-[#eadfc5]"></span><b class="block mt-2">Light</b></label>
 </div>
 <select name="theme_preset" class="w-full rounded-xl border-slate-200 mt-3">
  <option value="teal600" <?=$v['theme_preset']==='teal600'?'selected':''?>>Teal 600 · #588580 (recommended)</option>
  <option value="blue600" <?=$v['theme_preset']==='blue600'?'selected':''?>>Blue 600</option>
  <option value="violet600" <?=$v['theme_preset']==='violet600'?'selected':''?>>Violet 600</option>
  <option value="gold600" <?=$v['theme_preset']==='gold600'?'selected':''?>>Gold 600</option>
 </select>
 <div class="grid grid-cols-2 gap-3 mt-3"><input name="theme_accent" value="<?=e($v['theme_accent'] ?: '#588580')?>" class="rounded-xl border-slate-200" placeholder="Accent hex"><input name="theme_light_card" value="<?=e($v['theme_light_card'] ?: '#f7efd9')?>" class="rounded-xl border-slate-200" placeholder="Light card hex"></div>
</div>

<div class="bg-white border rounded-2xl p-5 soft">
 <div class="font-black text-lg">Site Identity</div><div class="space-y-3 mt-4">
  <input name="store_name" value="<?=e($v['store_name'])?>" class="w-full rounded-xl border-slate-200" placeholder="Site name">
  <input name="site_tagline" value="<?=e($v['site_tagline'])?>" class="w-full rounded-xl border-slate-200" placeholder="Tagline">
  <div><label class="text-xs font-bold text-slate-500">Logo</label><input type="file" name="logo_file" accept="image/*,.svg,.ico" class="mt-1 w-full rounded-xl border p-3"></div>
  <?php if($logo):?><img src="<?=e($logo)?>" class="h-12 max-w-48 object-contain border rounded-xl bg-slate-50 p-2"><?php endif;?>
  <div><label class="text-xs font-bold text-slate-500">Favicon</label><input type="file" name="favicon_file" accept="image/*,.ico" class="mt-1 w-full rounded-xl border p-3"></div>
  <?php if($favicon):?><img src="<?=e($favicon)?>" class="w-10 h-10 object-contain border rounded-xl bg-slate-50 p-2"><?php endif;?>
  <input name="store_phone" value="<?=e($v['store_phone'])?>" class="w-full rounded-xl border-slate-200" placeholder="Phone">
  <input name="whatsapp" value="<?=e($v['whatsapp'])?>" class="w-full rounded-xl border-slate-200" placeholder="WhatsApp">
 </div>
</div>

<div class="bg-white border rounded-2xl p-5 soft">
 <div class="font-black text-lg">Currency & Delivery</div>
 <div class="grid grid-cols-2 gap-2 mt-4"><select name="currency" class="rounded-xl border-slate-200"><option <?=($v['currency']==='BDT'?'selected':'')?>>BDT</option><option <?=($v['currency']==='INR'?'selected':'')?>>INR</option><option <?=($v['currency']==='USD'?'selected':'')?>>USD</option></select><input name="currency_symbol" value="<?=e($v['currency_symbol'])?>" class="rounded-xl border-slate-200" placeholder="Symbol"></div>
 <div class="grid grid-cols-3 gap-2 mt-3"><input name="shipping_inside" value="<?=e($v['shipping_inside'])?>" class="rounded-xl border-slate-200" placeholder="Inside BD"><input name="shipping_outside" value="<?=e($v['shipping_outside'])?>" class="rounded-xl border-slate-200" placeholder="Outside BD"><input name="printing_charge" value="<?=e($v['printing_charge'])?>" class="rounded-xl border-slate-200" placeholder="Jersey print"></div>
 <textarea name="announcement" class="w-full rounded-xl border-slate-200 min-h-20 mt-3" placeholder="Top announcement"><?=e($v['announcement'])?></textarea>
</div>

<div class="bg-white border rounded-2xl p-5 soft"><div class="font-black text-lg">Social Links</div><div class="space-y-2 mt-4"><?php foreach(['facebook','instagram','youtube','tiktok','whatsapp'] as $s):?><input name="social_<?=$s?>" value="<?=e($v['social_'.$s])?>" class="w-full rounded-xl border-slate-200" placeholder="<?=ucfirst($s)?> URL"><?php endforeach;?></div></div>

<div class="bg-white border rounded-2xl p-5 soft">
 <div class="font-black text-lg">Payments & API Keys</div>
 <input name="payment_enabled" value="<?=e($v['payment_enabled'])?>" class="w-full mt-4 rounded-xl border-slate-200" placeholder="cod,bkash,nagad,rocket,sslcommerz">
 <div class="grid sm:grid-cols-2 gap-2 mt-3"><?php foreach(['payment_bkash_key','payment_bkash_secret','payment_nagad_key','payment_nagad_secret','payment_ssl_key','payment_ssl_secret'] as $k):?><input type="password" name="<?=$k?>" value="<?=e($v[$k])?>" class="rounded-xl border-slate-200" placeholder="<?=ucwords(str_replace('_',' ',$k))?>"><?php endforeach;?></div>
</div>

<div class="bg-white border rounded-2xl p-5 soft"><div class="font-black text-lg">SEO / Analytics</div><div class="grid sm:grid-cols-2 gap-2 mt-4"><input name="meta_pixel_id" value="<?=e($v['meta_pixel_id'])?>" class="rounded-xl border-slate-200" placeholder="Meta Pixel ID"><input name="google_analytics" value="<?=e($v['google_analytics'])?>" class="rounded-xl border-slate-200" placeholder="Google Analytics ID"><input name="meta_capi_token" value="<?=e($v['meta_capi_token'])?>" class="rounded-xl border-slate-200 sm:col-span-2" placeholder="Meta CAPI token"><select name="seo_robots" class="rounded-xl border-slate-200 sm:col-span-2"><option value="index,follow" <?=($v['seo_robots']==='index,follow'?'selected':'')?>>Index, Follow</option><option value="noindex,follow" <?=($v['seo_robots']==='noindex,follow'?'selected':'')?>>Noindex, Follow</option><option value="noindex,nofollow" <?=($v['seo_robots']==='noindex,nofollow'?'selected':'')?>>Noindex, Nofollow</option></select></div></div>

</div>
<button class="shine grad600 text-white w-full py-3 rounded-xl font-black">Save All Settings</button>
</form>

<div class="mt-6 bg-white border rounded-2xl p-5 soft"><div class="font-black text-lg">Typography</div><form method="post" class="mt-4 grid sm:grid-cols-2 lg:grid-cols-5 gap-3"><?=csrf_input()?><input type="hidden" name="action" value="save_typography"><select name="typography_font" class="rounded-xl border-slate-200"><?php foreach(['Inter','Manrope','Plus Jakarta Sans','DM Sans'] as $font):?><option <?=$font===setting('typography_font','Inter')?'selected':''?>><?=$font?></option><?php endforeach;?></select><select name="typography_base" class="rounded-xl border-slate-200"><?php foreach(['14','15','16','17','18'] as $x):?><option value="<?=$x?>" <?=setting('typography_base','16')===$x?'selected':''?>>Base <?=$x?>px</option><?php endforeach;?></select><select name="typography_heading_weight" class="rounded-xl border-slate-200"><?php foreach(['600','700','800','900'] as $x):?><option value="<?=$x?>" <?=setting('typography_heading_weight','800')===$x?'selected':''?>>Heading <?=$x?></option><?php endforeach;?></select><select name="ui_preset" class="rounded-xl border-slate-200"><option value="gradient600" <?=setting('ui_preset','gradient600')==='gradient600'?'selected':''?>>Gradient 600</option><option value="dark" <?=setting('ui_preset')==='dark'?'selected':''?>>Dark</option><option value="glass" <?=setting('ui_preset')==='glass'?'selected':''?>>Glass</option></select><select name="ui_radius" class="rounded-xl border-slate-200"><?php foreach(['12','16','18','22','28'] as $x):?><option value="<?=$x?>" <?=setting('ui_radius','18')===$x?'selected':''?>>Radius <?=$x?>px</option><?php endforeach;?></select><button class="grad600 text-white rounded-xl py-3 font-black sm:col-span-2 lg:col-span-5">Save Typography</button></form></div>

<?php require __DIR__.'/inc/footer.php'; ?>
