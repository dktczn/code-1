<article class="group ios-card overflow-hidden relative">
 <div class="absolute z-20 top-3 left-3"><?php if($p['compare_price']):?><span class="pill-accent text-[10px] font-black px-2.5 py-1.5 rounded-full">-<?=(int)round((1-((float)$p['price']/(float)$p['compare_price']))*100)?>%</span><?php endif;?></div>
 <div class="absolute z-20 top-3 right-3 flex gap-2">
  <button type="button" onclick="compareProduct(<?=$p['id']?>)" class="w-9 h-9 rounded-full text-[var(--text)] grid place-items-center hover:text-[var(--accent-soft)] transition"><span class="iconify" data-icon="solar:transfer-horizontal-linear"></span></button>
  <form method="post" action="/wishlist.php" class="contents"><?=csrf_input()?><input type="hidden" name="product_id" value="<?=$p['id']?>"><button type="submit" class="w-9 h-9 rounded-full text-[var(--text)] grid place-items-center hover:text-red-500 transition"><span class="iconify" data-icon="solar:heart-linear"></span></button></form>
 </div>
 <a href="/product/<?=e($p['slug'])?>" class="block relative">
   <div class="aspect-square bg-[var(--surface-2)] overflow-hidden rounded-t-[24px]">
     <img src="https://picsum.photos/400/400?random=<?=$p['id']?>" alt="<?=e($p['name'])?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-[1.035] transition duration-500">
   </div>
 </a>
 <div class="p-4 sm:p-4">
   <a class="block font-black mt-1 text-sm sm:text-[15px] leading-5 line-clamp-2" href="/product/<?=e($p['slug'])?>"><?=e($p['name'])?></a>
   <div class="flex items-center gap-2 mt-2 text-xs"><span class="text-amber-400 text-base leading-none">★</span><span><?=number_format((float)$p['rating'],1)?></span><span class="opacity-50">(<?=$p['review_count']?>)</span></div>
   <div class="mt-3 flex items-end justify-between gap-2">
     <div><div class="text-xl font-black"><?=money($p['price'])?></div><?php if($p['compare_price']):?><div class="text-xs line-through opacity-45 mt-0.5"><?=money($p['compare_price'])?></div><?php endif;?></div>
     <button type="button" onclick="addQuick(<?=$p['id']?>)" class="w-11 h-11 rounded-2xl text-[var(--accent-soft)] grid place-items-center hover:scale-105 transition"><span class="iconify text-xl" data-icon="solar:cart-plus-linear"></span></button>
   </div>
 </div>
</article>
